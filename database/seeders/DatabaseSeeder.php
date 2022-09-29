<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'Phe Nando',
            'email' => 'c11190016@john.petra.ac.id',
            'password' => bcrypt('12345')
        ]);
        Category::create([
            'name' => 'Web Programming',
            'slug' => 'web-programming'
        ]);
        Category::create([
            'name' => 'Personal',
            'slug' => 'personal'
        ]);
        Post::create([
            'title' => 'Judul Pertama',
            'category_id' => 1,
            'user_id' => 1,
            'slug' => 'judul-pertama',
            'excerpt'=> 'Lorem ipsum pertama',
            'body' => '<p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Similique quos omnis accusantium magni odit est cumque, facilis ducimus cupiditate qui fuga sapiente assumenda quis tenetur minus tempore? Suscipit corporis accusamus deserunt molestias, unde ducimus inventore quaerat hic similique voluptas, velit consequuntur rerum.</p> <p> Magnam, totam animi! Velit molestias unde pariatur, beatae mollitia eius voluptas, quae similique eum ducimus autem nobis dicta quis. Possimus quibusdam blanditiis illo soluta hic debitis exercitationem expedita, neque tempora, alias commodi, nesciunt adipisci pariatur voluptatibus repellat animi id magnam sapiente doloremque corporis minima.</p> <p> Fugiat reiciendis magni eos consectetur nisi eum quas beatae dignissimos nemo pariatur deserunt accusantium, corporis cumque eligendi, voluptates dolor voluptatibus, necessitatibus consequuntur rem quae laboriosam fugit nam ut? Vero sunt aliquid laboriosam veritatis voluptate, rem obcaecati dignissimos sapiente ut minima ipsa expedita voluptatem architecto placeat dolor aut autem ad quis, suscipit deleniti tempora! Officiis aut est tempora architecto eaque illum atque mollitia magni eligendi?</p>'
        ]);
        Post::create([
            'title' => 'Judul Kedua',
            'category_id' => 1,
            'user_id' => 1,
            'slug' => 'judul-ke-dua',
            'excerpt'=> 'Lorem ipsum kedua',
            'body' => '<p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Similique quos omnis accusantium magni odit est cumque, facilis ducimus cupiditate qui fuga sapiente assumenda quis tenetur minus tempore? Suscipit corporis accusamus deserunt molestias, unde ducimus inventore quaerat hic similique voluptas, velit consequuntur rerum.</p> <p> Magnam, totam animi! Velit molestias unde pariatur, beatae mollitia eius voluptas, quae similique eum ducimus autem nobis dicta quis. Possimus quibusdam blanditiis illo soluta hic debitis exercitationem expedita, neque tempora, alias commodi, nesciunt adipisci pariatur voluptatibus repellat animi id magnam sapiente doloremque corporis minima.</p> <p> Fugiat reiciendis magni eos consectetur nisi eum quas beatae dignissimos nemo pariatur deserunt accusantium, corporis cumque eligendi, voluptates dolor voluptatibus, necessitatibus consequuntur rem quae laboriosam fugit nam ut? Vero sunt aliquid laboriosam veritatis voluptate, rem obcaecati dignissimos sapiente ut minima ipsa expedita voluptatem architecto placeat dolor aut autem ad quis, suscipit deleniti tempora! Officiis aut est tempora architecto eaque illum atque mollitia magni eligendi?</p>'
        ]);
        Post::create([
            'title' => 'Judul Ketiga',
            'category_id' => 2,
            'user_id' => 1,
            'slug' => 'judul-ke-tiga',
            'excerpt'=> 'Lorem ipsum ketiga',
            'body' => '<p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Similique quos omnis accusantium magni odit est cumque, facilis ducimus cupiditate qui fuga sapiente assumenda quis tenetur minus tempore? Suscipit corporis accusamus deserunt molestias, unde ducimus inventore quaerat hic similique voluptas, velit consequuntur rerum.</p> <p> Magnam, totam animi! Velit molestias unde pariatur, beatae mollitia eius voluptas, quae similique eum ducimus autem nobis dicta quis. Possimus quibusdam blanditiis illo soluta hic debitis exercitationem expedita, neque tempora, alias commodi, nesciunt adipisci pariatur voluptatibus repellat animi id magnam sapiente doloremque corporis minima.</p> <p> Fugiat reiciendis magni eos consectetur nisi eum quas beatae dignissimos nemo pariatur deserunt accusantium, corporis cumque eligendi, voluptates dolor voluptatibus, necessitatibus consequuntur rem quae laboriosam fugit nam ut? Vero sunt aliquid laboriosam veritatis voluptate, rem obcaecati dignissimos sapiente ut minima ipsa expedita voluptatem architecto placeat dolor aut autem ad quis, suscipit deleniti tempora! Officiis aut est tempora architecto eaque illum atque mollitia magni eligendi?</p>'
        ]);
        Post::create([
            'title' => 'Judul Keempat',
            'category_id' => 2,
            'user_id' => 1,
            'slug' => 'judul-ke-empat',
            'excerpt'=> 'Lorem ipsum keempat',
            'body' => '<p> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Similique quos omnis accusantium magni odit est cumque, facilis ducimus cupiditate qui fuga sapiente assumenda quis tenetur minus tempore? Suscipit corporis accusamus deserunt molestias, unde ducimus inventore quaerat hic similique voluptas, velit consequuntur rerum.</p> <p> Magnam, totam animi! Velit molestias unde pariatur, beatae mollitia eius voluptas, quae similique eum ducimus autem nobis dicta quis. Possimus quibusdam blanditiis illo soluta hic debitis exercitationem expedita, neque tempora, alias commodi, nesciunt adipisci pariatur voluptatibus repellat animi id magnam sapiente doloremque corporis minima.</p> <p> Fugiat reiciendis magni eos consectetur nisi eum quas beatae dignissimos nemo pariatur deserunt accusantium, corporis cumque eligendi, voluptates dolor voluptatibus, necessitatibus consequuntur rem quae laboriosam fugit nam ut? Vero sunt aliquid laboriosam veritatis voluptate, rem obcaecati dignissimos sapiente ut minima ipsa expedita voluptatem architecto placeat dolor aut autem ad quis, suscipit deleniti tempora! Officiis aut est tempora architecto eaque illum atque mollitia magni eligendi?</p>'
        ]);


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
