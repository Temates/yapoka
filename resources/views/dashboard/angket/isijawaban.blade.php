@extends('dashboard.layouts.main')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Posts</h1>        
</div>
    
<div class="col-lg-8">
    
    <form action="isiangket/submit" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="idsoal" name="idlaporan" value="{{$pelaporan}}">
        <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">Soal</th>
                <th scope="col"></th>
                <th scope="col">Jawaban</th>
              </tr>
            </thead>
            <tbody>
                <p {{$dummy=0}} hidden>
                @foreach ($soal as $item)
                <tr>
                    <td>{{$item->soal}}
                    </td>
                    <td>:</td>
                    <td>
                        @if($item->type == "text" or $item->type == "date" or $item->type == "number")
                        <input type="{{$item->type}}" id="soal" name="soal[{{$dummy}}]" required>
                        @elseif ($item->type == "file")
                        <input type="file" id="soal" name="soal[{{$dummy}}]" accept="image/*" multiple required>
                        @elseif ($item->type == "textarea")
                        <textarea rows="10" cols="50" id="soal" name="soal[{{$dummy}}]" spellcheck="true" lang="in"></textarea><br>
                        @endif
                
                        <p {{$dummy++}} hidden>
                    </td>
                  </tr>
                @endforeach
{{--                 
              @foreach ( $posts as $post )                    
              <tr>
                <td></td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $post->title }}</td>
                <td>
                  <a href="/dashboard/posts/{{ $post->slug }}" class="badge bg-info"><span data-feather="eye"  ></span></a>
                  <a href="/dashboard/posts/{{ $post->slug }}/edit" class="badge bg-warning"><span data-feather="edit"  ></span></a>
                  <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><span data-feather="x-circle"  ></span></button>
                  </form>
                  
  
                </td>
              </tr>
              @endforeach --}}
              
            </tbody>
          </table>

 
        <button type="submit" class="btn btn-primary">Add Post</button>
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