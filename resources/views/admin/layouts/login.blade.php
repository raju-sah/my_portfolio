
@extends('admin.layouts.main')
@section('title', 'Login')
@section('content')


    <div class="container bg-dark bg-gradient text-white mt-5 p-3 rounded" style="height: 50%; width: 50%;">

<h1 class="text-center ">Login Page</h1>

<div class="container mt-3 ">


    <form action="{{route('admin.login.save')}}"method="post">
        @csrf
        <div class="justify-content-center text-align-center">
        <div class="d-flex flex-wrap gap-3">
        <div class="col-sm-9 mb-2">
            <label  class="form-label">Email address</label>
            <input type="email" name="email" placeholder="Enter Email" class="form-control @error('email') is-invalid @enderror" value="{{old('email') }}" >
            @error('email')
            <div style="color: red;">{{ $message }}</div>
            @enderror
          </div>
          <div class=" col-sm-9 mb-2">
            <label  class="form-label">Password</label>
            <input type="password"  name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password" >
            @error('password')
            <div style="color: red;">{{ $message }}</div>
            @enderror
          </div>
        <div class=" mb-3 d-flex gap-3 form-check">
          <input type="checkbox" name="remember_token" class="form-check-input" value="{{old('remember_token') }}">
          <label class="form-check-label" >Remember Me</label>
          <a href="#">Forgot Password</a>
        </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <div class=" mt-2 d-flex gap-3">
            <p>Don't have account?</p>
            <a href="{{route('admin.registration')}}">Register</a>
        </div>
        
      </form>
</div>

</div>
@endsection