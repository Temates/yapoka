<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();

        return view('dashboard.angket',[
            'category' => $category,
            'title' => 'Input Soal',
        ]);
    }
    public function store(Request $request)
    {
        $data = [
            'soal'=> 'required|max:255'
        ];

        if($request->type == 'date' ){
            $data['type'] = 'required';            
        }
        if($request->type == 'text' ){
            $data['type'] = 'required';            
        }
        if($request->type == 'textarea' ){
            $data['type'] = 'required';            
        }
        if($request->type == 'number' ){
            $data['type'] = 'required';            
        }
        if($request->type == 'file' ){
            $data['type'] = 'required';            
        }
        $validatedData = $request->validate($data);
        Category::create($validatedData);
        Log::info('User '. auth()->user()->email .' Telah Membuat Soal!'); 

        return redirect('/dashboard/angket/add')->with('success','Judul Soal has been added!');
       
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    


}
