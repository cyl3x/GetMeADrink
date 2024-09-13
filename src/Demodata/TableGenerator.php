<?php declare(strict_types=1);

namespace App\Demodata;

use App\Entity\TableEntity;
use Doctrine\ORM\EntityManagerInterface;

class TableGenerator implements DemodataGeneratorInterface
{
    public function generate(EntityManagerInterface $em): void
    {
        for ($i = 0; $i < 20; ++$i) {
            $table = new TableEntity();

            $em->persist($table);
        }

        $em->flush();
    }
}
