<?php

namespace App\Repositories;

use App\Models\Hero;

class HeroRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Hero::class);
    }
}
