<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Serializer\Normalizer;

use ReflectionClass;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Wazelin\UserTask\Core\Contract\DomainIterator;

class IteratorObjectNormalizer implements ContextAwareNormalizerInterface,
                                          DenormalizerInterface,
                                          NormalizerAwareInterface,
                                          DenormalizerAwareInterface
{
    use NormalizerAwareTrait;
    use DenormalizerAwareTrait;

    public function normalize($object, string $format = null, array $context = []): array
    {
        $data = [];

        foreach ($object as $item) {
            $data[] = $this->normalizer->supportsNormalization($item, $format)
                ? $this->normalizer->normalize($item, $format, $context)
                : $item;
        }

        return $data;
    }

    public function denormalize($data, string $type, string $format = null, array $context = []): DomainIterator
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $iteratorReflection   = new ReflectionClass($type);
        $constructorParameter = $iteratorReflection->getConstructor()?->getParameters()[0] ?? null;

        if (!$constructorParameter) {
            return new $type();
        }

        $elementType = (string)$constructorParameter->getType();

        return new $type(
            ...array_map(
                   function ($item) use ($elementType, $format, $context): mixed {
                       return $this->denormalizer->supportsDenormalization($item, $elementType, $format)
                           ? $this->denormalizer->denormalize($item, $elementType, $format, $context)
                           : $item;
                   },
                   $data
               )
        );
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof DomainIterator;
    }

    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return is_a($type, DomainIterator::class, true) && is_array($data[0] ?? null);
    }
}
