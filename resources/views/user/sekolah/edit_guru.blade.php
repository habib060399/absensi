@extends('template')
@section('content')
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Form Edit Guru</h6>
                    <br>
                    <div>
                        <button type="button" class="btn btn-inverse-success btn-icon" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i data-feather="plus"></i></button>                        
                    </div>
                    <br>
                    <hr>
                    <form action="{{route('edit_guru', ['id' => \App\Helpers\Helper::encryptUrl($guru->id)])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Guru</label>
                                    <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" name="nama_guru" value="{{$guru->nama_guru}}">
                                    @error('nama_guru')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$guru->email}}">
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
                                        @foreach ($jabatan as $j)
                                            <option value="{{$j->id}}" {{($get_jabatan == $j->id) ? "selected" : " "}}>{{$j->nama_jabatan}}</option>
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
                                    <input type="text" class="form-control @error('no_wa') is-invalid @enderror" name="no_wa" value="{{$guru->no_wa}}">
                                    @error('no_wa')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->                            
                                <div class="col-sm-4">
                                    <div class="mb-2">
                                        <label class="form-label">Foto</label>
                                          @if ($guru->foto)
                                          <div class="card">
                                              <img src="{{asset('storage/foto_guru/'.$guru->foto)}}" class="card-img-top" alt="..."/>                                                    
                                          </div>
                                          <br>                                              
                                          @endif                                       
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
@endsection
