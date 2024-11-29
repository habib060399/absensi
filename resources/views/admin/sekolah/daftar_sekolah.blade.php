@extends('template')
@section('content')    
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Sekolah</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Data Sekolah</h6>
        <br>
        <div>
        <a href="{{route('sekolah-add')}}" class="btn btn-inverse-success btn-icon"><i data-feather="plus"></i></a>
        <hr>
        </div>
      <br>
    <div class="table-responsive">
      <table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th>Nama Sekolah</th>
            <th>NPSN</th>
            <th>Email</th>
            <th>Pendidikan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($sekolah as $s)
          <tr>
            <td>{{$s->nama_sekolah}}</td>
            <td>{{$s->npsn}}</td>
            <td>{{$s->email}}</td>
            <td>{{$s->pendidikan}}</td>
            <td>              
              <a class="btn btn-success btn-icon btn-xs" href="{{route('paket',['id' => \App\Helpers\Helper::encryptUrl($s->id)])}}">
                <i data-feather="package"></i>
              </a>              
              <a class="btn btn-warning btn-icon btn-xs" href="{{ route('sekolah-edit', ['id' => \App\Helpers\Helper::encryptUrl($s->id)]) }}">
                <i data-feather="edit-3"></i>
              </a>              
              <a class="btn btn-danger btn-icon btn-xs alert_notif" href="{{ route('sekolah-hapus', ['id' => \App\Helpers\Helper::encryptUrl($s->id)]) }}" id="hapus">
                <i data-feather="trash-2"></i>
              </a>
            </td>
          </tr>              
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
        </div>
    </div>
@endsection