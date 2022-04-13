<!-- /.row -->
<style>
@media print {
  @page {
    size: A4;
  }
}
</style>
	<input class="notification" type="hidden" value="<?php if(isset($notification))if($notification)echo $notification; ?>" />
	<div class="row">
	  <div class="col-12">
		<div class="card">
		<div class="card-header">
		<h3 class="card-title">Daftar Servis</h3>
		</div>
		  <div class="card-header">
			&nbsp
			<button type="button" class="btn btn-info" onclick="doPrint()" > Print </button>
			<!-- <button type="button" class="btn btn-info" onclick="add()" > + </button> -->
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
		  <div class="card-body table-responsive p-0">
			<table class="table table-hover text-nowrap">
			  <thead>
				<tr>
				  <th>ID</th>
				  <th>tanggal</th>
				  <th>ID Booking</th>
				  <th>ID Mekanik</th>
				  <th>IPlat Nomor</th>
				  <th>Keluhan</th>
				  <th>Jenis Servis</th>
				  <th>Status</th>
				  <th>Barang digunakan</th>
				  <th>Harga</th>
				  <th>#</th>
				</tr>
			  </thead>
			  <tbody>
			  @foreach($transaction as $value)
			  
				<tr>
				  <td class="id">{{$value->id}}</td>
				  <td class="booking_date">{{$value->booking_date}}</td>
				  <td class="id_booking">{{$value->id_booking}}</td>
				  <td class="id_mechanic">{{$value->id_mechanic	}}</td>	
				  <td class="license_plate">{{ isset($value->license_plate) ? $value->license_plate : ''}}</td>
				  <td class="complaint">{{$value->complaint}}</td>
				  <td class="service_type">{{serviceType($value->service_type)}}</td>
				  <td class="status">{{switchstatus($value->status)}} </td>
				  <td >
					<input type="hidden" class="service_type" value="{{$value->service_type}}" />
					  <ul class="stock_used"> 
						@foreach($value->stock_used as $value2)
						<li>{{$value2->name}}  {{$value2->used}}</li>
						@endforeach
						<?php 
						if(isset($value->service_price)){
						echo "<li>Biaya Servis</li>";
						}
					?>
					  </ul>
					
				  </td>
				  <td class="price">
				  <ul> 
				  <?php $subtotal=0; ?>
					@foreach($value->stock_used as $value2)
					<li><?php 
					$price = $value2->used * $value2->price;
					$subtotal = $subtotal + $price; 
					echo $price;
					?></li>
					@endforeach
					<?php 
					if(isset($value->service_price)){
					$subtotal = $subtotal + $value->service_price;
					echo "<li>"; echo $value->service_price; echo "</li>";
					}
					?>
				  </ul>
				  <hr />
				  Total : <p class="stock_used_price">{{$subtotal}}</p>
				  </td>
				  <td>
					@if($user["role"] == 1 )
						@if( $value->status == 1 )
						<button type="button" class="btn btn-warning" onclick="edit(this)"> <i class="fa fa-edit"></i> </button>
						@endif
					@endif
					@if($user["role"] == 0 )
						@if( $value->status == 3 )
						<button type="button" class="btn btn-success" onclick="finish(this)"> <i class="fa fa-check"></i> </button>
						@endif
					@endif
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
	
	<div class="modal fade" id="modal-add-stock">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Barang digunakan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form action="/insertStock" method="post">
             <div class="modal-body">
			 <input type="hidden" name="id" />
			   <div class="card-body table-responsive p-0">
				<table class="table table-hover text-nowrap">
				  <thead>
					<tr>
					  <th>Nama Barang</th>
					  <th>Stock</th>
					  <th>Jumlah</th>
					</tr>
				  </thead>
				  <tbody>
				  @foreach($stock as $value)
					<tr>
					  <td class="name">{{$value->name}}</td>
					  <td class="qty">{{$value->qty}}</td>
					  <td class="used"><input type="number" min='1' name="{{$value->id}}" /></td>
					</tr>
				  @endforeach
				  </tbody>
				</table>
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
	  
	<div class="modal fade" id="modal-finish">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Form Penyelesaian</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form action="/chStatus" method="post">
             <div class="modal-body">
			 <input type="hidden" name="id" />
			   <div class="card-body ">
				<div class="row">
					<div class="col-6">
						Subtotal Biaya
					</div>
					<div class="col-6">
						<input type="text" name="stock_used_price" class="form-control" value="" readonly />
					</div>
					<div class="col-6">
						Biaya servis
					</div>
					<div class="col-6">
						<input type="text" name="service_price" class="form-control" value="" />
					</div>
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
const modalName = '#modal-add-stock'
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
	const modalName = '#modal-add-stock'
	$(modalName+' input').val('')
	$(modalName).modal('show')
	$(modalName+' form').attr('action', '/stock');
}

function edit(el){
	
	const parent = el.parentElement.parentElement
	
	$(modalName+' input[name="id"]').val( parent.querySelector(".id").innerHTML )
	//$(modalName+' input[name="qty"]').val( parent.querySelector(".qty").innerHTML )
	//$(modalName+' input[name="code"]').val( parent.querySelector(".code").innerHTML )
	
	$(modalName).modal('show')
	//$(modalName+' form').attr('action', '/stock'+'Edit'+'/'+parent.querySelector(".id").innerHTML );
}

function finish(el){
	const modalName = '#modal-finish'
	$(modalName).modal('show')
	const parent = el.parentElement.parentElement
	$(modalName+' input[name="id"]').val( el.parentElement.parentElement.querySelector(".id").innerHTML )
	switch( parent.querySelector(".service_type").value ) {
	  case '1':
		$(modalName+' input[name="service_price"]').val({{servicePrice(1)}});
		break;
	  case '2':
		$(modalName+' input[name="service_price"]').val({{servicePrice(2)}});
		break;
	  default:
		$(modalName+' input[name="service_price"]').val({{servicePrice(3)}});
	}
	$(modalName+' input[name="stock_used_price"]').val( parent.querySelector(".stock_used_price").innerHTML );
}

function del(el){
	if(confirm("Are you sure?")){
		const parent = el.parentElement.parentElement
		window.location.href = "/stock"+"Delete/"+parent.querySelector(".id").innerHTML;
	}
}

function doPrint() {
  window.print();
}

$( document ).ready(function() {
	$('.js-example-basic-single').select2();
	$('.table').DataTable();
	if( document.querySelector(".notification").value === 'true' ){ toastr.success('Success') }
	if( document.querySelector(".notification").value === 'false' ){ toastr.error('Failed') }
});
</script>
