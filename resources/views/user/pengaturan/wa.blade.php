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
    
  <hr>
  </div>

    <div class="text-end">
        <button type="button" class="btn btn-danger btn-sm" id="btn-delete"><i data-feather="trash-2"></i> delete selected</button>
    </div>
    <br>
<div class="table-responsive">
<table id="dataTable" class="table">
  <thead>
    <tr>
        <th><input type="checkbox" id="select-checkbox" name="payment-checkbox" class="multi-checkbox"/><label for="select-checkbox"></label></th>
      <th width="50px">No</th>
      <th>Target</th>
      <th>Message</th>
        <th>Status</th>
        <th>State</th>
      <th>stateid</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($report as $r)
    <tr>
        <td><input type="checkbox" id="select-checkbox" name="payment-checkbox" class="multi-checkbox" value="{{\App\Helpers\Helper::encryptUrl($r->id)}}"/><label for="select-checkbox"></label></td>
      <td>{{$loop->iteration}}</td>
      <td>{{$r['target']}}</td>
      <td class="text-wrap" style="width: 30rem">{{$r['message']}}</td>
        <td>{{$r['status']}}</td>
        <td>{{$r['state']}}</td>
      <td>{{$r['stateid']}}</td>
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
    let checked = false;

    $('#select-checkbox').click(function (){
        checked = !checked;
            $('input:checkbox').prop('checked', checked);
    })

    $('#btn-delete').click(function () {
        var inputChecked = $('#select-checkbox:checked').find();
        var data_id = [];
        for(let i = 0; i < inputChecked.prevObject.length; i++){
            // console.log(inputChecked.prevObject[i].value)
            data_id[i] = inputChecked.prevObject[i].value;
        }
        console.log(data_id)
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
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: `{{route('delete_message')}}`,
                        data: {id: data_id},
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res){
                            console.log(res)
                            if (res == 200){
                                window.location.href = `{{route('wa')}}`
                            }
                        }
                    })
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
    })


</script>
@endsection
