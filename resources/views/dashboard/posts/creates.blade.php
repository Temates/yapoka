
@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Posts</h1>        
    </div>
    @if (session()->has('success'))
        
    <div class="alert alert-success fade show col-lg-10" role="alert">
         {{ session('success') }}
    </div>
    
    @endif
    <div class="table-responsive col-lg-11">
      <form action="/dashboard/posts/creates" method="get">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Soal</th>
              <th scope="col">Type</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ( $posts as $post )                    
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $post->title }}</td>
              <td>{{ $post->category->name }}</td>
              <td>
                <div class="input">
                    <input class="form-check-input ms-3" type="checkbox" value="" name="{{ $post->title }}" >
                </div>

                {{-- <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                  @method('delete')
                  @csrf
                  <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><span data-feather="x-circle"  ></span></button>
                </form> --}}
                

              </td>
            </tr>
            @endforeach
            
          </tbody>
        </table>

       

        <div class="col-sm-3 ms-1">
          <label for="number" class="form-label">Jumlah Penyetuju</label>
          <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" required autofocus value="{{ old('number', $post->number) }}" >
          @error('number')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>                    
          @enderror   
      </div>
        <div class="col-sm-3 ms-1">
          <label for="title" class="form-label">Jumlah Penyetuju</label>
          <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required autofocus value="{{ old('title') }}" onchange="previewImage()">
          @error('title')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>                    
          @enderror   
      </div>


        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <button type="submit" class="btn btn-primary">Add Post</button>
        </div>
      </form>
          




      
      </div>
      <div class="col-sm-3">
        <div id="row">
            <div class="input-group m-3">
                <div class="input-group-prepend">
                    <button class="btn btn-danger"
                        id="DeleteRow" type="button">
                        <i class="bi bi-trash"></i>
                        Delete
                    </button>
                </div>
                <input type="text"
                    class="form-control m-input">
            </div>
        </div>

        <div id="newinput">

        </div>
        <button id="rowAdder" type="button"
            class="btn btn-dark ms-3">
            <span class="bi bi-plus-square-dotted">
            </span> ADD
        </button>
    </div>


      <script>
      const title = document.querySelector("#number");
      const slug = document.querySelector("#title");

      title.addEventListener("keyup", function() {
        let preslug = title.value;
        // // preslug = preslug.replace(/ /g,"-");
        slug.value = preslug;
      });

      $(document).ready(function(){
      const rowAdder = document.querySelector("#rowAdder");
      const rowdelete = document.querySelector("#DeleteRow");
      
      

      rowAdder.addEventListener("click", function() {
        var newRowAdd = 
        // slug.value = newRowAdd;
            '<div id="row"> <div class="input-group m-3">' +
            '<div class="input-group-prepend">' +
            '<button class="btn btn-danger" id="DeleteRow" type="button">' +
            '<i class="bi bi-trash"></i> Delete</button>  </div>' +
            '<input type="text" class="form-control m-input"> </div> </div>';
            $('#newinput').append(newRowAdd);
            
      });

      $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })
      });
      </script>
     

@endsection