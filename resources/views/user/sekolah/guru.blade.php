@extends('template')
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Guru</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Guru</h6>
                    <br>
                    <div>
                        <a href="{{route('add_guru')}}" class="btn btn-inverse-success btn-icon"><i data-feather="plus"></i></a>
                        <a href="" class="btn btn-inverse-success btn-icon"><i data-feather="download"></i></a>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th width="50px">No</th>
                                    <th>Nama Guru</th>
                                    <th>Jabatan</th>
                                    <th>No Whatssap</th>                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guru as $g)                                                                    
                                    <tr>
                                        <td>{{$loop->iteration}}</td> 
                                        <td>{{$g->nama_guru}}</td>
                                        <td>{{$g->nama_jabatan}}</td>
                                        <td>{{$g->no_wa}}</td>                                                                               
                                        <td>
                                            <a href="{{route('sh_edit_guru',['id' => \App\Helpers\Helper::encryptUrl($g->id)])}}" class="btn btn-warning btn-icon btn-xs">
                                                <i data-feather="edit-3"></i>
                                            </a>
                                            <a class="btn btn-danger btn-icon btn-xs alert_notif" data-href="{{route('hapus_guru', ['id' => \App\Helpers\Helper::encryptUrl($g->id)])}}" id="hapus">
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
