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
                    <form action="{{ route('download_rekap') }}" method="post">
                        @csrf
                        @can('only class')
                        <div class="mb-3">
                            <label class="form-label">Nama Jurusan</label>
                            <select class="form-select @error('get_jurusan') is-invalid @enderror" id="get_jurusan" name="get_jurusan" @readonly(true)>
                                    <option value="{{ $kelas->id_jurusan }}">{{$jurusan->nama_jurusan}}</option>
                                    {{-- <option value="{{\App\Helpers\Helper::encryptUrl($j->id)}}">{{$j->nama_jurusan}}</option>   --}}
                            </select>
                            @error('get_jurusan')
                            <div class="error invalid-feedback">{{ $message }}</div>
                        @enderror
                        </div>
                        @endcan
                        @can('admin sekolah')
                        <div class="mb-3">
                            <label class="form-label">Nama Jurusan</label>
                            <select class="form-select @error('get_jurusan') is-invalid @enderror" id="get_jurusan" name="get_jurusan">
                                <option value="" selected disabled>Pilih Jurusan</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                    {{-- <option value="{{\App\Helpers\Helper::encryptUrl($j->id)}}">{{$j->nama_jurusan}}</option>   --}}
                                @endforeach
                            </select>
                            @error('get_jurusan')
                            <div class="error invalid-feedback">{{ $message }}</div>
                        @enderror
                        </div>
                        @endcan
                        @can('only class')
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select class="form-select @error('get_kelas') is-invalid @enderror" id="get_kelas" name="get_kelas" @readonly(true)>
                                <option value="{{$kelas->id}}" @readonly(true)>{{$kelas->kelas}}</option>
                            </select>
                            @error('get_kelas')
                            <div class="error invalid-feedback">{{ $message }}</div>
                        @enderror
                        </div>
                        @endcan
                        @can('admin sekolah')
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select class="form-select @error('get_kelas') is-invalid @enderror" id="get_kelas" name="get_kelas">
                                <option selected disabled>Pilih Kelas</option>
                            </select>
                            @error('get_kelas')
                            <div class="error invalid-feedback">{{ $message }}</div>
                        @enderror
                        </div>
                        @endcan
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <div class="input-group date datepicker" id="datePickerExample">
                                <input type="text" class="form-control @error('tgl_mulai') is-invalid @enderror" name="tgl_mulai" />
                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                @error('tgl_mulai')
                                <div class="error invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <div class="input-group date datepicker" id="datePickerExample2">
                                <input type="text" class="form-control @error('tgl_selesai') is-invalid @enderror" name="tgl_selesai" />
                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                @error('tgl_selesai')
                                <div class="error invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Download Rekap</button>
                    </form>
                    <br>
                    <hr>
                    <br>
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

            // $.ajax({
            //     url: `{{ route('getAbsen') }}`,
            //     type: 'POST',
            //     data: data,
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     beforeSend: function() {
            //         show_loading()
            //     },
            //     complete: function() {
            //         hide_loading()
            //     },
            //     success: function(res) {
            //         var data = JSON.parse(res);
            //         calendarAbsen(data);
            //     }
            // });

        })
    </script>
@endsection
