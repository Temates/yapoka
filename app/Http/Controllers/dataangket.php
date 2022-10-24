<?php
            /*
            ini nanti baigian notif alert update alert
            DB::update
            */
namespace App\Http\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class dataangket extends Controller
{
    public function postdata(Request $datapost)
    {
        $angka = null;
        $dummyurutansoalcek = false;
        $listpemeriksa = null;
        $idsoal= $datapost->idsoal;
        $urutansoal=$datapost->urutansoal;
        $pemeriksa = $datapost->pemeriksa;
        $pengisi = $datapost->pengisi;
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
            /*
            ini nanti baigian notif alert update alert
            DB::update
            masukan id pengisi ke table alert untuk cek nomer pelaporan

            $cekinsertdata = false;
        $data = DB::select('select * from alert where id_user = ?', [$idpengisi]);
        if($data == null){
            DB::insert('insert into alert (id_user, no_pelaporan) values (?, ?)', [$idpengisi ,$nopelaporan]);

        }
        elseif($data[0]->id_user != null and $data[0]->no_pelaporan == null){
            DB::insert('update alert  SET no_pelaporan = ? where id_user = ?', [$nopelaporan,$idpengisi]);

        }
        else{
            $dummy= $data[0]->no_pelaporan.strval(',').strval($nopelaporan);
            $tes = explode(",",$dummy);
            for($i=1;$i<count($tes);$i++){
                for($j=0;$j<count($tes)-$i;$j++){
                    if($tes[$j]==$tes[$j+1])
            { 
                $cekinsertdata = true;
            } 
        }
            }
            if($cekinsertdata == true){
                echo("data sudah ternotifikasikan oleh user");
            }
            else{
            DB::insert('update alert  SET no_pelaporan = ? where id_user = ?', [$dummy,$idpengisi]);

            }


        }
            */

        }
        return view('dashboard.index', [
            'posts' => Post::where('user_id', auth()->user()->id)->get()

        ]);      
    }

    public function isiangket(){
    $i=0;
      $id = 1;
      $pelaporan = 1;
      $data=DB::select('select * from listsoalpelaporan where nomerpelaporan = ?', [$pelaporan]);
      $laporan = DB::select('select * from pelaporan where id = ?', [$pelaporan]);
      $idsoal = explode(",",$data[0]->list_id_soal);

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

        $soal = DB::select('select * from posts where '.$querry);

      if($data[0]->status_pengisian == "belum"){
        if($laporan[0]->idpengisidata == $id){
            return view('isijawaban',compact('soal','pelaporan'));   
        }
        else{
            echo("SIAPA INI KOK BISA MASUK KESENI!! ANDA TIDAK BISA MENGISI LAPORAN INI");
        }
      }
      else{
        echo("laporan ini sudah anda isi");
      }
    }

   
    public function submit(Request $request){
        $pelaporan= $request->get('idlaporan');
        $data=DB::select('select * from listsoalpelaporan where nomerpelaporan = ?', [$pelaporan]);
        $idsoal = explode(",",$data[0]->list_id_soal);

        // $file = $request->file('soal');
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
          $soal = DB::select('select * from posts where '.$querry);
          dd($soal);
        //   dd($file[2]);
        // for($i=0; $i<count($file);$i++){
        //     $file[2][$i]->store('datagambar');
        //}
        
    }

    }

