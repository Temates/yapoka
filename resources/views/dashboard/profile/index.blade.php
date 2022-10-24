
@extends('dashboard.layouts.main')

@section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Profile</h1>
    


    </div>
    <div class="col-lg-8">
    
        <form method="post" action="/dashboard/EditProfile" class="mb-5" enctype="multipart/form-data">
            @method('put')
            @csrf
    
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" autofocus >
                  @error('name')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>                    
                  @enderror 
              </div>
            <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name', $userprofile->full_name) }}" >
                  @error('full_name')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>                    
                  @enderror 
              </div>
    
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required  value="{{ old('email',auth()->user()->email) }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>                    
                @enderror   
            </div>
            <div class="mb-3">
                <label for="handphone_number" class="form-label">Nomor Hp</label>
                <input type="text" class="form-control @error('handphone_number') is-invalid @enderror" id="handphone_number" name="handphone_number" required  value="{{ old('handphone_number',$userprofile->handphone_number) }}">
                @error('handphone_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>                    
                @enderror   
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" required  value="{{ old('address',$userprofile->address) }}">
                @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>                    
                @enderror   
            </div>
    
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
    </div>


    
    
@endsection