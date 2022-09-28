<?php

namespace App\Models;


class Post 
{
    private static $blog_posts = [
        [
            "title" => "Judul Post Pertama",
            "slug" => "judul-post-pertama",
            "author" => "Phe Nando",
            "body" => "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nesciunt culpa alias ad corporis aliquid totam dolorum, rem consequuntur illo, fugiat quas error impedit ullam sapiente amet cumque mollitia sunt sed a architecto! Inventore perferendis pariatur ipsa quasi doloremque, ea cumque? Qui quaerat, natus exercitationem possimus veniam rerum aperiam totam magni asperiores sunt assumenda ipsum autem explicabo eum ipsa debitis incidunt corporis cum dolorum. Aliquid animi ipsam sint eos tempora possimus, laudantium quibusdam quaerat numquam asperiores! Ipsam esse eaque cum iste."
        ],
        [
            "title" => "Judul Post Kedua",
            "slug" => "judul-post-kedua",
            "author" => "Sandhikha Galih",
            "body" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum incidunt natus rem, sunt deserunt ullam repellat fuga, eveniet atque vero optio numquam vitae tempora eum ad laudantium corporis nulla amet?"
        ],
    ];

    public static function all()
    {
        return collect(self::$blog_posts);
    }
    public static function find($slug)
    {
        $posts = static::all();
        // $post = [];
        // foreach($posts as $p){
        //     if($p["slug"] === $slug){
        //         $post = $p;
        //     }
        // }
        return $posts->firstWhere('slug', $slug);
    }
}
