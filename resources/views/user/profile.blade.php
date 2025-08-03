@extends('template')
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Tables</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Users</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Sekolah</h6>

                <form class="forms-sample">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Sekolah</label>
                                <input type="text" class="form-control" value="{{$data['nama_sekolah']}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NPSN</label>
                                <input type="text" class="form-control" value="{{$data['npsn']}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Whatssap Sistem</label>
                                <input type="text" class="form-control" value="{{$data['no_hp']}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenjang Pendidikan</label>
                                <input type="text" class="form-control" value="{{$data['pendidikan']}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" value="{{$data['email']}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kepala Sekolah</label>
                                <input type="text" class="form-control" value="{{$data['nama_guru']}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Hp/Whatsapp Kepala Sekolah</label>
                                <input type="text" class="form-control" value="{{$data['no_wa']}}" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="exampleInputUsername1" class="form-label">ID Mesin</label>
                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Daftar Jurusan</label>
                                @foreach($jurusan as $j)
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <label class="form-check-label" for="checkDisabled">
                                        {{$j->nama_jurusan}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Daftar Jurusan</label>
                                @foreach($kelas as $k)
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" checked>
                                    <label class="form-check-label" for="checkDisabled">
                                        {{$k->kelas}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">List Paket</label>
                                @foreach($paket as $d)
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="checkDisabled" {{ ($d->status == "active") ? "disabled checked" : "disabled"}}>
                                    <label class="form-check-label" for="checkDisabled">
                                        {{$d->text}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
