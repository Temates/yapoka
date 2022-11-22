@extends('dashboard.layouts.main')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Posts</h1>        
</div>
    
<div class="col-lg-8">
    
        <form id="form" action="ceklaporan/save" method="POST">
          @csrf
          <input type="hidden" name="idlaporan" value="{{$pelaporan}}">
          <input type="hidden" name="note" id="note">
          {{-- bawah nanti isi judul e ndooooo --}}

            <table>
              <tr>
                <td >

                  <label for="title" >Judul Laporan</label>
                </td>
                <td><p style="text-align:right">:</p></td>
                <td colspan="3">

                  <input type="text"  id="title" name="title"  value="{{ $post->title }}"required autofocus >
                </td>
              
              </tr>
             

              
            
            @for($i=0;$i<count($jawaban);$i++)
        <tr>
            
        {{-- @if($jawaban[$i]->type == "file")
        <br><td colspan="3">
        <img src="{{asset('storage/'.$jawaban[$i]->jawaban)}}" width="500" 
        height="500"><br>
        </td>
    </tr>
    <tr>
        @elseif($jawaban[$i]->type == "textarea")
        <td>{{$jawaban[$i]->soal}}</td>
            <td><p style="text-align:right">:</p></td>
            <td>
        <br>
        <p>{{$jawaban[$i]->jawaban}}</p>
            </td>
        @else
        <td>{{$jawaban[$i]->soal}}</td>
            <td><p style="text-align:right">:</p></td>
            <td>
        {{$jawaban[$i]->jawaban}}<br>
            </td>
        @endif
        </tr> --}}


        {{-- bagian kalo pake input --}}
        @if($jawaban[$i]->type == "file")
        <br><td colspan="3">
        <img src="{{asset('storage/'.$jawaban[$i]->jawaban)}}" ><br>
        </td>
    </tr>
    <tr>
        @elseif($jawaban[$i]->type == "textarea")
        <td>{{$jawaban[$i]->soal}}</td>
            <td><p style="text-align:right">:</p></td>
            <td>
        <br>
        <p><textarea name="{{$jawaban[$i]->idsoal}}" id="{{$jawaban[$i]->idsoal}}" cols="30" rows="10" required>{{$jawaban[$i]->jawaban}}</textarea></p>
            </td>
        @else
        <td>{{$jawaban[$i]->soal}}</td>
            <td><p style="text-align:right">:</p></td>
            <td>
                <input type="{{$jawaban[$i]->type}}" id="{{$jawaban[$i]->idsoal}}" name="{{$jawaban[$i]->idsoal}}" value="{{$jawaban[$i]->jawaban}}" required><br>
            </td>
    </tr>

        @endif

        @endfor
        <tr>
            <td><input type="button" value="tolak" onclick="tolak()"></td>
            <td><input type="submit" value="terima tanpa simpan perubahan" formaction="ceklaporan/laporanditerima"></td>
            <td><input type="submit" value="terima dengan simpan semua perubahan"></td>
        </tr>
        </table>
        </form>
</div>

<script>
    function tolak() {
    let text;
    let person = prompt("masukan catatan kenapa di tolak:", "");
    if (person == null || person == "") {
      text = "mohon isi catatan kenapa ditolak";
      alert(text);
    } else {
      document.getElementById('form').action = "ceklaporan/laporanditolak";
      document.getElementById("note").value =person;
      document.getElementById("form").submit();
}}

    function previewImage(){

        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview')

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();

        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {

            imgPreview.src = oFREvent.target.result;
            }
    }

</script>
{{-- <script>
    const title = document.querySelector("#title");
    const slug = document.querySelector("#slug");

    title.addEventListener("keyup", function() {
        let preslug = title.value;
        preslug = preslug.replace(/ /g,"-");
        slug.value = preslug.toLowerCase();
    });
    document.addEventListener('trix-file-accept', function(e){
        e.preventDefault();
    });
    
</script> --}}
@endsection