@extends('template')
@section('content')    
<div class="page-content">

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
          <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
            <div class='fc-event-main'>Birth Day</div>
          </div>
          <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
            <div class='fc-event-main'>New Project</div>
          </div>
          <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
            <div class='fc-event-main'>Anniversary</div>
          </div>
          <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
            <div class='fc-event-main'>Clent Meeting</div>
          </div>
          <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event hii'>
            <div class='fc-event-main'>Office Trip</div>
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
                <div id="modalBody1" class="modal-body"></div>
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
                    <form>
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Example label</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Another label</label>
                            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Add</button>
                </div>
            </div>
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
@endsection