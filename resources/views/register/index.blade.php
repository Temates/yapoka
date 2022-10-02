@extends('layouts.main')

@section('container')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <main class="form-registration w-100 m-auto">

            <div class="text-center">
                <img class="mb-4 img-fluid" src="img/ypk_logo.png" alt="Yayasan Pondok Kasih" width="200" height="150">
            </div>

            <h1 class="h3 mb-3 fw-normal text-center">Registration Form</h1>

            <form>
                
                <div class="form-floating">
                <input type="text" name="name" class="form-control rounded-top" id="name" placeholder="Name">
                <label for="name">Name</label>
                </div>

                <div class="form-floating">
                <input type="text" name="Username" class="form-control" id="Username" placeholder="Username">
                <label for="Username">Username</label>
                </div>
            
                <div class="form-floating">
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="email">Email address</label>
                </div>

                <div class="form-floating">
                <input type="password" name="password" class="form-control rounded-bottom mb-2" id="password" placeholder="Password">
                <label for="password">Password</label>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>                

            </form>
            <small class="text-muted d-block text-center mt-3 fs-5">
                Already registered? <a href="/login" >Login Now!</a> 
            </small>
        </main>
        
    </div>
</div>

@endsection