@extends('template')
@section('content')				
	<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
	  <div>
		<h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
	  </div>
	</div>

	<div class="row">
	  <div class="col-12 col-xl-12 stretch-card">
		<div class="row flex-grow-1">
		  <div class="col-md-4 grid-margin stretch-card">
			<div class="card">
			  <div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline">
				  <h6 class="card-title mb-0">Kuota WA</h6>
				  <div class="dropdown mb-2">
				  </div>
				</div>
				<div class="row">
				  <div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2 text-success">{{$quota}}</h3>
				  </div>
				  <div class="col-6 col-md-12 col-xl-7">
					<div id="customersChart" class="mt-md-3 mt-xl-0"></div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-md-4 grid-margin stretch-card">
			<div class="card">
			  <div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline">
				  <h6 class="card-title mb-0">Jumlah Sekolah</h6>
				  <div class="dropdown mb-2">					
				  </div>
				</div>
				<div class="row">
				  <div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2">{{$jml_sekolah}}</h3>				
				  </div>
				  <div class="col-6 col-md-12 col-xl-7">
					<div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		  <div class="col-md-4 grid-margin stretch-card">
			<div class="card">
			  <div class="card-body">
				<div class="d-flex justify-content-between align-items-baseline">
				  <h6 class="card-title mb-0">Jumlah Siswa</h6>
				  <div class="dropdown mb-2">					
				  </div>
				</div>
				<div class="row">
				  <div class="col-6 col-md-12 col-xl-5">
					<h3 class="mb-2">{{$jml_siswa}}</h3>
				  </div>
				  <div class="col-6 col-md-12 col-xl-7">
					<div id="growthChart" class="mt-md-3 mt-xl-0"></div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div> <!-- row -->

	<div class="row">
	  <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
		<div class="card">
		  <div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline mb-2">
			  <h6 class="card-title mb-0">Monthly sales</h6>
			  <div class="dropdown mb-2">
				<button class="btn p-0" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
				  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
				  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
				  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
				  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
				  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
				</div>
			  </div>
			</div>
			<p class="text-muted">Sales are activities related to selling or the number of goods or services sold in a given time period.</p>
			<div id="monthlySalesChart"></div>
		  </div> 
		</div>
	  </div>
	  <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
		<div class="card">
		  <div class="card-body">
			<div class="d-flex justify-content-between align-items-baseline">
			  <h6 class="card-title mb-0">Cloud storage</h6>
			  <div class="dropdown mb-2">
				<button class="btn p-0" type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
				  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
				  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
				  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
				  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
				  <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
				</div>
			  </div>
			</div>
			<div id="storageChart"></div>
			<div class="row mb-3">
			  <div class="col-6 d-flex justify-content-end">
				<div>
				  <label class="d-flex align-items-center justify-content-end tx-10 text-uppercase fw-bolder">Total storage <span class="p-1 ms-1 rounded-circle bg-secondary"></span></label>
				  <h5 class="fw-bolder mb-0 text-end">8TB</h5>
				</div>
			  </div>
			  <div class="col-6">
				<div>
				  <label class="d-flex align-items-center tx-10 text-uppercase fw-bolder"><span class="p-1 me-1 rounded-circle bg-primary"></span> Used storage</label>
				  <h5 class="fw-bolder mb-0">~5TB</h5>
				</div>
			  </div>
			</div>
			<div class="d-grid">
			  <button class="btn btn-primary">Upgrade storage</button>
			</div>
		  </div>
		</div>
	  </div>
	</div> <!-- row -->
@endsection