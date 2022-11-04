
@extends('dashboard.layouts.main')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Input Soal</h1>        
</div>
        
        @if (session()->has('success'))
                
        <div class="alert alert-success fade show col-lg-5" role="alert">
            {{ session('success') }}
        </div>

        @endif
<div class="col-lg-5">
    
    <form method="post" action="/dashboard/angket/send" class="mb-5" enctype="multipart/form-data">
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
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');
    
    title.addEventListener('change', function()
    {
       fetch('/dashboard/posts/checkSlug?title=' + title.value) 
       .then(response => response.json())
       .then(data => slug.value = data.slug)
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

        
