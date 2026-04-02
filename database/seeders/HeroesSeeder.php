<?php

namespace Database\Seeders;

use App\Enums\Origin;
use App\Models\Hero;
use Illuminate\Database\Seeder;

class HeroesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hero::insert([
            [
                'name' => 'A Presença',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Aquele Acima de Todos',
                'origin' => Origin::MARVEL,
            ],

            [
                'name' => 'Batman',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Superman',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Mulher Maravilha',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Flash',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Lanterna Verde (Hal Jordan)',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Lanterna Verde (Guy Gardner)',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Lanterna Verde (John Stewart)',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Mulher Gavião',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Caçador de Marte',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Aquaman',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Senhor Destino',
                'origin' => Origin::DC,
            ],
            [
                'name' => 'Arqueiro Verde',
                'origin' => Origin::DC,
            ],



            [
                'name' => 'Capitão América',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Homem de Ferro',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Thor',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Viúva Negra',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Gavião Arqueiro',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Hulk',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Visão',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Máquina de Combate',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Falcão',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Soldado Invernal',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Pantera Negra',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Capitã Marvel',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Homem-Formiga',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Vespa',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Doutor Estranho',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Homem-Aranha (Peter Parker)',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Homem-Aranha (Miles Morales',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Senhor das Estrelas',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Gamora',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Rocket Raccoon',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Groot',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Drax',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Mantis',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Nebula',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Fenticeira Escarlate',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Mercúrio',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Professor Xavier',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Magneto',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Wolverine',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Deadpool',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Ciclope',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Jean Grey',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Tempestade',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Fera',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Homem de Gelo',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Lince Negra',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Vampira',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Gambit',
                'origin' => Origin::MARVEL,
            ],
            [
                'name' => 'Bishop',
                'origin' => Origin::MARVEL,
            ],



            [
                'name' => 'Edward Elric',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Alphonse Elric',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Roy Mustang',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Careca de Capa (Saitama)',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Ciborgue Demoníaco (Genos)',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Silfer Fang',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'King',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Homem Cão de Guarda',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Ciclista Sem Licença',
                'origin' => Origin::ANIME,
            ],

            [
                'name' => 'Goku',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Gohan',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Goten',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Vegeta',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Trunks',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Piccolo',
                'origin' => Origin::ANIME,
            ],
            [
                'name' => 'Kuririn',
                'origin' => Origin::ANIME,
            ],



            [
                'name' => 'Super Choque',
                'origin' => Origin::WARNER,
            ],
            [
                'name' => 'Batman (Terry McGinnis)',
                'origin' => Origin::WARNER,
            ],
        ]);
    }
}
