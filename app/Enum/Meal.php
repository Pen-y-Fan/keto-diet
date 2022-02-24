<?php

declare(strict_types=1);

namespace App\Enum;

enum Meal: int
{
    case Breakfast = 0;
    case Lunch     = 1;
    case Dinner    = 2;
    case Snack     = 3;
}
