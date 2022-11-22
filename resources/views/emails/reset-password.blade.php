@extends('layouts.main')

@section('container')

<div class="row justify-content-center">
    <div class="col-lg-5">
       @if (session()->has('success'))
        
       <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
       
       @endif
       @if (session()->has('loginError'))
        
       <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('loginError') }}
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
       
       @endif
        {{-- alert!! --}}

        <main class="form-signin w-100 m-auto">
            <h1 class="mb-3 fw-normal text-center">Reset Password</h1>
           
            <form action="/reset-password" method="post">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-floating">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                <label for="email">Email address</label>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>                    
                @enderror
                </div>

               
                <div class="form-floating">
                <input type="password" class="form-control " style="border-top-left-radius: 0;
                border-top-right-radius: 0; margin-bottom: -1px;border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
                
                </div>
                <div class="form-floating">
                <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Password" required>
                <label for="confirmpassword">Confirm Password</label>
                </div>
              

                <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>                

            </form>
           
        </main>
        
    </div>
</div>

@endsection