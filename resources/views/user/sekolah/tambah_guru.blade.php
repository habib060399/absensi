@extends('template')
@section('content')
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Form Guru</h6>
                    <br>
                    <div>
                        <button type="button" class="btn btn-inverse-success btn-icon" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i data-feather="plus"></i></button>                        
                    </div>
                    <br>
                    <hr>
                    <form action="{{route('guru_tambah')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Guru</label>
                                    <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" name="nama_guru" placeholder="Nama Guru">
                                    @error('nama_guru')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email">
                                    @error('email')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <select class="form-select @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan">
                                        <option value="" selected disabled>Pilih Jabatan</option>
                                        @foreach ($jabatan as $j)
                                            <option value="{{$j->id}}">{{$j->nama_jabatan}}</option>
                                        @endforeach
                                    </select>
                                    @error('jabatan')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">No Whatssap</label>
                                    <input type="text" class="form-control @error('no_wa') is-invalid @enderror" placeholder="No Whatssap" name="no_wa">
                                    @error('no_wa')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->                            
                                <div class="col-sm-4">
                                    <div class="mb-2">
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

    <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('add_jabatan')}}" method="post">
            @csrf
          <label class="form-label">Nama Jabatan</label>
          <input type="text" class="form-control" name="nama_jabatan">
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
      </div>
    </div>
@endsection
