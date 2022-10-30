<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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
        return redirect('/dashboard')->with('success','Judul Soal has been updated!');
       
    }
    public function create()
    {
//         $count = Category::count();
//         $soal = Category::all();
        
// if($count > 0) {
//      $message = $count;
// }else {
//     $message = "kosong";
// }
// for ($i = 0; $i < $message; $i++){
//             $tes[$i] = $soal[$i];
//     }
//     dd($tes);
//         return view('pilihangket',compact('message','tes'));    

       

        return view('dashboard.angket.pilihangket',[
            'categories' => Category::all(),
            'title' => 'Buat Laporan',
            
        ]);
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
        // for ($i=0;$i < count($pemeriksa)-1; $i++)
        // {
        //     if ($pemeriksa[$i] == $pemeriksa[$i+1]){
        //         $validator = "terdapat nama yang sama di dua pemeriksa";
        //         $error = true;
        //     }
            
        // }
        // for ($i=0;$i < count($pemeriksa); $i++)
        // {
        //     if ($pemeriksa[$i] == $pengisi){
        //         $validator = "terdapat nama yang sama di pemeriksa dengan pengisi";
        //         $error = true;
        //     }
            
        // }
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
              DB::insert('insert into pelaporan (idpengisidata, status_penyetuju_nomer, jumlah_penyetuju,list_id_penyetuju) values (?, 0, ?, ?)', [1, $jumlahpenyetuju,$listpemeriksa]);
              $idlaporan = DB::getPdo()->lastInsertId();
               DB::insert('insert into listsoalpelaporan (nomerpelaporan, status_pengisian, list_id_soal) values (?, ?, ?)', [$idlaporan, 'belum',$angka]);
            

        }
        return view('dashboard.index', [
            'posts' => Post::where('user_id', auth()->user()->id)->get()

        ]);    
       
    }


}
