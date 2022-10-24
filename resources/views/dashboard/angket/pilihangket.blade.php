
@extends('dashboard.layouts.main')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Input Soal</h1>        
</div>
    
<div class="col-lg-5">
  <form action=/pilihangket/send method="get">
    @csrf
    <table>
        <tr>
          <th>Id soal</th>
          <th>soal</th>
          <th>tipe</th>
          <th>pilih</th>
        </tr>
        @for ($i = 0; $i < $message; $i++)
        <tr>
            <td>{{$i+1}}</td>
            <td>{{$tes[$i]->soal}}</td>
            <td>{{$tes[$i]->type}}</td>
            <th><input type="checkbox" id="id_soal" name="id_soal[{{$i}}]" value={{$tes[$i]->id}}></th>
          </tr>
    @endfor
        
      </table>
    
      <label for="jpemeriksa">jumlah pemeriksa:</label><br>
      <input type="number" id="jpemeriksa" name="jpemeriksa" required><br>
      <input type="hidden" id="message" name="message" value= {{$message}}>
      <input type="submit" value="Submit">
    </form>
    
    <form method="post" action="dashboard/angket/send" class="mb-5" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="soal" class="form-label">Soal Angket</label>
            <input type="text" class="form-control @error('soal') is-invalid @enderror" id="soal" name="soal" value="{{ old('soal') }}" >
              @error('soal')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>                    
              @enderror 
          </div>
     
        <div class="mb-3">
            <label for="type" class="form-label">Tipe Soal:</label>
            <select class="form-select" name="type">
                <option disabled selected value>Pilih tipe jawaban</option>
                <option value="date">tanggal</option>
                <option value="text">kalimat pendek</option>
                <option value="textarea">paragraf</option>
                <option value="number">angka</option>
                <option value="file">gambar</option>
            </select>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary">Tambah Soal</button>
        </div>
      </form>
</div>

<script>
    
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

@endsection

        



