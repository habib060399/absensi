@extends('template')
@section('content')
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Form Guru</h6>
                    <br>
                    <div>
                        <button type="button" class="btn btn-inverse-success btn-icon" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i data-feather="plus"></i></button>
                    </div>
                    <br>
                    <hr>
                    <form action="{{route('guru_tambah')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Guru</label>
                                    <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" name="nama_guru" placeholder="Nama Guru">
                                    @error('nama_guru')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email">
                                    @error('email')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <select class="form-select @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan">
                                        <option value="" selected disabled>Pilih Jabatan</option>
                                        @foreach ($jabatan as $j)
                                            <option value="{{$j->id}}">{{$j->nama_jabatan}}</option>
                                        @endforeach
                                    </select>
                                    @error('jabatan')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">No Whatssap</label>
                                    <input type="text" class="form-control @error('no_wa') is-invalid @enderror" placeholder="No Whatssap" name="no_wa">
                                    @error('no_wa')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                                <div class="col-sm-4">
                                    <div class="mb-2">
                                        <label class="form-label">Foto</label>
                                        <input type="file" class="form-control @error('foto') is-invalid @enderror" placeholder="Foto" name="foto">
                                        @error('foto')
                                            <div class="error invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            @jurusan
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Jurusan</label>
                                        <select id="mySelect2" class="form-select" multiple="multiple" name="jurusan[]">
                                            @foreach ($jurusan as $j)
                                            <option value="{{$j->id}}">{{$j->nama_jurusan}}</option>
                                            @endforeach
                                        </select>
                                    @error('jurusan')
                                        <div class="error invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div><!-- Col -->
                            @endjurusan
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Kelas</label>
                                        <select class="compose-multiple-select2 form-select" multiple="multiple"
                                            id="get_kelas" name="kelas[]">
                                        </select>
                                    @error('kelas')
                                        <div class="error invalid-feedback">{{ $message }}</div>
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

    <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('add_jabatan')}}" method="post">
            @csrf
          <label class="form-label">Nama Jabatan</label>
          <input type="text" class="form-control" name="nama_jabatan">
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
      </div>
    </div>
@jurusan
    <script>
        $(document).ready(function() {
        $('#mySelect2').select2();

        var html = [];
        var element = "";
        $('#mySelect2').on('change', function(){
            var selectedData = $('#mySelect2').select2('data');
            console.log(selectedData);

            for (let i = 0; i < selectedData.length; i++) {
                if(selectedData[i].selected){
                    var id = selectedData[i].id;
                    console.log(id);

                    $.ajax({
                            url: `{{ route('getkls2') }}`,
                            type: 'POST',
                            data: {id_jurusan: id},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: function() {
                                show_loading()
                            },
                            complete: function() {
                                hide_loading()
                            },
                            success: function(res) {
                                console.log(res)
                                html.push(res)
                                $('#get_kelas').html(html)
                            }
                        })
                        html.splice(-1,selectedData.length)
                        console.log(html);
                }
            }
        })
    })
    </script>
@else
<script type="text/javascript">
    $.ajax({
        url: `{{ route('get_all_kelas') }}`,
        type: 'GET',
        success: function(res) {
            console.log(res);

            $('#get_kelas').html(res)

        }
    })
</script>
@endjurusan
        <script>

            $(function multiple () {
                'use strict'

                if ($(".compose-multiple-select2").length) {
                    $(".compose-multiple-select2").select2();
                }
                if ($(".js-example-basic-multiple2").length) {
                    $(".js-example-basic-multiple2").select2();
                }
            });
        </script>
@endsection
