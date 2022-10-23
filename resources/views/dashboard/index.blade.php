
@extends('dashboard.layouts.main')

@section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome Back, {{ auth()->user()->name }}</h1>


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


    
    
    <script >
          
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
        </script>
    
@endsection