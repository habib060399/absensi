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
                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NPWP</label>
                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Whatssap Sistem</label>
                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenjang Pendidikan</label>
                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kepala Sekolah</label>
                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Hp/Whatsapp Kepala Sekolah</label>
                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="exampleInputUsername1" class="form-label">ID Mesin</label>
                                <input type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Daftar Jurusan</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Daftar Kelas</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Paket List</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
