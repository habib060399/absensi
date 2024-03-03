@extends('template')
@section('content')    
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Data Siswa</h6>
        <br>
        <div>
        <a href="{{route('siswa_add')}}" class="btn btn-inverse-success btn-icon"><i data-feather="plus"></i></a>
        <hr>
        </div>
      <br>
    <div class="table-responsive">
      <table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th width="50px">No</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>ID Name Tag</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($siswa as $s)
          <tr>
            <td></td>
            <td>{{$s->nama_siswa}}</td>
            <td>{{$s->kelas}}</td>
            <td>{{$s->nama_jurusan}}</td>
            <td>{{$s->rfid}}</td>
            <td></td>
          </tr>                      
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
        </div>
    </div>

</div>
@endsection