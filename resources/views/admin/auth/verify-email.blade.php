@extends('admin.layouts.main')

@section('title', 'Verify Email')
@section('content')

<div class="row">
<div class="container d-flex mt-5 justify-content-center text-align-center">
    <strong > click the email verification link that was emailed to your email address</strong>
</div>
<div class="d-flex mt-5 justify-content-center text-align-center">
    <strong>If you did not receive the email, click <a target="_blank" href="{{ route('admin.verification.send') }}">here</a> here to request another</strong>
   
</div>
</div>
@endsection