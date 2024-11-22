<?php declare(strict_types=1);

namespace App\Serializer;

use App\Entity\ProductCategoryEntity;
use App\Entity\ProductVariantEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CollectionReferenceDenormalizer implements DenormalizerInterface
{
    private const ENTITIES = [
        ProductCategoryEntity::class . '[]',
        ProductVariantEntity::class . '[]',
    ];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return new ArrayCollection(
            \array_map(
                fn ($item) => $this->entityManager->getReference(\substr($type, 0, -2), $item['id'] ?? $item),
                $data,
            ),
        );
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return \in_array($type, self::ENTITIES, true) && \is_array($data);
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => true];
    }
}
