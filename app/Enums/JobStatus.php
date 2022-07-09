<?php

namespace App\Enums;

enum JobStatus : int
{
    case Scheduled = 1;
    case Active = 2;
    case Invoicing = 3;
    case ToPriced = 4;
    case Completed = 5;

    /**
     * @return string
     */
    public function forDisplay(): string
    {
        return match ($this) {
            self::ToPriced => 'To Be Priced',
            default => $this->name,
        };
    }
}
