<?php

namespace App\Enums;

enum Role: string {
    case User = 'user';
    case Admin = 'admin';

    public static function values(): array {
        $values = [];
        foreach (self::cases() as $role) {
            $values[$role->name] = $role->value;
        }
        return $values;
    }
}
