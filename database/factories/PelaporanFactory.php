<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelaporan>
 */
class PelaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'idpengisidata' => fake()->numberBetween(1, 4),
            'title' => fake()->sentence(mt_rand(2,8)),
            'status_penyetuju_nomer' => mt_rand(0,2),
            'note' => fake()->paragraph(mt_rand(1,2)),
            'jumlah_penyetuju' => '2',
            'list_id_penyetuju' =>   mt_rand(1,2) . "'" . mt_rand(3,4)          // 'body' => '<p>'. implode('</p><p>', fake()->paragraphs(mt_rand(5,10)), '</p>'),
            // 'body' => collect(fake()->paragraphs(mt_rand(5,10)))
            //             ->map(function($p){
            //                 return "<p>$p</p>";
            //             }),
            // 'body' => collect(fake()->paragraphs(mt_rand(5,10)))
            //             ->map(fn($p)=>"<p>$p</p>")
            //             ->implode(''),
            // 'user_id'=> mt_rand(1,4),
            // 'category_id'=>mt_rand(1,3)


            //
        ];
    }
}
