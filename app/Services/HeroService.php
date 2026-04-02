<?php

namespace App\Services;

use App\Repositories\HeroRepository;

class HeroService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(HeroRepository::class);
    }
}
