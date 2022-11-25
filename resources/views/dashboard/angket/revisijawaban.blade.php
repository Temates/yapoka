@extends('dashboard.layouts.main')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Posts</h1>        
</div>
    
<div class="col-lg-8">
    
                <form id="form" action="revisi/submit" method="POST">
                    @csrf
                    <input type="hidden" name="idlaporan" value="{{$pelaporan}}">
                    <input type="hidden" name="note" id="note">
                    {{-- bawah nanti isi judul e ndooooo --}}
                    <label for="title" >Judul Laporan:</label>
                    <input type="text"  id="title" name="title"  value="{{ $post->title }}"required autofocus >
                <table>

                @for($i=0;$i<count($jawaban);$i++)
                <tr>
                @if($jawaban[$i]->type == "file")
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
                    <td><input type="submit" value="Submit"></td>
                </tr>
                </table>
                </form>
</div>

<script>
    ffunction note(){var text = document.getElementById("note").value; 
      alert(text);}

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