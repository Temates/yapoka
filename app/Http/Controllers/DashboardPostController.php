<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.index', [
            'posts' => Post::where([
                ['idpengisidata', '=', auth()->user()->id],
                // ['user_id', '=', auth()->user()->id]
                ])->get()

        ]);
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {     

        return view('dashboard.angket.pilihangket',[
            'categories' => Category::all(),
            'title' => 'Buat Laporan',
            
        ]);
    }
    public function createsoal(Request $request)
    {   
        $id = $request;  
        $jumlahid = 0;
        $angka = null;
        for ($i=0;$i <= $request->message; $i++)
        {
            $dummy = 1;
            if (isset($request->id_soal[$i]))
            {
                $jumlahid +=1;
                $angka = $angka.strval($request->id_soal[$i]);
                for ($b=$i+1;$b <= $request->message; $b++) {
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
        $soal = DB::select('select * from categories where ' .$querry);
        for ($i = 0; $i < $jumlahid; $i++){
            $tes[$i] = $soal[$i];
        }
        $users = User::all();
        return view('dashboard.angket.create',compact('tes', 'id','users'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    
    public function storeangket(Request $request)
    {
        
        $angka = null;
        $dummyurutansoalcek = false;
        $listpemeriksa = null;
        $idsoal= $request->idsoal;
        $urutansoal=$request->urutansoal;
        $pemeriksa = $request->pemeriksa;
        $pengisi = $request->pengisi;
        $error = false;
        //dinyalakan jika sudah dapet data user
        for ($i=0;$i < count($pemeriksa)-1; $i++)
        {
            if ($pemeriksa[$i] == $pemeriksa[$i+1]){
                $validator = "terdapat nama yang sama di dua pemeriksa";
                $error = true;
            }
            
        }
        for ($i=0;$i < count($pemeriksa); $i++)
        {
            if ($pemeriksa[$i] == $pengisi){
                $validator = "terdapat nama yang sama di pemeriksa dengan pengisi";
                $error = true;
            }
            
        }
        if (isset($idsoal) and isset($urutansoal)){
            if (count($idsoal)!= count($urutansoal)){
                $validator = "terdapat kolom pengatur urutan soal yang belum diisi";
                $error = true;
                $dummyurutansoalcek = true;
            }
            if ($dummyurutansoalcek==false) 

            {        
                for($i=0;$i< count($idsoal);$i++){
                    for($j=$i+1;$j<count($idsoal);$j++){
                        if($urutansoal[$i]==$urutansoal[$j])
            { 
                $validator = "urutan soal ada yang sama";
                $error = true;
            } 
                }
            }}
        }
        else{
            $validator = "kolom pengatur urutan soal belum diisi";
            $error = true; 
        }

         
        if($error==true){
            return redirect()->back()->withInput()->with('tes',$validator);
        }
        else{

            for($i=1;$i< count($idsoal);$i++){

                for($j=0;$j<count($idsoal)-$i;$j++){
                    if($urutansoal[$j]>$urutansoal[$j+1])
            { 
                $dummy=$urutansoal[$j];
                $urutansoal[$j]=$urutansoal[$j+1];
                $urutansoal[$j+1]=$dummy;
                $dummy=$idsoal[$j];
                $idsoal[$j]=$idsoal[$j+1];
                $idsoal[$j+1]=$dummy;  
            } 
                }
            }

            for ($i=0;$i < count($idsoal); $i++)
        {
            $angka = $angka.strval($idsoal[$i]);
                if (isset($idsoal[$i+1])){
                         $angka = $angka.",";
                  }
               }



               for ($i=0;$i < count($pemeriksa); $i++)
               {
                   $listpemeriksa = $listpemeriksa.strval($pemeriksa[$i]);
                       if (isset($pemeriksa[$i+1])){
                                $listpemeriksa = $listpemeriksa."'";
                         }
                      }
                $jumlahpenyetuju = count($pemeriksa);
              DB::insert('insert into pelaporans (title, idpengisidata, status_penyetuju_nomer, jumlah_penyetuju,list_id_penyetuju) values (?, ?, 0, ?, ?)', [$request->title, $pengisi,  $jumlahpenyetuju, $listpemeriksa]);
              $idlaporan = DB::getPdo()->lastInsertId();
               DB::insert('insert into listsoalpelaporan (nomerpelaporan, status_pengisian, list_id_soal) values (?, ?, ?)', [$idlaporan, 'belum',$angka]);
            

        }
        return redirect('/dashboard')->with('success','Laporan Berhasil di Tambahkan!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit',[
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            // 'image'=> 'image|file|max:8192',
            'image'=> 'image|file|max:4096',
            'body' => 'required'
            
        ];

        

        if($request->slug != $post->slug ){
            $rules['slug'] = 'required|unique:posts';            
        }
        

        $validatedData = $request->validate($rules);

        if($request->file('image')){
            if($request->oldImage){
                Storage::delete([$request->oldImage, 'otherFile']);

            }
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body),'200');

        Post::where('id', $post->id)
            ->update($validatedData);
        return redirect('/dashboard/posts')->with('success','Post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->image){
            Storage::delete($post->image);

        }
        Post::destroy($post->id);
        return redirect('/dashboard/posts')->with('success','Post has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        
        return response()->json(['slug' => $slug]);
        
    }

}
