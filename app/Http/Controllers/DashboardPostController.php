<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Pelaporan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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


        $data = Pelaporan::where('idsekarang',auth()->user()->id)
        ->where('confirmed', '!=', 1)
        ->latest();
        
        //     $data = Pelaporan::where(function($query){
        //     $query->where('list_id_penyetuju', 'like', '%'. auth()->user()->id . "'%")
        //     ->orWhere('list_id_penyetuju', 'like', "%'". auth()->user()->id . "%")
        //     ->orWhere('list_id_penyetuju', 'like', "%'". auth()->user()->id . "'%");
        // })
        // ->where('status_penyetuju_nomer',2)
        // ->orWhere(function($query){
        //     $query->where('list_id_penyetuju', 'like', '%'. auth()->user()->id . "'%")
        //     ->orWhere('list_id_penyetuju', 'like', "%'". auth()->user()->id . "%")
        //     ->orWhere('list_id_penyetuju', 'like', "%'". auth()->user()->id . "'%");
        // })
        // ->orWhere(function($query){
        //     $query->where('list_id_penyetuju', 'like', '%'. auth()->user()->id . "'%")
        //     ->orWhere('list_id_penyetuju', 'like', "%'". auth()->user()->id . "%")
        //     ->orWhere('list_id_penyetuju', 'like', "%'". auth()->user()->id . "'%")
        //     ->where('status_penyetuju_nomer',6);
        // })
        // ->latest();

        return view('dashboard.index',[
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'posts' => Pelaporan::where('idpengisidata', auth()->user()->id)->where('status_penyetuju_nomer','<',1)->latest()->paginate(10),
            'penyetuju' => $data->paginate(10)
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
              DB::insert('insert into pelaporans (title, idpengisidata, status_penyetuju_nomer, jumlah_penyetuju,list_id_penyetuju,idsekarang) values (?, ?, 0, ?, ?, ?)', [$request->title, $pengisi,  $jumlahpenyetuju, $listpemeriksa,$idlaporan = DB::getPdo()->lastInsertId()]);
              $idlaporan = DB::getPdo()->lastInsertId();
               DB::insert('insert into listsoalpelaporan (nomerpelaporan, status_pengisian, list_id_soal) values (?, ?, ?)', [$idlaporan, 'belum',$angka]);
               Log::info('User '. auth()->user()->email .' Telah Membuat Laporan dengan ID = ' . $idlaporan . '!'); 
              
            
        }
        return redirect('/dashboard')->with('success','Laporan Berhasil di Tambahkan!');

    }


    public function isiangket(Request $request,Pelaporan $post){
        $i=0;
        //yang perlu diganti
      $id = auth()->user()->id;
      $pelaporan = $request->pelaporan;
      //2 atas
      $data=DB::select('select * from listsoalpelaporan where nomerpelaporan = ?', [$pelaporan]);
      $laporan = DB::select('select * from pelaporans where id = ?', [$pelaporan]);
      $idsoal = explode(",",$data[0]->list_id_soal);
      $post = Pelaporan::where('id',$request->pelaporan)->first();
      $dummy =null;
      $querry = null;
      for ($i=0;$i<count($idsoal);$i++){
          $dummy = "id = ".$idsoal[$i];
          if($i != count($idsoal)-1)
          {
              $dummy = $dummy." or ";
          }
          $querry = $querry.$dummy;

        }

        $soal = DB::select('select * from categories where '.$querry);

      if($data[0]->status_pengisian == "belum"){
        if($laporan[0]->idpengisidata == $id){
            return view('dashboard.angket.isijawaban',compact('soal','pelaporan'),[
                'post' => $post,
                'categories' => Category::all()
            ]);
        }
        else{
            echo("SIAPA INI KOK BISA MASUK KESINI!! ANDA TIDAK BISA MENGISI LAPORAN INI");
        }
      }
      else{
        

        $soal = DB::select('select * from categories where '.$querry);
        $jawaban = DB::select('select * from jawabanform INNER JOIN categories ON categories.id = jawabanform.idsoal where idpelaporan =?',[$pelaporan]);
        $dummy = "simpan";
        return view('dashboard.angket.revisijawaban',compact('jawaban','pelaporan','dummy'),[
            'post' => $post
          ] );
      }
    }
    public function submit(Request $request){
        $pelaporan= $request->get('idlaporan');
        $jawaban= $request->get('soal');
        $data=DB::select('select * from listsoalpelaporan where nomerpelaporan = ?', [$pelaporan]);
        $idsoal = explode(",",$data[0]->list_id_soal);
        $datapelaporan=DB::select('select * from pelaporans where id = ?', [$pelaporan]);
        $id=explode("'",$datapelaporan[0]->list_id_penyetuju);
        $file = $request->file('soal');
        $dummy =null;
        $querry = null;
        for ($i=0;$i<count($idsoal);$i++){
            $dummy = "id = ".$idsoal[$i];
            if($i != count($idsoal)-1)
            {
                $dummy = $dummy." or ";
            }
            $querry = $querry.$dummy;

          }
          $soal = DB::select('select * from categories where '.$querry);
          for ($i=0;$i<count($soal);$i++){
            $tipe=$soal[$i]->type;
            if($tipe=="text"or $tipe=="number" or $tipe=="textarea" or $tipe=="number" or $tipe=="date"){
                DB::insert('insert into jawabanform (idpelaporan, idsoal, jawaban) values (?, ?, ?)', [$pelaporan, $soal[$i]->id,$jawaban[$i]]);
                Log::info('User '. auth()->user()->email .' Telah Mengisi Laporan Dengan ID = ' . $pelaporan); 
            }

            elseif($tipe=="file"){
                for($j=0; $j<count($file[$i]);$j++){
                    if($file[$i][$j]){
                        $namagambar = $file[$i][$j]->store('datagambar');
                        DB::insert('insert into jawabanform (idpelaporan, idsoal, jawaban) values (?, ?, ?)', [$pelaporan, $soal[$i]->id,$namagambar]);}
                        Log::info('User '. auth()->user()->email .' Telah Mengisi Laporan Dengan ID = ' . $pelaporan); 


                }
             }

          }
          DB::table('listsoalpelaporan')->where('nomerpelaporan', $pelaporan)->update(['status_pengisian' => 'sudah']);
          DB::update('update pelaporans set status_penyetuju_nomer = ?,idsekarang = ? where id = ?', [$datapelaporan[0]->status_penyetuju_nomer+1,$id[0] ,$request->idlaporan]);
          return redirect('/dashboard')->with('success','Laporan Berhasil di Isi!');
        }

        public function ambildata(Request $request){
            //yang perlu diganti
            $id = auth()->user()->id;
            $pelaporan = $request->pelaporan;
            // $pelaporan = $request->pelaporan;
            //2 atas
            $querry = null;
            $data=DB::select('select * from listsoalpelaporan where nomerpelaporan = ?', [$pelaporan]);
            $post = Pelaporan::where('id',$pelaporan)->first();
            // select('select * from pelaporans where nomerpelaporan = ?', [$pelaporan]);
            $idsoal = explode(",",$data[0]->list_id_soal);

            for ($i=0;$i<count($idsoal);$i++){
                $dummy = "id = ".$idsoal[$i];
                if($i != count($idsoal)-1)
                {
                    $dummy = $dummy." or ";
                }
                $querry = $querry.$dummy;

              }

              $soal = DB::select('select * from categories where '.$querry);
              $jawaban = DB::select('select * from jawabanform INNER JOIN categories ON categories.id = jawabanform.idsoal where idpelaporan =?',[$pelaporan]);
              
              return view('dashboard.angket.viewjawaban',compact('jawaban','pelaporan'),[
                'post' => $post
              ]);
            }

            public function save(request $request){
                $idpengecek=auth()->user()->id;
                //ganti atas
                $datapelaporan = DB::select('select * from pelaporanS where id = ?', [$request->idlaporan]);
                $id=explode("'",$datapelaporan[0]->list_id_penyetuju);
                $arry=$datapelaporan[0]->status_penyetuju_nomer;
                $querry = null;
                    $data=DB::select('select * from listsoalpelaporan where nomerpelaporan = ?', [$request->idlaporan]);
                $idsoal = explode(",",$data[0]->list_id_soal);
                for ($i=0;$i<count($idsoal);$i++){
                    $dummy = "id = ".$idsoal[$i];
                    if($i != count($idsoal)-1)
                    {
                        $dummy = $dummy." or ";
                    }
                    $querry = $querry.$dummy;

                }
                $soal = DB::select('select * from categories where '.$querry);
                if($idpengecek==$id[$arry-1]){
                    for($i=0;$i<count($soal);$i++){
                        if($soal[$i]->type != "file"){
                            DB::update('update jawabanform set jawaban = ? where idpelaporan = ? and idsoal = ?', [$request->get($soal[$i]->id),$request->idlaporan,$soal[$i]->id]);
                        }
                    }
                    DB::update('update pelaporan set status_penyetuju_nomer = ?,idsekarang = ? where id = ?', [$datapelaporan[0]->status_penyetuju_nomer+1,$id[$datapelaporan[0]->status_penyetuju_nomer] ,$request->idlaporan]);
                    Log::info('User '. auth()->user()->email .' Telah Menerima Laporan dengan ID = ' . $request->idlaporan . '!'); 

                    }else{
                    echo("bukan giliran anda dalam pengecekan");
                }
            }

            public function terima(request $request){
                $idpengecek=auth()->user()->id;
                //ganti atas
                $dummy = DB::select('select * from pelaporans where id = ?', [$request->idlaporan]);
                $id=explode("'",$dummy[0]->list_id_penyetuju);
                $arry=$dummy[0]->status_penyetuju_nomer;
                if($idpengecek==$id[$arry-1]){
                    if(isset($id[$arry])){
                        DB::update('update pelaporans set status_penyetuju_nomer = ?,idsekarang = ? where id = ?', [$dummy[0]->status_penyetuju_nomer+1,$id[$dummy[0]->status_penyetuju_nomer],$request->idlaporan]);
                        Log::info('User '. auth()->user()->email .' Telah Menerima Laporan dengan ID = ' . $request->idlaporan . '!'); 
                    }
                    else{
                        DB::update('update pelaporans set status_penyetuju_nomer = ?, confirmed= ? where id = ?', [$dummy[0]->status_penyetuju_nomer+1,true,$request->idlaporan]);
                        Log::info('User '. auth()->user()->email .' Telah Menerima Laporan dengan ID = ' . $request->idlaporan . 'dan Laporan sudah Selesai!'); 
                        
                    }
                    return redirect('/dashboard')->with('success','Berhasil di Setujui');

                }else{
                    return redirect('/dashboard')->with('success','Bukan giliran anda dalam pengecekan');

                }
            }

            public function tolak(request $request){
                $idpengecek=auth()->user()->id;
                $dummy = DB::select('select * from pelaporans where id = ?', [$request->idlaporan]);
                $id=explode("'",$dummy[0]->list_id_penyetuju);
                $arry=$dummy[0]->status_penyetuju_nomer;
                if($idpengecek==$id[$arry-1]){
                $dummy = DB::select('select * from pelaporans where id = ?', [$request->idlaporan]);
                DB::update('update pelaporans set status_penyetuju_nomer = ? , note = ?,idsekarang= ? where id = ?', ['0',$request->note,$dummy[0]->idpengisidata,$request->idlaporan]);
                Log::info('User '. auth()->user()->email .' Telah Menolak Laporan dengan ID = ' . $request->idlaporan . '!'); 

                return redirect('/dashboard')->with('success','Laporan Berhasil di Tolak!');
                }else{
                    return redirect('/dashboard')->with('success','bukan giliran anda dalam pengecekan!');

                }

            }

            public function priview(request $request){
                $pelaporan = 1;
                $querry = null;
                $data=DB::select('select * from listsoalpelaporan where nomerpelaporan = ?', [$pelaporan]);
                $laporan = DB::select('select * from pelaporans where id = ?', [$pelaporan]);
                $idsoal = explode(",",$data[0]->list_id_soal);
                for ($i=0;$i<count($idsoal);$i++){
                    $dummy = "id = ".$idsoal[$i];
                        if($i != count($idsoal)-1)
                        {
                    $dummy = $dummy." or ";
                }
                $querry = $querry.$dummy;

              }

              $soal = DB::select('select * from categories where '.$querry);
              $jawaban = DB::select('select * from jawabanform INNER JOIN categories ON categories.id = jawabanform.idsoal where idpelaporan =?',[$pelaporan]);
            //   return view('hasilprint',compact('jawaban','pelaporan'));
            //   $pdf = Pdf::loadView('form');

            $contxt = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            return View('priview',compact('jawaban','pelaporan'));
        }

        public function print(request $request){
            $pelaporan = $request->get('pelaporan');
            $querry = null;
            $data=DB::select('select * from listsoalpelaporan where nomerpelaporan = ?', [$pelaporan]);
            $laporan = DB::select('select * from pelaporans where id = ?', [$pelaporan]);
            $idsoal = explode(",",$data[0]->list_id_soal);
            for ($i=0;$i<count($idsoal);$i++){
                $dummy = "id = ".$idsoal[$i];
                    if($i != count($idsoal)-1)
                    {
                $dummy = $dummy." or ";
            }
            $querry = $querry.$dummy;
            }
          }

          public function revisi(request $request){
            $id = auth()->user()->id;
            $pelaporan = $request->pelaporan;
            $querry = null;
            $data=DB::select('select * from listsoalpelaporan where nomerpelaporan = ?', [$pelaporan]);
            $laporan = DB::select('select * from pelaporans where id = ?', [$pelaporan]);
            $idsoal = explode(",",$data[0]->list_id_soal);
            for ($i=0;$i<count($idsoal);$i++){
                $dummy = "id = ".$idsoal[$i];
                if($i != count($idsoal)-1)
                {
                    $dummy = $dummy." or ";
                }
                $querry = $querry.$dummy;

              }

              $soal = DB::select('select * from categories where '.$querry);
              $jawaban = DB::select('select * from jawabanform INNER JOIN categories ON categories.id = jawabanform.idsoal where idpelaporan =?',[$pelaporan]);
              $dummy = $laporan[0]->note;
              return view('dashboard.angket.revisijawaban',compact('jawaban','pelaporan','dummy'));
            }
            public function updaterevisi(request $request){
                $idpengisi=1;
                //ganti atas
                $querry = null;
                $datapelaporan = DB::select('select * from pelaporans where id = ?', [$request->idlaporan]);
                $id=explode("'",$datapelaporan[0]->list_id_penyetuju);
                $arry=$datapelaporan[0]->status_penyetuju_nomer;
                $data=DB::select('select * from listsoalpelaporan where nomerpelaporan = ?', [$request->idlaporan]);
                $idsoal = explode(",",$data[0]->list_id_soal);
                for ($i=0;$i<count($idsoal);$i++){
                    $dummy = "id = ".$idsoal[$i];
                    if($i != count($idsoal)-1)
                    {
                        $dummy = $dummy." or ";
                    }
                    $querry = $querry.$dummy;
            
                  }
                  $soal = DB::select('select * from categories where '.$querry);
                  if($arry==0){
                    if($idpengisi==$datapelaporan[0]->idpengisidata){
                    for($i=0;$i<count($soal);$i++){
                        if($soal[$i]->type != "file"){
                            DB::update('update jawabanform set jawaban = ? where idpelaporan = ? and idsoal = ?', [$request->get($soal[$i]->id),$request->idlaporan,$soal[$i]->id]);
                        }
                    }
                    DB::update('update pelaporans set status_penyetuju_nomer = ?,idsekarang = ? where id = ?', [$datapelaporan[0]->status_penyetuju_nomer+1,$id[0],$request->idlaporan]);
                    Log::info('User '. auth()->user()->email .' Telah Melakukan Revisi pada Laporan dengan ID = ' . $request->idlaporan . '!'); 
                    return redirect('/dashboard')->with('success','Laporan Berhasil di Revisi!');
                    }else{
                    echo("bukan giliran anda dalam pengecekan");
                }
            }
            else{
                echo("laporan sedang di cek, tunggu terima revisi untuk ganti isi laporan");
            }
        }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    

}
