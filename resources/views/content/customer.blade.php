<!-- /.row -->
	<input class="notification" type="hidden" value="<?php if(isset($notification))if($notification)echo $notification; ?>" />
	<div class="row">
	  <div class="col-12">
		<div class="card">
		<div class="card-header">
		<h3 class="card-title">Customer</h3>
		</div>
		  <div class="card-header">
			<!--
			<button type="button" class="btn btn-info" onclick="add()" > + </button>
			
			<div class="card-tools">
			  <div class="input-group input-group-md" style="width: 150px;">
				<input type="text" name="table_search" class="form-control float-right" placeholder="Search">

				<div class="input-group-append">
				  <button type="submit" class="btn btn-default">
					<i class="fas fa-search"></i>
				  </button>
				</div>
			  </div>
			</div>
			-->
		  </div>
		  <!-- /.card-header -->
		  <div class="card-body table-responsive p-0">
			<table class="table table-hover text-nowrap">
			  <thead>
				<tr>
				  <th>ID</th>
				  <th>Nama Customer</th>
				  <th>Alamat</th>
				  <th>Email</th>
				  <th>Telepon</th>
				  <th>Tipe Kendaraan</th>
				  <th>Plat Nomor</th>
				  <th>#</th>
				</tr>
			  </thead>
			  <tbody>
			  @foreach($customer as $value)
				<tr>
				  <td class="id">{{$value->id}}</td>
				  <td class="name">{{$value->name}}</td>
				  <td class="address">{{$value->address}}</td>
				  <td class="email">{{$value->email}}</td>
				  <td class="phone">{{$value->phone}}</td>
				  <td class="vehicle_type">{{$value->vehicle_type}}</td>
				  <td class="license_plate">{{$value->license_plate}}</td>
				  <td>
					<button type="button" class="btn btn-warning" onclick="edit(this)"> <i class="fa fa-edit"></i> </button>
					<button type="button" class="btn btn-danger" onclick="del(this)"> <i class="fa fa-trash"></i> </button>
				  </td>
				</tr>
			  @endforeach
			  </tbody>
			</table>
		  </div>
		  <!-- /.card-body -->
		</div>
		<!-- /.card -->
	  </div>
	</div>
	<!-- /.row -->
	
	<div class="modal fade" id="modal-add">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Customer</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form action="" method="post">
            <div class="modal-body">
              <div class="row">
				<div class="col-6">
					Nama Customer
				</div>
				<div class="col-6">
					<input type="text" name="name" class="form-control" />
				</div>
              </div>
			  <div class="row">
				<div class="col-6">
					Alamat
				</div>
				<div class="col-6">
					<input type="text" name="address" min="1" class="form-control" />
				</div>
              </div>
			  <div class="row">
				<div class="col-6">
					Email
				</div>
				<div class="col-6">
					<input type="text" name="email" class="form-control" />
				</div>
              </div>
        <div class="row">
				<div class="col-6">
					Telepon
				</div>
				<div class="col-6">
					<input type="text" name="phone" class="form-control" />
				</div>
              </div>
        <div class="row">
				<div class="col-6">
					Tipe Kendaraan
				</div>
				<div class="col-6">
					<input type="text" name="vehicle_type" class="form-control" />
				</div>
              </div>
        <div class="row">
				<div class="col-6">
					Plat Nomor
				</div>
				<div class="col-6">
					<input type="text" name="license_plate" class="form-control" />
				</div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
			</form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
	  
<script>
const modalName = '#modal-add'
/*
const Toast = Swal.mixin({
	  toast: true,
	  position: 'top-end',
	  showConfirmButton: false,
	  timer: 3000,
	  timerProgressBar: true,
	  didOpen: (toast) => {
		toast.addEventListener('mouseenter', Swal.stopTimer)
		toast.addEventListener('mouseleave', Swal.resumeTimer)
	  }
	})
Toast.fire({ icon: 'error', title: 'Failed' })
*/
function add(){
	$(modalName+' input').val('')
	$(modalName).modal('show')
	$(modalName+' form').attr('action', '/customer');
}

function edit(el){
	const parent = el.parentElement.parentElement
	
	$(modalName+' input[name="name"]').val( parent.querySelector(".name").innerHTML )
	$(modalName+' input[name="address"]').val( parent.querySelector(".address").innerHTML )
	$(modalName+' input[name="email"]').val( parent.querySelector(".email").innerHTML )
	$(modalName+' input[name="phone"]').val( parent.querySelector(".phone").innerHTML )
	$(modalName+' input[name="vehicle_type"]').val( parent.querySelector(".vehicle_type").innerHTML )
	$(modalName+' input[name="license_plate"]').val( parent.querySelector(".license_plate").innerHTML )
	
	$(modalName).modal('show')
	$(modalName+' form').attr('action', '/customer'+'Edit'+'/'+parent.querySelector(".id").innerHTML );
}

function del(el){
	if(confirm("Are you sure?")){
		const parent = el.parentElement.parentElement
		window.location.href = "/customer"+"Delete/"+parent.querySelector(".id").innerHTML;
	}
}

$( document ).ready(function() {
	$('.table').DataTable();
	if( document.querySelector(".notification").value === 'true' ){ toastr.success('Success') }
	
	if( document.querySelector(".notification").value === 'false' ){ toastr.error('Failed') }
});
</script>
