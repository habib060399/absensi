@extends('template')
@section('content')
<div class="row">
					<div class="col-md-12 stretch-card">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">Form Grid</h6>
								
									<form action="{{route('add_sekolah')}}" method="post">
										@csrf
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Nama Sekolah</label>
													<input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" name="nama_sekolah" placeholder="Nama Sekolah">
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
													<label class="form-label">ID Mesin</label>
													<select class="form-select @error('id_mesin') is-invalid @enderror" id="exampleFormControlSelect1" name="id_mesin">
														<option selected disabled>Pilih Id Mesin</option>
														@foreach ($mesin as $m)
														<option value="{{$m->id}}">{{$m->id_mesin}}</option>								
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
													<select class="form-select @error('pendidikan') is-invalid @enderror" id="exampleFormControlSelect2" name="pendidikan">
														<option selected disabled>Pilih Pendidikan</option>
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
													<label class="form-label">NPSN</label>
													<input type="text" class="form-control @error('npsn') is-invalid @enderror" placeholder="NPSN" name="npsn">
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
													<input type="text" class="form-control @error('contact') is-invalid @enderror" placeholder="Contact" name="contact">
													@error('contact')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
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
										</div><!-- Row -->
										<button type="submit" class="btn btn-primary submit">Submit form</button>
									</form>
							</div>
						</div>
					</div>
				</div>
@endsection