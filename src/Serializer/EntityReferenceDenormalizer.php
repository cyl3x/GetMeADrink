<?php declare(strict_types=1);

namespace App\Serializer;

use App\Entity\ProductCategoryEntity;
use App\Entity\ProductEntity;
use App\Entity\ProductVariantEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EntityReferenceDenormalizer implements DenormalizerInterface
{
    private const ENTITIES = [
        ProductEntity::class,
        ProductCategoryEntity::class,
        ProductVariantEntity::class,
    ];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly ObjectNormalizer $objectNormalizer,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $entity = $this->entityManager->getReference($type, $data['id'] ?? $data);

        $entity = $this->objectNormalizer->denormalize($data, $type, $format, $context, $entity);

        return $entity;
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
