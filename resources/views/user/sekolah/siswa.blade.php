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
                    @role('sekolah')
                        <div>
                            <a href="{{ route('siswa_add') }}" class="btn btn-inverse-success btn-icon"><i
                                    data-feather="plus"></i></a>
                            <button type="button" class="btn btn-inverse-success btn-icon" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"><i data-feather="download"></i></button>
                            <button type="button" class="btn btn-inverse-success btn-icon" data-bs-toggle="modal"
                                data-bs-target="#upload"><i data-feather="upload"></i></button>
                            {{-- <a href="{{route ('siswa_naik_kelas')}}" class="btn btn-inverse-success btn-icon"><i data-feather="chevron-right"></i></a> --}}
                        </div>
                    @endrole
                    <br>
                    <br>
                    <div class="row align-items-center">
                        @role('kelas')
                        @jurusan
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <select class="form-select" id="jurusan_sekolah" name="">
                                            <option value="{{ $get_jurusan->id }}" selected>{{ $get_jurusan->nama_jurusan }}</option>

                                    </select>
                                </div>
                            </div><!-- Col -->
                        @endjurusan
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select class="form-select" id="get_kelas" name="kelas">
                                    <option value="{{$kelas->id}}" selected>{{$kelas->kelas}}</option>
                                </select>
                            </div>
                        </div><!-- Col -->
                        @endrole
                        @role('sekolah')
                        @jurusan
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <select class="form-select" id="jurusan_sekolah" name="">
                                        <option selected disabled>Pilih Jurusan</option>
                                        @foreach ($jurusan as $j)
                                            <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div><!-- Col -->
                        @endjurusan
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select class="form-select" id="get_kelas" name="kelas">

                                </select>
                            </div>
                        </div><!-- Col -->
                        @endrole
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Tanggal mulai</label>
                                <div class="input-group date datepicker" id="datePickerMulai">
                                    <input type="text" class="form-control date" name="tgl_mulai" id="tgl_mulai" autocomplete="off"/>
                                    <span class="input-group-text input-group-addon tgl_mulai"><i
                                            data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Tanggal selesai</label>
                                <div class="input-group date datepicker" id="datePickerSelesai">
                                    <input type="text" class="form-control" name="tgl_selesai" id="tgl_selesai" autocomplete="off"/>
                                    <span class="input-group-text input-group-addon tgl_selesai"><i
                                            data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-1">
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-primary btn-sm submit" id="btn">cari</button>
                            </div>
                        </div>
                    </div><!-- Row -->
                    <hr>
                    <br>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th width="50px">No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    @can('jurusan')
                                        <th>Jurusan</th>
                                    @endcan
                                    <th>ID Name Tag</th>
                                    <th>Hadir</th>
                                    <th>Absen</th>
                                    <th>Izin</th>
                                    <th>Sakit</th>
                                    @role('sekolah')
                                        <th>Action</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody id="tbodyid">
                                @foreach ($siswa as $s)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $s->nama_siswa }}</td>
                                        <td>{{ $s->kelas }}</td>
                                        @can('jurusan')
                                            <td>{{ $s->nama_jurusan }}</td>
                                        @endcan
                                        <td>{{ $s->rfid }}</td>
                                        <td>{{ $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'hadir')->where('id_siswa', $s->id)->count('status') }}
                                        </td>
                                        <td>{{ $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'absen')->where('id_siswa', $s->id)->count('status') }}
                                        </td>
                                        <td>{{ $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'izin')->where('id_siswa', $s->id)->count('status') }}
                                        </td>
                                        <td>{{ $s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'sakit')->where('id_siswa', $s->id)->count('status') }}
                                        </td>
                                        @role('sekolah')
                                            <td>
                                                <a href="{{ route('editSiswa', ['id' => \App\Helpers\Helper::encryptUrl($s->id)]) }}"
                                                    class="btn btn-warning btn-icon btn-xs">
                                                    <i data-feather="edit-3"></i>
                                                </a>
                                                <a class="btn btn-danger btn-icon btn-xs alert_notif"
                                                    data-href="{{ route('hapus', ['id' => \App\Helpers\Helper::encryptUrl($s->id)]) }}"
                                                    id="hapus">
                                                    <i data-feather="trash-2"></i>
                                                </a>
                                            </td>
                                        @endrole
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('template_siswa') }}" method="post">
                        @csrf
                        @jurusan
                            <div class="mb-3">
                                <label class="form-label">Nama Jurusan</label>
                                <select class="form-select" id="jurusan_sekolah_modal" name="jurusan_sekolah">
                                    <option selected disabled>Pilih Jurusan</option>
                                    @foreach ($jurusan as $j)
                                        <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endjurusan
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select class="form-select @error('kelas_sekolah') is-invalid @enderror" id="kelas_sekolah"
                                name="kelas_sekolah">
                                <option selected disabled>Pilih Kelas</option>
                            </select>
                            @error('kelas_sekolah')
                                <div class="error invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Siswa</label>
                            <input type="number" class="form-control @error('jml_siswa') is-invalid @enderror"
                                placeholder="Jumlah Siswa" name="jml_siswa">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Download Template</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import_siswa') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @jurusan
                            <input type="text" name="jurusan" class="form-control-sm" value="true" hidden>
                        @endjurusan
                        <input type="file" name="file" class="form-control-sm">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @role('kelas')
    @jurusan
    <script type="text/javascript">
            get_id_jurusan = $('#jurusan_sekolah option:selected').val()
            get_id_kelas = $('#get_kelas option:selected').val()
            $('#btn').click(function() {
                    let get_tgl_mulai = $('#tgl_mulai').val();
                    let get_tgl_selesai = $('#tgl_selesai').val();
                    $('#get_kelas').removeClass('is-invalid');
                    $('#tgl_mulai').removeClass('is-invalid');
                    $('#tgl_selesai').removeClass('is-invalid');
                    $('.error').remove();

                    filter(get_id_jurusan, get_id_kelas, get_tgl_mulai, get_tgl_selesai)

                })
        </script>
        @endjurusan
    @endrole
    @role('sekolah')
        @jurusan
            <script type="text/javascript">
                $('#jurusan_sekolah_modal').on('change', function() {
                    get_id_jurusan = $('#jurusan_sekolah_modal option:selected').val()
                    var data = {
                        id_jurusan: get_id_jurusan
                    }

                    $('#jurusan_sekolah_modal').click(function() {
                        $.ajax({
                            url: `{{ route('get_kelas_id') }}`,
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

                                $('#kelas_sekolah').html(res)

                            }
                        })
                    });

                });

                var get_id_jurusan = null;
                var get_id_kelas = null;
                $('#jurusan_sekolah').on('change', function() {
                    get_id_jurusan = $('#jurusan_sekolah option:selected').val()
                    var data = {
                        id_jurusan: get_id_jurusan
                    }

                    $('#jurusan_sekolah').click(function() {
                        $.ajax({
                            url: `{{ route('get_kelas_id') }}`,
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

                                $('#get_kelas').html(res)

                            }
                        })
                    });

                });

                $('#get_kelas').on('change', function() {
                    get_id_kelas = $('#get_kelas option:selected').val();
                })

                $('#btn').click(function() {
                    let get_tgl_mulai = $('#tgl_mulai').val();
                    let get_tgl_selesai = $('#tgl_selesai').val();
                    $('#get_kelas').removeClass('is-invalid');
                    $('#tgl_mulai').removeClass('is-invalid');
                    $('#tgl_selesai').removeClass('is-invalid');
                    $('.error').remove();

                    filter(get_id_jurusan, get_id_kelas, get_tgl_mulai, get_tgl_selesai)

                })
            </script>
        @else
            <script type="text/javascript">
                var get_id_kelas = '';
                $(document).ready(function() {
                    $.ajax({
                        url: `{{ route('get_all_kelas') }}`,
                        type: 'GET',
                        success: function(res) {

                            $('#kelas_sekolah').html(res)
                            $('#get_kelas').html(res)

                        }
                    })

                    $('#get_kelas').on('change', function() {
                        get_id_kelas = $('#get_kelas option:selected').val();
                    })

                    $('#btn').click(function() {
                        let get_tgl_mulai = $('#tgl_mulai').val();
                        let get_tgl_selesai = $('#tgl_selesai').val();
                        $('#get_kelas').removeClass('is-invalid');
                        $('#tgl_mulai').removeClass('is-invalid');
                        $('#tgl_selesai').removeClass('is-invalid');
                        $('.error').remove();

                        filter(null, get_id_kelas, get_tgl_mulai, get_tgl_selesai)

                    })
                })
            </script>
        @endjurusan
    @endrole

    <script type="text/javascript">
        function filter(id_jurusan, get_id_kelas, get_tgl_mulai, get_tgl_selesai) {
            let table = $('#dataTableExample').DataTable();
            table.clear().draw();

            $.ajax({
                url: `{{ route('get_siswa_by_tgl') }}`,
                type: 'POST',
                data: {
                    id_kelas: get_id_kelas,
                    tgl_mulai: get_tgl_mulai,
                    tgl_selesai: get_tgl_selesai
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    let response = JSON.parse(res)

                    if (id_jurusan != null) {
                        response.forEach(e => {

                        table.row.add([e.no, e.nama_siswa, e.kelas, e.jurusan,'sadf', e.hadir, e.absen, e.izin, e
                            .sakit, renderHtml(e.link)
                        ])
                    });

                    table.draw();
                    feather.replace();
                    } else {
                        response.forEach(e => {

                        table.row.add([e.no, e.nama_siswa, e.kelas, 'sadf', e.hadir, e.absen, e.izin, e
                            .sakit, renderHtml(e.link)
                        ])
                    });

                    table.draw();
                    feather.replace();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    let getErrors = JSON.parse(xhr.responseText);

                    if (getErrors.errors.id_kelas) {
                        $('#get_kelas').addClass('is-invalid');
                        $('#get_kelas').after('<div class="error invalid-feedback">' + getErrors.errors
                            .id_kelas + '</div>');
                    }
                    if (getErrors.errors.tgl_mulai) {
                        $('#tgl_mulai').addClass('is-invalid');
                        $('.tgl_mulai').after('<div class="error invalid-feedback">' + getErrors.errors
                            .tgl_mulai + '</div>');
                    }
                    if (getErrors.errors.tgl_selesai) {
                        $('#tgl_selesai').addClass('is-invalid');
                        $('.tgl_selesai').after('<div class="error invalid-feedback">' + getErrors.errors
                            .tgl_selesai + '</div>');
                    }

                }
            })
        }

        function renderHtml(link) {
            let html = `<a href="${link[0]}" class="btn btn-warning btn-icon btn-xs">
                    <i data-feather="edit-3"></i>
                </a>
                <a class="btn btn-danger btn-icon btn-xs alert_notif" data-href="${link[1]}">
                    <i data-feather="trash-2"></i>
                </a>
                `
            return html;
        }

        $('#dataTableExample').on('click', '.alert_notif', function() {
            const link = $(this).data('href');
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
                    if (result.isConfirmed) {
                        window.location.href = link

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
