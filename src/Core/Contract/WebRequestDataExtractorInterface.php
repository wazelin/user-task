<?php

declare(strict_types=1);

namespace Wazelin\UserTask\Core\Contract;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

interface WebRequestDataExtractorInterface
{
    /**
     * @param Request $request
     * @return array
     *
     * @throws BadRequestException
     */
    public function extract(Request $request): array;
}
