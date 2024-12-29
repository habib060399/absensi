@extends('template')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid d-flex justify-content-between">
                    <div class="col-lg-3 ps-0">
                        <a href="#" class="noble-ui-logo d-block mt-3">Flockbase<span>ID</span></a>
                        <h5 class="mt-5 mb-2 text-muted">Invoice to :</h5>
                        <p>{{$invoice->nama_sekolah}}<br> 102, 102  Crown Street,<br> London, W3 3PR.</p>
                    </div>
                    <div class="col-lg-3 pe-0">
                        <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2">invoice</h4>
                        <h6 class="text-end mb-5 pb-4"># INV-002308</h6>
                        <p class="text-end mb-1">Balance Due</p>
                        <h4 class="text-end fw-normal">@currency($invoice->total)</h4>
                        <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted">Invoice Date :</span>{{$invoice->created_at}}</h6>
                    </div>
                </div>
                <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                    <div class="table-responsive w-100">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Paket</th>
                                <th class="text-end">Paket Detail</th>
                                <th class="text-end">Kuantiti</th>
                                <th class="text-end">harga</th>
                                <th class="text-end">total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="align-text-top">
                                <td class="text-start">1</td>
                                <td class="text-start">{{$invoice->nama_paket}}</td>
                                <td class="text-wrap" style="width: 30rem">{{$paket_detail}}</td>
                                <td>{{$invoice->kuantiti}}</td>
                                <td>@currency($invoice->harga)</td>
                                <td>@currency($invoice->total)</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container-fluid mt-5 w-100">
                    <div class="row">
                        <div class="col-md-6 ms-auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-end">@currency($invoice->total)</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
