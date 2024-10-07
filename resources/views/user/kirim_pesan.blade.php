@extends('template')
@section('content')
    <div class="row inbox-wrapper">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="p-3 pb-0">
                            <div class="subject">
                                <div class="row mb-3">
                                    <label class="col-md-2 col-form-label">Jurusan</label>
                                    @can('admin sekolah')
                                    <div class="col-md-10">
                                        <select type="text" class="form-select" id="get_jurusan" name="get_jurusan">
                                            <option value="" selected disabled>Pilih Jurusan</option>
                                            @foreach ($jurusan as $j)
                                                <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endcan
                                    @can('only class')
                                    <div class="col-md-10">
                                        <select type="text" class="form-select" id="get_jurusan" name="get_jurusan">
                                            <option value="{{$kelas->id_jurusan}}" selected>{{$jurusan->nama_jurusan}}</option>                                        
                                        </select>
                                    </div>
                                    @endcan
                                </div>
                            </div>
                            @can('admin sekolah')
                            <div class="subject">
                                <div class="row mb-3">
                                    <label class="col-md-2 col-form-label">Kelas</label>
                                    <div class="col-md-10">
                                        <select type="text" class="form-select" id="get_kelas" name="get_kelas">
                                            <option value="" selected disabled>Pilih Kelas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endcan
                            @can('only class')
                            <div class="subject">
                                <div class="row mb-3">
                                    <label class="col-md-2 col-form-label">Kelas</label>
                                    <div class="col-md-10">
                                        <select type="text" class="form-select" id="get_kelas" name="get_kelas">
                                            <option value="{{$kelas->id}}" selected disabled>{{$kelas->kelas}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endcan                            
                            <form action="{{ route('send_bc') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="subject">
                                    <div class="row mb-3">
                                        <label class="col-md-2 col-form-label">File</label>
                                        <div class="col-md-10">
                                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                                            @error('file')
                                                <div class="error invalid-feedback">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="to">
                                    <div class="row mb-3">
                                        <label class="col-md-2 col-form-label">To:</label>
                                        <div class="col-md-10">
                                            <select class="compose-multiple-select form-select" multiple="multiple"
                                                id="to_siswa" name="to_siswa[]">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="mb-4">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="radioInline" id="no_ortu">
                                <label class="form-check-label" for="radioInline1">
                                    Semua Orangtua Siswa
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="radioInline" id="no_siswa">
                                <label class="form-check-label" for="radioInline2">
                                    Semua Siswa
                                </label>
                            </div>
                        </div>
                        <div class="px-3">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label visually-hidden" for="simpleMdeEditor">Descriptions </label>
                                    <textarea class="form-control" name="pesan" id="simpleMdeEditor" rows="5"></textarea>
                                </div>
                            </div>
                            <div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary me-1 mb-1" type="submit"> Send</button>
                                    <button class="btn btn-secondary me-1 mb-1" type="button"> Cancel</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @can('only class')
            <script>               
                var get_id_jurusan = $('#get_jurusan option:selected').val()
                $('#no_ortu').on('click', function() {
                    var kelas = $('#get_kelas option:selected').val()
                    getSiswa(get_id_jurusan, kelas, "ortu")
                })

                $('#no_siswa').on('click', function() {
                    var kelas = $('#get_kelas option:selected').val()
                    getSiswa(get_id_jurusan, kelas, "siswa")
                })

                $('#get_kelas').on('change', function() {
                    var kelas = $('#get_kelas option:selected').val()
                    $('#no_ortu').prop('checked', false)
                    $('#no_siswa').prop('checked', false)
                    getSiswa(get_id_jurusan, kelas)

                })

                function getSiswa(id_jurusan, id_kelas, selected = null) {
                    var data = {
                        id_jurusan: id_jurusan,
                        id_kelas: id_kelas,
                        selected: selected
                    }

                    $.ajax({
                        url: `{{ route('getSiswa') }}`,
                        type: 'POST',
                        data: data,
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
                            $('#to_siswa').html(res);

                        }
                    });
                }
            </script>
            @endcan
            @can('admin sekolah')
            <script type="text/javascript">
                var get_id_jurusan;
                $('#get_jurusan').on('change', function getKelas() {
                    get_id_jurusan = $('#get_jurusan option:selected').val()
                    var data = {
                        id_jurusan: get_id_jurusan
                    }

                    $('#get_jurusan').click(function() {
                        $.ajax({
                            url: `{{ route('getkls') }}`,
                            type: 'POST',
                            data: data,
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
                                $('#get_kelas').html(res)

                            }
                        })
                    });

                });

                $('#no_ortu').on('click', function() {
                    var kelas = $('#get_kelas option:selected').val()
                    getSiswa(get_id_jurusan, kelas, "ortu")
                })

                $('#no_siswa').on('click', function() {
                    var kelas = $('#get_kelas option:selected').val()
                    getSiswa(get_id_jurusan, kelas, "siswa")
                })

                $('#get_kelas').on('change', function() {
                    var kelas = $('#get_kelas option:selected').val()
                    $('#no_ortu').prop('checked', false)
                    $('#no_siswa').prop('checked', false)
                    getSiswa(get_id_jurusan, kelas)

                })

                function getSiswa(id_jurusan, id_kelas, selected = null) {
                    var data = {
                        id_jurusan: id_jurusan,
                        id_kelas: id_kelas,
                        selected: selected
                    }

                    $.ajax({
                        url: `{{ route('getSiswa') }}`,
                        type: 'POST',
                        data: data,
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
                            $('#to_siswa').html(res);

                        }
                    });
                }
            </script>
            @endcan
            <script>
                $(function() {
                    'use strict'

                    if ($(".compose-multiple-select").length) {
                        $(".compose-multiple-select").select2();
                    }
                    if ($(".js-example-basic-multiple").length) {
                        $(".js-example-basic-multiple").select2();
                    }
                });
            </script>
            <script>
                $(function() {
                    'use strict';

                    /*simplemde editor*/
                    if ($("#simpleMdeEditor").length) {
                        var simplemde = new SimpleMDE({
                            element: $("#simpleMdeEditor")[0]
                        });
                    }

                });
            </script>
        @endsection
