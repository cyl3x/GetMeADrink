<?php declare(strict_types=1);

namespace App\Serializer;

use App\Exception\HttpException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HttpExceptionNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.problem')]
        private NormalizerInterface $normalizer,
    ) {
    }

    /**
     * @param FlattenException $flattenException
     *
     * @return array<string, mixed>
     */
    public function normalize(mixed $flattenException, ?string $format = null, array $context = []): array
    {
        $exception = $context['exception'] ?? new HttpException();

        $data = $this->normalizer->normalize($flattenException, $format, $context);

        $data['code'] = $exception->getErrorCode();
        $data['meta'] = ['parameters' => $exception->getParameters()];

        return $data;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof FlattenException && $context['exception'] instanceof HttpException;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [FlattenException::class => true];
    }
}
