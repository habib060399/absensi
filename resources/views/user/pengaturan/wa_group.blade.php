@extends('template')
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Tables</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Users</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Whatssap</h6>
                <br>
                <div>
                    <a href="{{route('wa_update')}}" class="btn btn-inverse-warning btn-icon"><i data-feather="refresh-ccw"></i></a>
                    <hr>
                </div>
                <br>
                <div class="table-responsive">
                    <table id="dataTable" class="table">
                        <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Id Group</th>
                            <th>Nama Group</th>
                            <th>Jumlah Anggota</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($group_wa as $g)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$g->id}}</td>
                            <td>{{$g->name}}</td>
                            <td>{{count(explode(',', $g->member))}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
</script>
@endsection
