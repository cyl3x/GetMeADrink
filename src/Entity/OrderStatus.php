<?php declare(strict_types=1);

namespace App\Entity;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Canceled = 'canceled';
}
