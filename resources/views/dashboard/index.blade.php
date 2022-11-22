
@extends('dashboard.layouts.main')

@section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h1 class="h1">Welcome Back, {{ auth()->user()->name }}</h1>


    </div>

    @if (session()->has('success'))
        
    <div class="alert alert-success fade show col-lg-6" role="alert">
         {{ session('success') }}
    </div>
    
    @endif

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h3 class="h5">List Laporan Yang Perlu diIsi</h3>
    </div>
    <div class="table-responsive col-lg-10">
      
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ( $posts as $post )                    
            <tr>
              <td></td>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $post->title }}</td>
              <td>
                {{-- <a href="/dashboard/posts/{{ $post->slug }}" class="badge bg-info"><span data-feather="eye"  ></span></a> --}}
                <form action="/isiangket" method="get" class="d-inline">
                  @csrf
                  <input type="hidden" id="pelaporan" name="pelaporan" value="{{$post->id}}">
                  <button class="badge bg-warning border-0" ><span data-feather="edit"  ></span></button>
                </form>
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
      </div>

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h3 class="h5">List Laporan Yang Perlu di Periksa</h3>
      </div>


    <div class="table-responsive col-lg-10">
      
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ( $penyetuju as $post )                    
            <tr>
              <td></td>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $post->title }}</td>
              <td>
                <form action="/ceklaporan" method="get" class="d-inline">
                  @csrf
                  <input type="hidden" id="pelaporan" name="pelaporan" value="{{$post->id}}">
                  <button class="badge bg-info border-0" ><span data-feather="eye"  ></span></button>
                </form>
                {{-- <a href="/dashboard/posts/{{ $post->slug }}" class="badge bg-info"><span data-feather="eye"  ></span></a> --}}
                {{-- <form action="/isiangket" method="get" class="d-inline">
                  @csrf
                  <input type="hidden" id="pelaporan" name="pelaporan" value="{{$post->id}}">
                  <button class="badge bg-warning border-0" ><span data-feather="edit"  ></span></button>
                </form>
                <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                  @method('delete')
                  @csrf
                  <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><span data-feather="x-circle"  ></span></button> --}}
                </form>
                

              </td>
            </tr>
            @endforeach
            
          </tbody>
        </table>
      </div>
   
    
   
    
@endsection