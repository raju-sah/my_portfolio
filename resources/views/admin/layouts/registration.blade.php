
@extends('admin.layouts.login')
@section('title', 'Registration')
@section('content')

<div class="container bg-dark bg-gradient text-white mt-5 p-3 rounded" style="height: 40%; width: 50%;">

    <h1 class="text-center ">Registration Page</h1>
    
    <div class="container d-flex mt-3 justify-content-center text-align-center">
    
    
        <form action="{{route('admin.registration.save')}}"method="post">
            @csrf
            <div class="d-flex flex-wrap gap-3">
            <div class="col-sm-9 mb-2">
              <label  class="form-label">Full Name</label>
              <input type="text" name="name" placeholder="Enter Name" class="form-control @error('name') is-invalid @enderror"  value="{{old('name') }}">
             
              @error('name')
              <div style="color: red;">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-9 mb-2">
              <label  class="form-label">Email address</label>
              <input type="email" name="email" placeholder="Enter Email" class="form-control @error('email') is-invalid @enderror" value="{{old('email') }}" >
              @error('email')
              <div style="color: red;">{{ $message }}</div>
              @enderror
            </div>
       
            <div class=" col-sm-9 mb-2">
              <label  class="form-label">Date of Birth</label>
              <input type="date" name="dob" placeholder="Enter Date of Birth" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}">

              @error('dob')
              <div style="color: red;">{{ $message }}</div>
              @enderror
            </div>
            <div class=" col-sm-5 mb-2">
              <label  class="form-label">Password</label>
              <input type="password"  name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password" >
              @error('password')
              <div style="color: red;">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-sm-5 mb-2">
              <label  class="form-label">Confirm Password</label>
              <input type="password"  name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Enter Confirm  Password" >
              @error('confirm_password')
              <div style="color: red;">{{ $message }}</div>
              @enderror
            </div>
        </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <div class=" mt-2 d-flex gap-3">
                <p>Already have account?</p>
                <a href="{{route('admin.login')}}">Login</a>
            </div>
          </form>
    </div>
    
    </div>

    @endsection