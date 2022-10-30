
@extends('dashboard.layouts.main')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Laporan</h1>        
</div>
    
<div class="col-lg-5">
  
<form action=/pilihangket/send method="get">
  @csrf
  <div class="table-responsive col-lg-10">
        <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Soal</th>
            <th scope="col">Tipe</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $category )                   
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$category->soal}}</td>
            <td>{{$category->type}}</td>  
            <td>
              <input type="checkbox" id="id_soal" name="id_soal[{{$loop->iteration}}]" value={{$category->id}}>

          
              </form>
              

            </td>
          </tr>
          @endforeach
          
        </tbody>
      </table>
    </div>

    <div class="mb-2 col-lg-10">
      <label for="jpemeriksa" class="form-label">Jumlah Pemeriksa:</label>
      <input type="number" class="form-control mb-3 @error('jpemeriksa') is-invalid @enderror" id="jpemeriksa" name="jpemeriksa" required autofocus value="{{ old('jpemeriksa') }}">
      <input type="hidden" id="message" name="message" value= "{{ $category->count()}}" >
      @error('jpemeriksa')
          <div class="invalid-feedback">
              {{ $message }}
          </div>                    
      @enderror
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary">Tambah Laporan</button>
        </div>
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

        



