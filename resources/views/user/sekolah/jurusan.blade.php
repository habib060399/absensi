@extends('template')
@section('content')    
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Jurusan</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Data Jurusan</h6>
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
            <th>ID Jurusan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($jurusan as $j)                       
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$j->nama_jurusan}}</td>
            <td>{{$j->id}}</td>
            <td>
              <button type="button" data-href="{{route('edit_jurusan', ['id' => \App\Helpers\Helper::encryptUrl($j->id)])}}" class="btn btn-warning btn-icon btn-xs edit_jurusan" data-bs-toggle="modal" data-bs-target="#modalEdit">
                <i data-feather="edit-3"></i>
              </button>              
              <a class="btn btn-danger btn-icon btn-xs alert_notif" data-href="{{route('hapus_jurusan', ['id' => \App\Helpers\Helper::encryptUrl($j->id)])}}">
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
        <form action="{{route('add_jurusan')}}" method="post">
          @csrf
        <label class="form-label">Nama Jurusan</label>
        <input type="text" class="form-control" name="jurusan">
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
    </div>
  </div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('edit_jurusan1')}}" method="post">
          @csrf
        <label class="form-label">Nama Jurusan</label>
        <input type="text" id="edit_id_jurusan" type="hidden" name="id_edit_jurusan" hidden>
        <input type="text" id="edit_jurusan" class="form-control" name="edit_jurusan">
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
    </div>
  <script>
    $('.edit_jurusan').click(function (){
      var getLink = $(this).data('href');
      $.ajax({
        url: getLink,
        type: 'GET',
        beforeSend: function(){
                            show_loading()
                        },
                        complete: function(){
                            hide_loading()
                        },
        success: function(res){
          $('#edit_jurusan').val(res.nama_jurusan)
          $('#edit_id_jurusan').val(res.id)
        }
      })
    })
  </script>
  <script type="text/javascript">
    $('.alert_notif').click(function (){
      var getLink = $(this).data('href');
      const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                      confirmButton: "btn btn-success",
                      cancelButton: "btn btn-danger me-2",
                  },
                  buttonsStyling: false,
              });
  
              swalWithBootstrapButtons
                  .fire({
                      title: "Are you sure?",
                      text: "You won't be able to revert this!",
                      icon: "warning",
                      showCancelButton: true,
                      confirmButtonClass: "me-2",
                      confirmButtonText: "Yes, delete it!",
                      cancelButtonText: "No, cancel!",
                      reverseButtons: true,
                  })
                  .then((result) => {
                    console.log(result);
                      if (result.isConfirmed) {
                        window.location.href = getLink
                          
                      } else if (
                          // Read more about handling dismissals
                          result.dismiss === Swal.DismissReason.cancel
                      ) {
                          swalWithBootstrapButtons.fire(
                              "Cancelled",
                              "Your imaginary file is safe :)",
                              "error"
                          );
                      }
                  });
    });
  </script>
@endsection