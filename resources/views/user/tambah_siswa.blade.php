@extends('template')
@section('content')
<div class="page-content">
<div class="row">
					<div class="col-md-12 stretch-card">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">Form Grid</h6>
								
									<form action="" method="post">
										@csrf
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Nama Siswa</label>
													<input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" name="nama_siswa" placeholder="Nama Siswa">
													@error('nama_sekolah')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Email</label>
													<input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email">
													@error('email')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
										<div class="row">
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">Jurusan</label>
													<select class="form-select @error('id_mesin') is-invalid @enderror" id="exampleFormControlSelect1" name="jurusan">
														<option selected disabled>Pilih Jurusan</option>
														
														<option value=""></option>								
														
													</select>													
													@error('id_mesin')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">Kelas</label>
													<select class="form-select @error('pendidikan') is-invalid @enderror" id="exampleFormControlSelect2" name="kelas">
														<option selected disabled>Pilih Kelas</option>
														<option>SMA</option>
														<option>SMK</option>
													</select>
													@error('pendidikan')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">No HP</label>
													<input type="text" class="form-control @error('npsn') is-invalid @enderror" placeholder="No HP" name="no_hp">
													@error('npsn')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">No HP Orangtua</label>
													<input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="No HP Orangtua" name="no_hp_ortu">
													@error('username')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">RFID Tag</label>
													<input type="text" class="form-control @error('password') is-invalid @enderror" autocomplete="off" name="password" id="rfid" readonly>
													@error('password')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->                                            
										</div><!-- Row -->
                                        <div class="row">																						
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">Foto</label>
													<input type="file" class="form-control @error('npsn') is-invalid @enderror" placeholder="Foto" name="foto">
													@error('npsn')
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
</div>

@vite('./resources/js/app.js')
    <script type="module">
		var rfid = document.getElementById('rfid');
        Echo.channel(`Presence`)
            .listen('SendPresence', (e) => {
                console.log('hallo ini event');
                console.log(e);
				rfid.value = e.welcome;
                // console.log(e.welcome);
                // document.write("<h1>" + e.welcome + "</h1>")
            });
    </script>
@endsection