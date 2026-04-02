<?php

namespace App\Enums;

enum Status: string {
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public static function values(): array {
        $values = [];
        foreach (self::cases() as $role) {
            $values[$role->name] = $role->value;
        }
        return $values;
    }

    public static function fromValue(?string $value = null): ?self
    {
        return self::tryFrom($value);
    }

}
