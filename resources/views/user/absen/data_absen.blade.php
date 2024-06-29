@extends('template')
@section('content')    
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3 d-none d-md-block">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-4">Full calendar</h6>
        <div id='external-events' class='external-events'>
          <h6 class="mb-2 text-muted">Draggable Events</h6>
          <div class="mb-3">
            <label class="form-label">Jurusan</label>
            <select type="text" class="form-select" id="get_jurusan" name="get_jurusan">
                <option value="" selected disabled>Pilih Jurusan</option>
                @foreach ($jurusan as $j)
                <option value="{{$j->id}}">{{$j->nama_jurusan}}</option>  
                {{-- <option value="{{\App\Helpers\Helper::encryptUrl($j->id)}}">{{$j->nama_jurusan}}</option>   --}}
                @endforeach
            </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <select type="text" class="form-select" id="get_kelas" name="get_kelas">
                </select>
                </div>
        </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div id='fullcalendar'></div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div id="fullCalModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modalTitle1" class="modal-title"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><span class="visually-hidden">close</span></button>
                </div>
                <div id="modalBody1" class="modal-body">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Edit</button>
                    <a type="button" class="btn btn-danger hapus_absen" id="hapus_absen" data-href="" data-bs-dismiss="modal">Hapus</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Event Page</button>
                </div>
            </div>
        </div>
    </div>

    <div id="createEventModal" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modalTitle2" class="modal-title">Add event</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><span class="visually-hidden">close</span></button>
                </div>
                <div id="modalBody2" class="modal-body">
                    <form action="{{route('input_absen')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" id="nama" placeholder="Nama Siswa" name="nama_siswa" autocomplete="off">
                            <div id="result" class="result"></div>
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Status Kehadiran</label>
                            <select type="text" class="form-select" id="status_kehadiran" name="status_kehadiran">
                                <option value="" selected disabled>Pilih Status</option>                               
                                <option value="hadir">Hadir</option>  
                                <option value="izin">Izin</option>  
                                <option value="sakit">Sakit</option>  
                            </select>
                            
                        </div>                                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Add</button>
                </div>
            </form>
            </div>
        </div>

    <script type="text/javascript">
        $('#get_jurusan').on('change', function getKelas(){
            var value = $('#get_jurusan option:selected').val()
            var data ={ id_jurusan: value }
            
                $('#get_jurusan').click(function(){
                    $.ajax({
                        url: `{{route('getkls')}}`,
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res){
                                $('#get_kelas').html(res)	
                            
                        }
                    })
                });
            
        });
        </script>
        <script>
            $('#get_kelas').on('change', function() {
            var kelas = $('#get_kelas option:selected').val()
            var data = {id_kelas: kelas}

                    $.ajax({
                        url: `{{route('getAbsen')}}`,
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res){
                            var data = JSON.parse(res);
                            calendarAbsen(data);                    
                        }
                    });
             
            })
        </script>
        <script>
            var result = document.getElementById("result");
            var id_jurusan;
            var id_kelas;
            var count_siswa;
	        result.innerHTML="";
	        result.style.border="0px";
            $('#get_jurusan').on('change', function getKelas(){
               id_jurusan = $('#get_jurusan option:selected').val();
            })
            $('#get_kelas').on('change', function getKelas(){
               id_kelas = $('#get_kelas option:selected').val();
            })
	
            $('#nama').on('keyup', function() {
                result.innerHTML="";
                $val = $(this).val();
                if($val == ""){
                    $val = null;
                }

                $.ajax({
                    url: `{{route('search_nama_siswa')}}`,
                    type: 'GET',
                    data: {'search':$val, 'id_sekolah':{{session('id')}}, 'id_jurusan':id_jurusan, 'id_kelas':id_kelas},
                    headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
                    success: function(data) {
                        count_siswa = data.length;
                        if(data.length == 0){
                            result.innerHTML = "Empty";
                        }
                        result.innerHTML = data;
                        console.log(data);
                    }
                })
            })

            function namaSiswa(no){                            
                var nama_siswa = $('.selection_'+no).val();
                var id_siswa = $('.selection_'+no).data('id-siswa');
                $('#nama').val(nama_siswa);
                $('#id_siswa').val(id_siswa);
                
            }

            $('.hapus_absen').click(function (){
                var getLink = $(this).data('href');
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger me-2",
                },
                buttonsStyling: false,
            });

            swalWithBootstrapButtons
                .fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "me-2",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true,
                })
                .then((result) => {
                  console.log(result);
                    if (result.isConfirmed) {
                      window.location.href = getLink
                        
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            "Cancelled",
                            "Your imaginary file is safe :)",
                            "error"
                        );
                    }
                });
  });
        </script>            			
@endsection