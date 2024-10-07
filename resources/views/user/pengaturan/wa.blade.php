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
  <h6 class="card-title">Whatssap</h6>
  <br>
  <div>
    <button type="button" class="btn btn-inverse-success btn-icon" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i data-feather="plus"></i></button>
    <a href="{{route('wa_update')}}" class="btn btn-inverse-warning btn-icon"><i data-feather="refresh-ccw"></i></a>
  <hr>
  </div>
<br>
<div class="table-responsive">
<table id="dataTableExample" class="table">
  <thead>
    <tr>
      <th width="50px">No</th>
      <th>Id Group</th>
      <th>List Group Wa</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($wa as $w)                       
    <tr>
      <td></td>
      <td>{{$w['id']}}</td>
      <td>{{$w['name']}}</td>
      <td>
        <button type="button" data-href="" class="btn btn-warning btn-icon btn-xs edit_jurusan" data-bs-toggle="modal" data-bs-target="#modalEdit">
          <i data-feather="edit-3"></i>
        </button>              
        <a class="btn btn-danger btn-icon btn-xs alert_notif" data-href="">
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

<!-- Modal Tambah User -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('wa_tambah')}}" method="post">
            @csrf            
            <div class="mb-3">
              <label class="form-label">No Whatssap</label>
              <input type="text" class="form-control" name="no_wa">        
            </div>            
        </div>
        <div class="modal-fo oter">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
      </div>
    </div>
    <!-- End Modal Tambah User -->

@endsection