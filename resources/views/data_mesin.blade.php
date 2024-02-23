@extends('template')
@section('content')    
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Mesin</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Data Mesin</h6>
        <br>
        <div>
        <button type="button" class="btn btn-inverse-success btn-icon" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i data-feather="plus"></i></button>
        <hr>
        </div>
        <br>
    </br>
    <div class="table-responsive">
      <table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th>ID Mesin</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($mesin as $m)    
          <tr>
            <td>{{$m->id_mesin}}</td>
            <td>{{$m->created_at}}</td>
            <td>{{$m->updated_at}}</td>
            <td>
              <span class="badge {{($m->status == "Used") ? "bg-success" : "bg-danger"}}">{{$m->status}}</span>
            </td>
            <td>
              <button type="button" class="btn btn-warning btn-icon btn-xs">
                <i data-feather="eye"></i>
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

              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{route('add_mesin')}}" method="post">
                        @csrf
                      <label class="form-label">ID Mesin</label>
                      <input type="text" class="form-control" name="id_mesin" value="{{$uniqId}}" readonly>
                      <div class="mb-3">
                      <label class="form-label">Total</label>
                      <input type="number" class="form-control" name="total" value="1">
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
						</div>
@endsection