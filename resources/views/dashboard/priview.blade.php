
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
      
      <h3 class="h5">{{  $posts->title  }}</h3>

    </div>
    
    <table>
        
      @for($i=0;$i<count($jawaban);$i++)
      <tr>
          
      @if($jawaban[$i]->type == "file")
      <br><td colspan="3">
          
      <img src="{{asset("storage/".$jawaban[$i]->jawaban)}}" width="400px" ><br>
      </td>
  </tr>
  <tr>
      @elseif($jawaban[$i]->type == "textarea")
      <td>{{$jawaban[$i]->soal}}</td>
          <td><p style="text-align:right">:</p></td>
          <td>
      <br>
      <p>{{$jawaban[$i]->jawaban}}</p>
          </td>
      @else
      <td>{{$jawaban[$i]->soal}}</td>
          <td><p style="text-align:right">:</p></td>
          <td>
      {{$jawaban[$i]->jawaban}}<br>
          </td>
      @endif
      </tr>
      @endfor
     
      </table>
      <form action="/print">
          <input type="hidden" name="pelaporan" value="{{$pelaporan}}">
          <input type="submit" value="Print">
      </form>
   
      
   
    
@endsection