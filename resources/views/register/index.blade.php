@extends('layouts.main')

@section('container')

<div class="row justify-content-center">
    <div class="col-lg-5">
        <main class="form-registration w-100 m-auto">

            <div class="text-center">
                <img class="mb-4 img-fluid" src="img/ypk_logo.png" alt="Yayasan Pondok Kasih" width="200" height="150">
            </div>

            <h1 class="h3 mb-3 fw-normal text-center">Registration Form</h1>

            <form action="/register" method="post">
                @csrf
                <div class="form-floationg">

                    <div class="form-floating">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" required value="{{ old('name') }}">
                    <label for="name">Name</label>
    
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>                    
                    @enderror
    
                    </div>
                    
                    </div>
                
                    <div class="form-floating">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
                    <label for="email">Email address</label>
    
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>                    
                    @enderror
    
                    </div>
    
                    <div class="form-floating">
                    <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
    
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>                    
                    @enderror
    
                    </div>
    
                    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Register</button>
                </div>

            </form>
            <small class="text-muted d-block text-center mt-3 fs-5">
                Already registered? <a href="/login" >Login Now!</a> 
            </small>
        </main>
        
    </div>
</div>

@endsection