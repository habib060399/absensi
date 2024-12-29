@extends('template')
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Forms</a></li>
        <li class="breadcrumb-item active" aria-current="page">Wizard</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Horizontal wizard</h4>
                <p class="text-muted mb-3">Read the Official jQuery Steps Documentation </a>for a full list of instructions and other options.</p>
                <form id="wizard" action="{{route('add_sekolah')}}" method="post">
                    @csrf
                    <h2>First Step</h2>
                    <section data-step-index = "0">
<!--                        <h4 class="mb-3">Pilih Paket</h4>-->
                        <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">Daftar Paket</label>
                                <select class="form-select @error('paket') is-invalid @enderror" id="paket" name="paket">
                                    <option selected disabled>Pilih paket</option>
                                    @foreach($paket as $p)
                                        <option value="{{$p->id}}" {{ (old('paket') == $p->id) ? 'selected' : '' }}>{{$p->nama_paket}}</option>
                                    @endforeach
                                </select>
                                @error('paket')
                                <div class="error invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div><!-- Col -->
                            <div class="col-md-4 stretch-card grid-margin grid-margin-md-0" id="render-paket">
                            </div>
                        </div>
                    </section>

                    <h2>Second Step</h2>
                    <section data-step-index = "1">
<!--                        <h4>Second Step</h4>-->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Sekolah</label>
                                    <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" name="nama_sekolah" placeholder="Nama Sekolah" value="{{old('nama_sekolah')}}">
                                    @error('nama_sekolah')
                                    <div class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{old('email')}}">
                                    @error('email')
                                    <div class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">ID Mesin</label>
                                    <select class="form-select @error('id_mesin') is-invalid @enderror" id="exampleFormControlSelect1" name="id_mesin">
                                        <option selected disabled>Pilih Id Mesin</option>
                                        @foreach($mesin as $m)
                                            <option value="{{$m->id}}" {{ (old('id_mesin') == $m->id) ? 'selected' : ''}} >{{$m->id_mesin}}</option>
                                        @endforeach
                                    </select>
                                    @error('id_mesin')
                                    <div class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Pendidikan</label>
                                    <select class="form-select @error('pendidikan') is-invalid @enderror" id="pendidikan" name="pendidikan">
                                        <option selected disabled>Pilih Pendidikan</option>
                                        <option value="SMA">SMA</option>
                                        <option value="SMK">SMK</option>
                                        <option value="SMP">SMP</option>
                                    </select>
                                    @error('pendidikan')
                                    <div class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">NPSN</label>
                                    <input type="text" class="form-control @error('npsn') is-invalid @enderror" placeholder="NPSN" name="npsn" value="{{old('npsn')}}">
                                    @error('npsn')
                                    <div class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Contact</label>
                                    <input type="text" class="form-control @error('contact') is-invalid @enderror" placeholder="Contact" name="contact" value="{{old('contact')}}">
                                    @error('contact')
                                    <div class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" placeholder="Slug" name="slug" value="{{old('slug')}}">
                                    @error('slug')
                                    <div class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                    </section>

                    <h2>Third Step</h2>
                    <section data-step-index = "2">
<!--                        <h4>Third Step</h4>-->
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username">
                                    @error('username')
                                    <div class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="off" placeholder="Password" name="password">
                                    @error('password')
                                    <div class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3" id="check_jurusan">

                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4" id="count-siswa">

                            </div><!-- Col -->
                        </div><!-- Row -->
                    </section>

<!--                    <h2>Fourth Step</h2>-->
<!--                    <section>-->
<!--                        <h4>Fourth Step</h4>-->
<!--                        <p>Quisque at sem turpis, id sagittis diam. Suspendisse malesuada eros posuere mauris vehicula vulputate. Aliquam sed sem tortor.-->
<!--                            Quisque sed felis ut mauris feugiat iaculis nec ac lectus. Sed consequat vestibulum purus, imperdiet varius est pellentesque vitae.-->
<!--                            Suspendisse consequat cursus eros, vitae tempus enim euismod non. Nullam ut commodo tortor.</p>-->
<!--                    </section>-->
                </form>
            </div>
        </div>
    </div>
</div>

<script>

</script>
@endsection
