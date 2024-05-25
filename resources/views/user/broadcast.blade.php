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
                                        <form action="{{route('edit_bc')}}" method="post">
                                            @csrf
                                            <div class="row">                                            
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <input type="hidden" name="id_sekolah" id="" value="{{\App\Helpers\Helper::encryptUrl($id_sekolah)}}">
                                                        <label class="form-label">Pesan</label>
                                                        <textarea type="text" class="form-control @error('email') is-invalid @enderror" name="broadcast">{{$broadcast->bc}}</textarea>                                                  
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