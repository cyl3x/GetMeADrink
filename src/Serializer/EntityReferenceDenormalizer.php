<?php declare(strict_types=1);

namespace App\Serializer;

use App\Entity\ProductCategoryEntity;
use App\Entity\ProductEntity;
use App\Entity\ProductVariantEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class EntityReferenceDenormalizer implements DenormalizerInterface
{
    private const ENTITIES = [
        ProductEntity::class,
        ProductCategoryEntity::class,
        ProductVariantEntity::class,
    ];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return $this->entityManager->getReference($type, $data['id'] ?? $data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if (!\in_array($type, self::ENTITIES, true)) {
            return false;
        }

        if (\is_int($data)) {
            return true;
        }

        if (\is_array($data) && isset($data['id'])) {
            return true;
        }

        return false;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
