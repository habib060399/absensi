@extends('template')
@section('content')
<div class="page-content">
<div class="row">
					<div class="col-md-12 stretch-card">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">Form Grid</h6>								
									<form action="{{route('add_siswa')}}" method="post">
										@csrf
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Nama Siswa</label>
													<input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" name="nama_siswa" placeholder="Nama Siswa">
													@error('nama_siswa')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">Email</label>
													<input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email">
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
													<select class="form-select @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan">
														<option value="" selected disabled>Pilih Jurusan</option>
														@foreach ($jurusan as $j)
														<option value="{{$j->id}}">{{$j->nama_jurusan}}</option>																							
														@endforeach														
													</select>													
													@error('jurusan')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">Kelas</label>
													<select class="form-select @error('kelas') is-invalid @enderror" id="kelas" name="kelas">
														<option selected disabled>Pilih Kelas</option>																												
													</select>
													@error('kelas')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">No HP</label>
													<input type="text" class="form-control @error('npsn') is-invalid @enderror" placeholder="No HP" name="no_hp">
													@error('no_hp')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">No HP Orangtua</label>
													<input type="text" class="form-control @error('no_hp_ortu') is-invalid @enderror" placeholder="No HP Orangtua" name="no_hp_ortu">
													@error('no_hp_ortu')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">RFID Tag</label>
													<input type="text" class="form-control @error('rfid') is-invalid @enderror" autocomplete="off" name="rfid" id="rfid" readonly>
													@error('rfid')
														<div class="error invalid-feedback">{{$message}}</div>
													@enderror
												</div>
											</div><!-- Col -->                                            
										</div><!-- Row -->
                                        <div class="row">																						
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">Foto</label>
													<input type="file" class="form-control @error('foto') is-invalid @enderror" placeholder="Foto" name="foto">
													@error('foto')
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
		 .listen('ScanRFID', (e) => {
			 console.log('hallo ini event');
			 console.log(e);
			 if(`{{$cookies}}` == e.id_mesin){
				 rfid.value = e.rfid_tag;
			 }				
		 });
</script>
    <script type="text/javascript">
	$('#jurusan').on('change', function getKelas(){
		var value = $('#jurusan option:selected').val()
		var data ={ id_jurusan: value }
		
			$('#jurusan').click(function(){
				$.ajax({
					url: `{{route('getkls')}}`,
					type: 'POST',
					data: data,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(res){
						console.log(res);
						
							$('#kelas').html(res)	
						
					}
				})
			});
		
	});
    </script>
@endsection