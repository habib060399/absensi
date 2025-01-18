@extends('template')
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Kelas</li>
        </ol>
    </nav>
    <div class="row">
                        <div class="col-md-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Form Grid</h6>
                                        <form action="{{route("e.kelas", ['id' => \App\Helpers\Helper::encryptUrl($kelas->id)])}}" method="post">
                                            @csrf
                                            <div class="row">
                                                @role('sekolah')
                                                @jurusan
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Jurusan {{$kelas->id_jurusan}}</label>
                                                        <select class="form-select" id="jurusan_sekolah" name="jurusan">
                                                            \App\Helpers\Helper::encryptUrl($k->id)
                                                            @foreach ($jurusan as $j)
                                                            <option value="{{\App\Helpers\Helper::encryptUrl($j->id)}}" {{($kelas->id_jurusan == $j->id) ? 'selected' : ''}}>{{$j->nama_jurusan}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('nama_siswa')
                                                            <div class="error invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div><!-- Col -->                                                
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Kelas</label>
                                                        <select class="form-select" id="kelas_sekolah" name="kelas">

                                                        </select>
                                                        @error('kelas')
                                                            <div class="error invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div><!-- Col -->
                                                @else
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Kelas</label>
                                                        <input type="text" class="form-control @error('kelas') is-invalid @enderror" name="kelas" value="{{$kelas->kelas}}">
                                                        @error('kelas')
                                                            <div class="error invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div><!-- Col -->
                                                @endjurusan
                                                @endrole
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{$user->username}}">
                                                        @error('username')
                                                            <div class="error invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div><!-- Col -->
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Password</label>
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                                        @error('password')
                                                            <div class="error invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div><!-- Col -->
                                            </div><!-- Row -->
                                            <button type="submit" class="btn btn-primary submit">Submit form</button>
                                        </form>
                                </div>
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
                @endjurusan                
@endsection
