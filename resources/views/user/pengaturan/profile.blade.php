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
  <h6 class="card-title">Data Users</h6>
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
      <th>Username</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
                 
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>
        <button type="button" data-href="" class="btn btn-warning btn-icon btn-xs edit_jurusan" data-bs-toggle="modal" data-bs-target="#modalEdit">
          <i data-feather="edit-3"></i>
        </button>              
        <a class="btn btn-danger btn-icon btn-xs alert_notif" data-href="">
          <i data-feather="trash-2"></i>
        </a>
      </td>
    </tr>    

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
        <form action="{{route('tambah_user')}}" method="post">
          @csrf
          <div class="mb-3">
            <label class="form-label">Jurusan</label>
            <select type="text" class="form-select" id="get_jurusan" name="get_jurusan">
              <option value="" selected disabled>Pilih Jurusan</option>
              @foreach ($jurusan as $j)
                  <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>                                            
              @endforeach
            </select>        
          </div>
          <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select type="text" class="form-select" id="get_kelas" name="get_kelas">
              <option value="" selected disabled>Pilih Jurusan</option>
            </select>        
          </div>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username">        
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">        
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

  <script>
    var get_id_jurusan;
    $('#get_jurusan').on('change', function getKelas() {
        get_id_jurusan = $('#get_jurusan option:selected').val()
        var data = {
            id_jurusan: get_id_jurusan
        }

        $('#get_jurusan').click(function() {
            $.ajax({
                url: `{{ route('getkls') }}`,
                type: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    show_loading()
                },
                complete: function() {
                    hide_loading()
                },
                success: function(res) {    
                  console.log(res);
                                          
                    $('#get_kelas').html(res)

                }
            })
        });

    });

</script>
@endsection