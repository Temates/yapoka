<?php
/*
            kuarang bagian user sebelum kirim ke urutan angket
            */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\post;
use Illuminate\Http\Request;
use DB;

class Postcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::all();

        return response()->json([
            'status'=> true,
            'massage' => $post,

        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::create($request->all());
        $message = "penambahan data berhasil";
        return view('notifangket',compact('message'));
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        //
    }

    public function getangket(Request $request)
    {
        
        $count = DB::table('posts')->count();
        $soal = DB::select('select id,soal,type from posts');

if($count > 0) {
     $message = $count;
}else {
    $message = "kosong";
}
for ($i = 0; $i < $message; $i++){
            $tes[$i] = $soal[$i];
    }

        return view('pilihangket',compact('message','tes'));        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \
     * 
     * 
     * Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        //
    }
    public function postangket(Request $request)
    {
        $jumlahid = 0;
        $angka = null;
        
        $message = $request->message;
        for ($i=0;$i <= $message; $i++)
        {
            $dummy = 1;
            if (isset($request->id_soal[$i]))
            {
                $jumlahid +=1;
                $angka = $angka.strval($request->id_soal[$i]);
                for ($b=$i+1;$b <= $message; $b++) {
                    if (isset($request->id_soal[$b])){
                        if($dummy ==1)
                        {
                            $angka = $angka.",";
                            $dummy = 0;
                        }
                    }
                }
                

            }
        }
        $tes = explode(",",$angka);
        $querry = null;
        for ($i=0;$i<$jumlahid;$i++)
        {
            $dummy = "id =".$tes[$i];
            if($i != $jumlahid-1)
            {
                $dummy = $dummy." or ";
            }
            $querry = $querry.$dummy;
        }

        $soal = DB::select('select * from posts where '.$querry);
        for ($i = 0; $i < $jumlahid; $i++){
            $tes[$i] = $soal[$i];
        }
        return view('urutanangket',compact('tes', 'id'));        
    }
    
}
