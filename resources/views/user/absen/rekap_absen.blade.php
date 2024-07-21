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
                    <h6 class="card-title">Rekapitulasi Absen</h6>
                    <br>
                    <div class="mb-3">
                        <label class="form-label">Nama Jurusan</label>
                        <select class="form-select" id="get_jurusan" name="get_jurusan">
                            <option value="" selected disabled>Pilih Jurusan</option>
                            @foreach ($jurusan as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                {{-- <option value="{{\App\Helpers\Helper::encryptUrl($j->id)}}">{{$j->nama_jurusan}}</option>   --}}
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select class="form-select" id="get_kelas" name="get_kelas">
                            <option selected disabled>Pilih Kelas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <div class="input-group date datepicker" id="datePickerExample">
                            <input type="text" class="form-control" />
                            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <div class="input-group date datepicker" id="datePickerExample2">
                            <input type="text" class="form-control" />
                            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    {{-- <div class="table-responsive">
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

                                <tr>

                                </tr>

                            </tbody>
                        </table>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
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
                        $('#get_kelas').html(res)

                    }
                })
            });

        });

        $('#get_kelas').on('change', function() {
            var kelas = $('#get_kelas option:selected').val()
            var data = {
                id_jurusan: get_id_jurusan,
                id_kelas: kelas
            }

            $.ajax({
                url: `{{ route('getAbsen') }}`,
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
                    var data = JSON.parse(res);
                    calendarAbsen(data);
                }
            });

        })
    </script>
@endsection
