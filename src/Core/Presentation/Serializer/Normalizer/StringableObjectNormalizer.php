<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Serializer\Normalizer;

use Stringable;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class StringableObjectNormalizer implements ContextAwareNormalizerInterface, DenormalizerInterface
{
    public function normalize($object, string $format = null, array $context = []): string
    {
        return (string)$object;
    }

    public function denormalize($data, string $type, string $format = null, array $context = []): Stringable
    {
        return new $type($data);
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Stringable;
    }

    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return is_a($type, Stringable::class, true);
    }
}
