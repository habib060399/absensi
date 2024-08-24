@extends('template')
@section('content')
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Form Grid</h6>
                    <form action="{{ route('edit_siswa', ['id' => \App\Helpers\Helper::encryptUrl($siswa->id)]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Siswa</label>
                                    <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" name="nama_siswa" value="{{ $siswa->nama_siswa }}">
                                    @error('nama_siswa')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ $siswa->email }}" name="email">
                                    @error('email')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                    <select class="form-select @error('jurusan') is-invalid @enderror" id="get_jurusan" name="jurusan">
                                        @foreach ($jurusan as $j)
                                            <option value="{{ $j->id }}" {{ $j->id == $siswa->id_jurusan ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Kelas</label>
                                    <select class="form-select @error('kelas') is-invalid @enderror" id="get_kelas" name="kelas">
                                    </select>
                                    @error('kelas')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">No HP</label>
                                    <input type="text" class="form-control @error('npsn') is-invalid @enderror" value="{{ $siswa->no_hp }}" name="no_hp">
                                    @error('no_hp')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">No HP Orangtua</label>
                                    <input type="text" class="form-control @error('no_hp_ortu') is-invalid @enderror" value="{{ $siswa->no_hp_ortu }}" name="no_hp_ortu">
                                    @error('no_hp_ortu')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">RFID Tag</label>
                                    <input type="text" class="form-control @error('rfid') is-invalid @enderror" autocomplete="off" name="rfid" id="rfid" readonly>
                                    @error('rfid')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto</label>
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror" placeholder="Foto" name="foto">
                                    @error('foto')
                                        <div class="error invalid-feedback">{{ $message }}</div>
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

    <script type="text/javascript">
        var get_id_jurusan = $('#get_jurusan option:selected').val()
        var get_id_kelas = {{ $siswa->id_kelas }}
        var data = {
            id_jurusan: get_id_jurusan,
            id_kelas: get_id_kelas
        }
        $(document).ready(function() {
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
                    // console.log(res);
                    $('#get_kelas').html(res)
                }
            });

        });

        $('#get_jurusan').on('change', function() {
            var get_id = $('#get_jurusan option:selected').val()
            $('#get_jurusan option').removeAttr('selected');
            $.ajax({
                url: `{{ route('getkls') }}`,
                type: 'POST',
                data: {
                    id_jurusan: get_id
                },
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
        // $('#jurusan').on('change', function getKelas(){
        // 	var data ={ id_jurusan: value }

        // 		$('#jurusan').click(function(){
        // 			$.ajax({
        // 				url: `{{ route('getkls') }}`,
        // 				type: 'POST',
        // 				data: data,
        // 				headers: {
        // 					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // 				},
        // 				success: function(res){
        // 					console.log(res);

        // 						$('#kelas').html(res)	

        // 				}
        // 			})
        // 		});

        // });
    </script>
@endsection
