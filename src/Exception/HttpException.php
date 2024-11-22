<?php declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception;

class HttpException extends Exception\HttpException
{
    public const CODE_GENERIC_ERROR = 'GENERIC_ERROR';
    public const CODE_RESOLVE_ERROR = 'RESOLVE';
    public const CODE_DENORMALIZE_ERROR = 'DENORMALIZE';

    /**
     * @param mixed[] $parameters
     */
    public function __construct(
        string $message = 'An error occurred',
        private array $parameters = [],
        ?\Throwable $e = null,
    ) {
        parent::__construct($this->getStatusCode(), $message, $e);
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    public function getErrorCode(): string
    {
        return self::CODE_GENERIC_ERROR;
    }

    /**
     * @return mixed[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
