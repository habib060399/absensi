@extends('template')
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Users</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Form Grid</h6>
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-primary submit" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalCenter">Reset Data Absen</button>
                                <button type="button" class="btn btn-primary submit" data-bs-toggle="modal"
                                    data-bs-target="#tahun_ajaran">Tahun Ajaran</button>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="p-2">
                                    <p class="">Format Broadcast Whatsapp</p>
                                    <br>
                                    <p class="">Salam</p>
                                    <p class="">Bapak/Ibu Orangtua siswa</p>
                                    <p class="">{nama} Telah hadir di sekolah SMK PAB 12 SAENTIS</p>
                                    <p class="">==============================</p>
                                    <p class="">Note : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini
                                    </p>
                                    <br>
                                    <p><span class="">Note: format pengetikan {nama} digunakan untuk menampung dari
                                            nama setiap siswa</span></p>
                                </div>
                            </div>
                        </div><!-- Row -->
                        <button type="submit" class="btn btn-primary submit">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tahun_ajaran" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Tahun Ajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tahun_ajaran') }}" method="post">
                        @csrf                        
                        <label class="form-label">Awal Tanggal</label>
                        <div class="input-group date datepicker" id="awal_ajaran">
                            <input type="text" class="form-control @error('awal_ajaran') is-invalid @enderror"
                                name="awal_ajaran" value="{{($tahun_ajaran) ? $tahun_ajaran->th_ajaran_awal : ' ' }}"/>
                            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                            @error('awal_ajaran')
                                <div class="error invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="form-label">Akhir Tanggal</label>
                        <div class="input-group date datepicker" id="akhir_ajaran">
                            <input type="text" class="form-control @error('akhir_ajaran') is-invalid @enderror"
                                name="akhir_ajaran" value="{{($tahun_ajaran) ? $tahun_ajaran->th_ajaran_akhir : ' ' }}"/>
                            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                            @error('akhir_ajaran')
                                <div class="error invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" >            
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Tahun Ajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            @csrf
                            <label class="form-label">Pilih Kelas</label>
                            <select class="form-select" name="">                        
                                <option value="">==Pilih Kelas==</option> 
                                @foreach($kelas as $k)
                                <option value="">{{$k->kelas}}</option>                                
                                @endforeach                                                               
                            </select>
                            @error('nama_siswa')
                                <div class="error invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endsection
