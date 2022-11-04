@extends('dashboard.layouts.main')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Laporan</h1>        
</div>
@if (Session::get('tes')!=null)
<input type="hidden" id="pesan" name="pesan" value="{{Session::get('tes')}}">
@else
<input type="hidden" id="pesan" name="pesan" value="kosong">
@endif
    
<div class="col-lg-8">
    
    <form method="post" action="/dashboard/pilihangket/send" class="mb-5" >
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Judul Laporan</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required autofocus >
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>                    
            @enderror   
        </div>


        @for ($i = 0; $i < $id->jpemeriksa; $i++)
            <div class="mb-3">
                <label for="pemeriksa{{$i}}" class="form-label">Pemeriksa Ke {{$i+1}}:</label>
                <select id="jpemeriksa{{$i}}" name="pemeriksa[{{$i}}]" class="form-select">
                    @foreach ($users as $user)
                    @if (old('name') == $user->name)
                        <option value="{{ $user->id }}" selected></option>
                    @else               
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                    @endforeach
                </select>

                @error('pemeriksa{{$i}}')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>                    
                @enderror 
            </div>

        @endfor
        


        <div class="mb-3">
            <label for="pengisi" class="form-label">Pengisi Data:</label>
            <select id="pengisi" name="pengisi" class="form-select">
                @foreach ($users as $user)
                @if (old('name') == $user->name)
                    <option value="{{ $user->id }}" selected></option>
                @else               
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endif
                @endforeach
            </select>
            @error('pengisi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>                    
            @enderror   
        </div>

        @for ($j=0; $j <count($tes);$j++)
        <div class="mb-3">
            <p {{$j}}>
            <p>{{$tes[$j]->soal}}</p>
            
            <input type="hidden" id="idsoal" name="idsoal[{{$j}}]" value= {{$tes[$j]->id}}>
            <select id="urutansoal" class="form-select" name="urutansoal[{{$j}}]" id="urutansoal[{{$j}}]" required>
            
            <option disabled selected value>Atur urutan</option>
            @for ($i = 0; $i < count($tes); $i++)
            <option value="{{$i}}">{{$i+1}}</option>
            @endfor
        </select>
        </div>
        @endfor




        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary" onclick="myFunction()">Submit</button>
        </div>
      </form>
</div>

<script>
    function myFunction() {
  let text = "pastikan anda sudah mengisi semua data dengan benar\nJika sudah pasti silahkan tekan OK";
  if (confirm(text) == true) {
    document.getElementById("form").submit(); 
  } else {
    text = "You canceled!";
  }
}
function alaram() {
    var text = document.getElementById("pesan").value; 
    if(text != "kosong"){    
      alert(text);
}
 
}


</script>

@endsection