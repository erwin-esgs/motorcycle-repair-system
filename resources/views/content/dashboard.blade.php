<!-- /.row -->

	<div class="row">
	  <div class="col-12">
		<div class="card">
		<div class="card-header">
		<h3 class="card-title">Dashboard</h3>
		</div>
		  <div class="card-header">
		
			<!--
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
		  <div class="card-body">
			@if ( Auth::guard('web')->user() )
			 @if( Auth::guard('web')->user()->role == 0 )
			<div class="row">
			  <div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-info">
				  <div class="inner">
					<h3>{{count($booking)}}</h3>

					<p>Booking Baru</p>
				  </div>
				  <div class="icon">
					<i class="ion ion-bag"></i>
				  </div>
				  <a href="/allBooking" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			  </div>
			  <!-- ./col -->
			  <div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-success">
				  <div class="inner">
					<h3>{{count($transaction)}}</h3>
					<p>Servis</p>
				  </div>
				  <div class="icon">
					<i class="ion ion-stats-bars"></i>
				  </div>
				  <a href="/transaction" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			  </div>
			  <!-- ./col -->
			  <div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-warning">
				  <div class="inner">
					<h3>{{count($customer)}}</h3>

					<p>Pelanggan</p>
				  </div>
				  <div class="icon">
					<i class="ion ion-person-add"></i>
				  </div>
				  <a href="/customer" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			  </div>
			  <!-- ./col -->
			  <div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-danger">
				  <div class="inner">
					<h3>{{count($stock)}}</h3>

					<p>Barang</p>
				  </div>
				  <div class="icon">
					<i class="ion ion-pie-graph"></i>
				  </div>
				  <a href="/stock" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			  </div>
			  <!-- ./col -->
			</div>
			 @else
			<div class="row">
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-success">
				  <div class="inner">
					<h3>{{count($transaction)}}</h3>
					<p>Servis</p>
				  </div>
				  <div class="icon">
					<i class="ion ion-stats-bars"></i>
				  </div>
				  <a href="/transaction" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			  </div>
			  <!-- ./col -->
			<div class="col-lg-3 col-6">
				<!-- small box -->
				<div class="small-box bg-danger">
				  <div class="inner">
					<h3>{{count($stock)}}</h3>

					<p>Barang</p>
				  </div>
				  <div class="icon">
					<i class="ion ion-pie-graph"></i>
				  </div>
				  <a href="/stock" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			  </div>
			  <!-- ./col -->
			</div>
			 @endif
			@endif
			
			@if ( Auth::guard('customer')->user() )
			<div class="row">
			  <div class="col-6">
				<!-- small box -->
				<div class="small-box bg-info">
				  <div class="inner">
					<h3>{{count($booking)}}</h3>

					<p>Booking Baru</p>
				  </div>
				  <div class="icon">
					<i class="ion ion-bag"></i>
				  </div>
				  <a href="/booking" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			  </div>
			  <!-- ./col -->
			  <div class="col-6">
				<!-- small box -->
				<div class="small-box bg-success">
				  <div class="inner">
					<h3>{{count($transaction)}}</h3>
					<p>Servis</p>
				  </div>
				  <div class="icon">
					<i class="ion ion-stats-bars"></i>
				  </div>
				  <a href="/transactionCustomer" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			  </div>
			  <!-- ./col -->
			</div>
			@endif
          </div>
		  <!-- /.card-body -->
		</div>
		<!-- /.card -->
	  </div>
	</div>
	<!-- /.row -->

	  
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
