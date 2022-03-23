<?php

declare(strict_types=1);

namespace App\Enum;

enum Meal: int
{
    case Breakfast = 0;
    case Lunch     = 1;
    case Dinner    = 2;
    case Snack     = 3;

    /**
     * Translated description for the Enum
     */
    public function description(): string
    {
        return match ($this) {
            self::Breakfast => __('Breakfast'),
            self::Lunch     => __('Lunch'),
            self::Dinner    => __('Dinner'),
            self::Snack     => __('Snack'),
        };
    }
}
