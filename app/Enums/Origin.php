<?php

namespace App\Enums;

enum Origin: string {
    case DC = 'dc';
    case MARVEL = 'marvel';
    case ANIME = 'anime';
    case HANNA_BARBERA = 'hanna_barbera';
    case WARNER = 'warner';

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
