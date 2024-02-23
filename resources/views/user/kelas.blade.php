@extends('template')
@section('content')    
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Kelas</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Data Kelas</h6>
        <br>
        <div>
          <button type="button" class="btn btn-inverse-success btn-icon" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i data-feather="plus"></i></button>
        <hr>
        </div>
      <br>
    <div class="table-responsive">
      <table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th width="50px">No</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kelas as $k)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$k->nama_jurusan}}</td>
            <td>{{$k->kelas}}</td>
            <td>
              <button type="button" class="btn btn-warning btn-icon btn-xs">
                <i data-feather="edit-3"></i>
              </button>              
              <button type="button" class="btn btn-danger btn-icon btn-xs">
                <i data-feather="trash-2"></i>
              </button>
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

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('add_kelas')}}" method="post">
          @csrf        
        <div class="mb-3">
          <label class="form-label">Nama Jurusan</label>
							<select class="form-select" id="exampleFormControlSelect1" name="jurusan">
									<option selected disabled>Pilih Jurusan</option>
                  @foreach ($jurusan as $j)                                        
									<option value="{{$j->id}}">{{$j->nama_jurusan}}</option>
                  @endforeach									
							</select>
        </div>
        <div class="mb-3">
        <label class="form-label">Kelas</label>
        <input type="text" class="form-control" name="kelas">        
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
@endsection