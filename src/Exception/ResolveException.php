<?php declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class ResolveException extends HttpException
{
    public function __construct(string $classOrProp, string $reason, ?\Throwable $e = null)
    {
        $message = \sprintf('Unable to resolve %s: %s', $classOrProp, $reason);

        parent::__construct(
            $message,
            [],
            $e,
        );
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function getErrorCode(): string
    {
        return self::CODE_RESOLVE_ERROR;
    }
}
