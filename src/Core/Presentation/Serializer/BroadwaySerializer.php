<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Serializer;

use Assert\Assertion as Assert;
use Broadway\Serializer\SerializationException;
use Broadway\Serializer\Serializer;
use Exception;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class BroadwaySerializer implements Serializer
{
    public function __construct(
        private SerializerInterface $serializer,
        private string $format = 'json',
        private array $ignoredAttributes = [
            'uncommittedEvents',
            'childEntities',
            'playhead',
        ]
    ) {
    }

    public function serialize($object): array
    {
        try {
            return [
                'class'   => $object::class,
                'payload' => $this->serializer->serialize(
                    $object,
                    $this->format,
                    $this->createContext()
                ),
            ];
        } catch (Exception $exception) {
            throw new SerializationException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function deserialize(array $serializedObject)
    {
        try {
            /** @noinspection PhpUnhandledExceptionInspection */
            Assert::keyExists($serializedObject, 'class', "Key 'class' should be set.");
            /** @noinspection PhpUnhandledExceptionInspection */
            Assert::keyExists($serializedObject, 'payload', "Key 'payload' should be set.");

            return $this->serializer->deserialize(
                is_array($serializedObject['payload'])
                    ? $this->serializer->serialize($serializedObject['payload'], $this->format)
                    : $serializedObject['payload'],
                $serializedObject['class'],
                $this->format,
                $this->createContext()
            );
        } catch (Exception $exception) {
            throw new SerializationException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    private function createContext(): array
    {
        return [AbstractNormalizer::IGNORED_ATTRIBUTES => $this->ignoredAttributes];
    }
}
