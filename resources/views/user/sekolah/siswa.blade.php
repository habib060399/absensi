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
                        <a href="{{ route('siswa_add') }}" class="btn btn-inverse-success btn-icon"><i data-feather="plus"></i></a>
                        <button type="button" class="btn btn-inverse-success btn-icon" data-bs-toggle="modal" data-bs-target="#exampleModal"><i data-feather="download"></i></button>
                        <button type="button" class="btn btn-inverse-success btn-icon" data-bs-toggle="modal" data-bs-target="#upload"><i data-feather="upload"></i></button>
                        <a href="{{route ('siswa_naik_kelas')}}" class="btn btn-inverse-success btn-icon"><i data-feather="chevron-right"></i></a>
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
                                    @can('jurusan sekolah')
                                    <th>Jurusan</th>
                                    @endcan
                                    <th>ID Name Tag</th>
                                    <th>Hadir</th>
                                    <th>Absen</th>
                                    <th>Izin</th>
                                    <th>Sakit</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $s)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $s->nama_siswa }}</td>
                                        <td>{{ $s->kelas }}</td>
                                        @jurusan
                                        <td>{{ $s->nama_jurusan }}</td>
                                        @endjurusan
                                        <td>{{ $s->rfid }}</td>
                                        <td>{{$s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'hadir')->where('id_siswa', $s->id)->count('status')}}</td>
                                        <td>{{$s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'absen')->where('id_siswa', $s->id)->count('status')}}</td>
                                        <td>{{$s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'izin')->where('id_siswa', $s->id)->count('status')}}</td>
                                        <td>{{$s->join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('status', 'sakit')->where('id_siswa', $s->id)->count('status')}}</td>
                                        <td>
                                            <a href="{{ route('editSiswa', ['id' => \App\Helpers\Helper::encryptUrl($s->id)]) }}" class="btn btn-warning btn-icon btn-xs">
                                                <i data-feather="edit-3"></i>
                                            </a>
                                            <a class="btn btn-danger btn-icon btn-xs alert_notif" data-href="{{ route('hapus', ['id' => \App\Helpers\Helper::encryptUrl($s->id)]) }}" id="hapus">
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
                        <select class="form-select" id="jurusan_sekolah" name="jurusan_sekolah">
                            <option selected disabled>Pilih Jurusan</option>
                            @foreach ($jurusan as $j)
                            <option value="{{$j->id}}">{{$j->nama_jurusan}}</option>
                            @endforeach
                        </select>
                </div>
                  @endjurusan
                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select class="form-select @error('kelas_sekolah') is-invalid @enderror" id="kelas_sekolah" name="kelas_sekolah">
                        <option selected disabled>Pilih Kelas</option>
                    </select>
                    @error('kelas_sekolah')
                        <div class="error invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Siswa</label>
                    <input type="number" class="form-control @error('jml_siswa') is-invalid @enderror" placeholder="Jumlah Siswa" name="jml_siswa">
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

@jurusan
        <script type="text/javascript">
            $('#jurusan_sekolah').on('change', function() {
                var value = $('#jurusan_sekolah option:selected').val()
                var data = {
                    id_jurusan: value
                }

                $('#jurusan_sekolah').click(function() {
                    $.ajax({
                        url: `{{ route('getkls') }}`,
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            console.log(res);

                            $('#kelas_sekolah').html(res)

                        }
                    })
                });

            });
        </script>
@else
<script type="text/javascript">
    $.ajax({
        url: `{{ route('get_all_kelas') }}`,
        type: 'GET',
        success: function(res) {
            console.log(res);

            $('#kelas_sekolah').html(res)

        }
    })
</script>
@endjurusan
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
