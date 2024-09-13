<?php declare(strict_types=1);

namespace App\Demodata;

use Faker\Factory;
use Faker\Generator;
use FakerRestaurant\Provider\en_US\Restaurant;

class FakerFactory
{
    public static function create(): Generator
    {
        $faker = Factory::create();

        $faker->addProvider(new Restaurant($faker));

        return $faker;
    }
}
