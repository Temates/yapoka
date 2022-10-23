<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostController extends Controller
{
    public function index(){

        // $posts = Post::latest();
        $title='';
        if(request('category')){
            $category = Category::firstWhere('slug', request('category'));
            $title = ' in ' . $category->name;
        }
        if(request('author')){
            $author = User::firstWhere('username', request('author'));
            $title = ' by ' . $author->name;
        }
        
        return view('posts',[
            "title" => "All Posts" . $title, 
            "active" => 'post',
            
            //"posts" => $posts->get()
            "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString()









        ]);
    }
    
    public function show(Post $post){
        return view('post',[
            "title" => "Single Post",
            "active" => 'post',
            "post" => $post
        ]);
    }



        // Kode Andreas
        // public function index()
        // {
        //     $post =Post::all();
    
        //     return response()->json([
        //         'status'=> true,
        //         'massage' => $post,
    
        //     ],200);
        // }

}
