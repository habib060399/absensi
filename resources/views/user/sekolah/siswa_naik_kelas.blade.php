@extends('template')
@section('content')
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
                        <a href="" class="btn btn-inverse-success btn-icon"><i data-feather="chevron-right"></i></a>
                    </div>
                    <br>
                    
                    <hr>
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
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $s->nama_siswa }}</td>
                                        <td>{{ $s->kelas }}</td>
                                        <td>{{ $s->nama_jurusan }}</td>
                                        <td>{{ $s->rfid }}</td>                                        
                                        <td>
                                            <select class="form-select" id="jurusan_sekolah" name="jurusan_sekolah">
                                                <option value="" selected disabled>Pilih Kelas</option>
                                                <option value=""></option>
                                            </select>                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button>simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.alert_notif').click(function() {
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
