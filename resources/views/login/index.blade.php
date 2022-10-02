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
        {{-- alert!! --}}

        <main class="form-signin w-100 m-auto">

            <div class="text-center">
                <img class=" img-fluid" src="img/ypk_logo.png" alt="Yayasan Pondok Kasih" width="200" height="150">
            </div>

            <h1 class="mb-3 fw-normal text-center">Login</h1>

            <form>

                <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
                </div>

                <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>                

            </form>
            <small class="text-muted d-block text-center mt-3 fs-5">
                Not Registered? <a href="/register" >Register Now!</a> 
            </small>
        </main>
        
    </div>
</div>

@endsection