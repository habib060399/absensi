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
                    <form action="{{ route('edit_bc') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">

                                @foreach ($pesan->data as $p)
                                <div class="mb-3">
                                    {{-- <input type="hidden" name="id_sekolah" id=""
                                        value="{{ \App\Helpers\Helper::encryptUrl($id_sekolah) }}"> --}}
                                    <label class="form-label">Pesan : {{$p->title}}</label>
                                    <textarea style="height: 155px" type="text" class="form-control @error('email') is-invalid @enderror" name="broadcast-{{$p->title}}">{{$p->message}}</textarea>
                                </div>
                                @endforeach
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="p-2">
                                <p class="">Format Broadcast Whatsapp</p>
                                <br>
                                    <p class="">Salam</p>
                                    <p class="">Bapak/Ibu Orangtua siswa</p>
                                    <p class="">{nama} Telah hadir di sekolah SMK PAB 12 SAENTIS</p>
                                    <p class="">==============================</p>
                                    <p class="">Note : Pesan ini adalah pesan sistem tidak perlu membalas pesan ini</p>
                                    <br>
                                    <p><span class="">Note: format pengetikan {nama} digunakan untuk menampung dari nama setiap siswa</span></p>
                                </div>
                            </div>
                        </div><!-- Row -->
                        <button type="submit" class="btn btn-primary submit">Submit form</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
