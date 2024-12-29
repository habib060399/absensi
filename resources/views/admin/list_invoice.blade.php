@extends('template')
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Tables</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Sekolah</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Data Invoice</h6>
                <br>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sekolah</th>
                            <th>Paket</th>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice as $i)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$i->nama_sekolah}}</td>
                            <td>{{$i->nama_paket}}</td>
                            <td>{{$i->id}}</td>
                            <td>{{$i->created_at}}</td>
                            <td>
                                <a href="{{route('invoice-download', ['id' => \App\Helpers\Helper::encryptUrl($i->id)])}}" target="_blank">Download PDF</a>
                                <a href="{{route('invoice2',['id' => \App\Helpers\Helper::encryptUrl($i->id)])}}">Invoice</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
