@extends('template')
@section('content')
<div class="row">
    <div class="col-xl-10 main-content ps-xl-4 pe-xl-5">
        <h1 class="page-title">Media Object</h1>        
        <hr>
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

        <hr>
        
        <div class="live-absen">
            <div class="example" id="example">
                <div class="d-flex align-items-start">
                    <img src="../../../assets/images/others/placeholder.jpg" class="wd-100 wd-sm-200 me-3" alt="...">
                    <div class="data" id="data">
                        <h5 class="mb-2 name_student" id="name_student">Nama Siswa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: habib</h5>
                        <h5 class="mb-2" id="date">Tanggal Absen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: habib</h5>
                        <h5 class="mb-2" id="time">Waktu Absen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: habib</h5>
                        <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                    </div>
                </div>
            </div>    
        </div>    
        <hr>                                                                               
    </div>
</div>

@vite('resources/js/app.js')
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
                        console.log(res);
                        
                            $('#get_kelas').html(res)	
                        
                    }
                })
            });
        
    });
    </script>
    <script>
        var currentKelas;
        $('#get_kelas').on('change', function() {
        var kelas = $('#get_kelas option:selected').val()
        var element = document.querySelector('.live-absen');  
        
        if(currentKelas >= 0) {
            location.reload()
        }
        currentKelas = kelas;
    
	    Echo.channel(`live-presence`)
		 .listen('SendPresence', (e) => {
			 console.log('hallo ini event');
            //  console.log(kelas);
             if(e.id_kelas == kelas && `{{$cookies}}` == e.id_mesin){
				console.log(e);
                element.insertAdjacentHTML("beforeBegin", `
            <div class="example" id="example">
                <div class="d-flex align-items-start">
                    <img src="../../../assets/images/others/placeholder.jpg" class="wd-100 wd-sm-200 me-3" alt="...">
                    <div class="data" id="data">
                        <h5 class="mb-2 name_student" id="name_student">Nama Siswa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ${e.name_student}</h5>
                        <h5 class="mb-2" id="date">Tanggal Absen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ${e.date}</h5>
                        <h5 class="mb-2" id="time">Waktu Absen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ${e.time}</h5>         
                    </div>
                </div>
            </div>
            `);	
			 }
            
		 });                   
                    }
            );
    </script>
@endsection