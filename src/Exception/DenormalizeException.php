<?php declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\PartialDenormalizationException;

class DenormalizeException extends HttpException
{
    public function __construct(
        string $class,
        PartialDenormalizationException $e,
    ) {
        $violations = [];

        foreach ($e->getErrors() as $exception) {
            $parameters = [];

            if ($exception->canUseMessageForUser()) {
                $parameters['hint'] = $exception->getMessage();
            }

            $violations[] = [
                'message' => \sprintf('The type must be one of "%s" ("%s" given).', implode(', ', $exception->getExpectedTypes()), $exception->getCurrentType()),
                'parameters' => $parameters,
                'path' => $exception->getPath(),
            ];
        }

        parent::__construct(
            \sprintf('Violations occured denormalizing %s', $class),
            ['violations' => $violations, 'class' => $class],
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
