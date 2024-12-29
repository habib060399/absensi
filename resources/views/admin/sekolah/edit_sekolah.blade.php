@extends('template')
@section('content')
<div class="row">
					<div class="col-md-12 stretch-card">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title mb-5">Edit sekolah {{$sekolah->nama_sekolah}}</h6>
									<form action="{{route('simpan-edit-sekolah', ['id' => \App\Helpers\Helper::encryptUrl($sekolah->id)])}}" method="post">
										@csrf
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Nama Sekolah</label>
													<input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" name="nama_sekolah" value="{{$sekolah->nama_sekolah}}">
													@error('nama_sekolah')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Email</label>
													<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$sekolah->email}}">
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
													<select class="form-select @error('id_mesin') is-invalid @enderror" id="exampleFormControlSelect1" name="id_mesin" disabled>
														<option selected disabled>{{$sekolah->id_mesin}}</option>
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
														<option value="SMA" {{ ($sekolah->pendidikan == 'SMA') ? 'selected' : '' }}>SMA</option>
														<option value="SMK" {{ ($sekolah->pendidikan == 'SMK') ? 'selected' : '' }}>SMK</option>
														<option value="SMP" {{ ($sekolah->pendidikan == 'SMP') ? 'selected' : '' }}>SMP</option>
													</select>
													@error('pendidikan')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">NPSN</label>
													<input type="text" class="form-control @error('npsn') is-invalid @enderror" name="npsn" value="{{$sekolah->npsn}}">
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
													<input type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{$sekolah->no_hp}}">
													@error('contact')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-5">
												<div class="mb-3">
													<label class="form-label">Username</label>
													<input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{$user->username}}">
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
                                        <div class="row">
											<div class="col-sm-5">
												<div class="mb-3">
													<label class="form-label">Token API WA</label>
													<input type="text" class="form-control @error('token_api_wa') is-invalid @enderror" name="token_api_wa" {{($wa->token_account_wa) ? "value=$wa->token_account_wa"  : 'placeholder=Token'}}>
												</div>
											</div><!-- Col -->
											<div class="col-sm-3">
												<div class="mb-3">
													<label class="form-label">Paket Langganan</label>
													<select class="form-select @error('paket') is-invalid @enderror" id="exampleFormControlSelect2" name="paket" disabled>
														<option selected disabled>Pilih Paket</option>
                                                        @foreach($paket as $p)
                                                        <option value="{{$p->id}}" {{($sekolah->id_paket == $p->id) ? 'selected' : ''}}>{{$p->nama_paket}}</option>
                                                        @endforeach
													</select>
												</div>
											</div><!-- Col -->
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">Token Akun WA</label>
													<input type="text" class="form-control @error('token_akun_wa') is-invalid @enderror" name="token_akun_wa" {{($wa->token_api_wa) ? "value=$wa->token_api_wa"  : 'placeholder=Token'}}>
													@error('token_akun_wa')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Slug</label>
                                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" placeholder="Slug" name="slug" value="{{$sekolah->id_slug_user}}">
                                                    @error('slug')
                                                    <div class="error invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div><!-- Col -->
                                        </div><!-- Row -->

                                        <h6 class="card-title mb-3">Feature Paket {{$sekolah->nama_paket}}</h6>
                                        @foreach($paket_detail as $d)
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="checkDisabled" {{ ($d->status == "active") ? "disabled checked" : "disabled"}}>
                                            <label class="form-check-label" for="checkDisabled">
                                                {{$d->text}}
                                            </label>
                                        </div>
                                        @endforeach
                                        <div class="form-check mb-4">
                                        </div>

										<button type="submit" class="btn btn-primary submit">Submit form</button>
									</form>
							</div>
						</div>
					</div>
				</div>
@endsection
