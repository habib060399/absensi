@extends('template')
@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Tables</a></li>
      <li class="breadcrumb-item active" aria-current="page">Data Users</li>
  </ol>
</nav>
<div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Password</h6>
                    <br>
                    <form action="{{ route('edit_password') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Password Baru</label>
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                                        @error('password')
                                                            <div class="error invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div><!-- Col -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Konfirmasi Password</label>
                                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                                        @error('password_confirmation')
                                                            <div class="error invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div><!-- Col -->   
                                            </div>                                        
                                            <button type="submit" class="btn btn-primary submit">Simpan</button>  
                                            </form>
                </div>
            </div>
        </div>
    </div>
@endsection