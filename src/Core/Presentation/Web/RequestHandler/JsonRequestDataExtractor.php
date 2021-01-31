<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Presentation\Web\RequestHandler;

use JsonException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Wazelin\UserTask\Core\Contract\WebRequestDataExtractorInterface;

final class JsonRequestDataExtractor implements WebRequestDataExtractorInterface
{
    private const DECODE_FLAGS = JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR;

    public function extract(Request $request): array
    {
        try {
            $data = json_decode($request->getContent(), flags: self::DECODE_FLAGS);
        } catch (JsonException) {
            throw new BadRequestException('JSON content is expected.');
        }

        if (!is_array($data)) {
            throw new BadRequestException('Scalar data is not expected.');
        }

        return $data;
    }
}
