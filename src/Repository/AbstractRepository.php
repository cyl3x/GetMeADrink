<?php declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * @template T of EntityInterface|ShopInterface
 *
 * @template-extends ServiceEntityRepository<T>
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    protected DenormalizerInterface $denormalizer;

    /**
     * @param class-string<T> $entityClass
     */
    public function __construct(
        ManagerRegistry $registry,
        string $entityClass,
    ) {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @param array<string, mixed> $item
     *
     * @return T
     */
    public function upsert(array $item): mixed
    {
        $id = $item['id'] ?? null;

        $entity = $id
            ? $this->getEntityManager()->getReference($this->getClassName(), $id)
            : new ($this->getClassName());

        $entity = $this->denormalizeInto($entity, $item);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    /**
     * @param T $into Doctrine entity to merge data into
     * @param array<string, mixed> $data Data to merge as strigified JSON
     *
     * @return T
     */
    public function denormalizeInto(mixed $into, array $data): mixed
    {
        return $this->denormalizer->denormalize(
            $data,
            $this->getClassName(),
            'array',
            [
                AbstractNormalizer::OBJECT_TO_POPULATE => $into,
                AbstractNormalizer::GROUPS => ['admin-write'],
            ],
        );
    }

    public function delete(int $id): void
    {
        $this->getEntityManager()->remove(
            $this->getEntityManager()->getReference(
                $this->getClassName(),
                $id
            )
        );

        $this->getEntityManager()->flush();
    }

    #[Required]
    public function setDenormalizer(DenormalizerInterface $denormalizer): void
    {
        $this->denormalizer = $denormalizer;
    }
}
