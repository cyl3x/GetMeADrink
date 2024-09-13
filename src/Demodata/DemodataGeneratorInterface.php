<?php declare(strict_types=1);

namespace App\Demodata;

use Doctrine\ORM\EntityManagerInterface;

interface DemodataGeneratorInterface
{
    public function generate(EntityManagerInterface $em): void;
}
