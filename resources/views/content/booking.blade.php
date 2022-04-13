<!-- /.row -->
	<input class="notification" type="hidden" value="<?php if(isset($notification))if($notification)echo $notification; ?>" />
	<div class="row">
	  <div class="col-12">
		<div class="card">
		<div class="card-header">
		<h3 class="card-title">Booking</h3>
		</div>
		  <div class="card-header">
			@if(Auth::guard('customer')->user())
			<button type="button" class="btn btn-info" onclick="add()" > + </button>
			@endif
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
				  <th>Tanggal</th>
				  <th>Komplain</th>
				  <th>Tipe Servis</th>
				  <th>Status</th>
				  <th>#</th>
				</tr>
			  </thead>
			  <tbody>
			  @foreach($booking as $value)
				<tr>
				  <td class="id">{{$value->id}}</td>
				  <td class="booking_date">{{$value->booking_date}}</td>
				  <td class="complaint">{{$value->complaint}}</td>
				  <td class="service_type">{{ serviceType($value->service_type) }}</td>
				  <td class="status">{{ switchstatus($value->status) }}</td>
				  <td>
					@if(Auth::guard('customer')->user())
					<button type="button" class="btn btn-warning" onclick="edit(this)"> <i class="fa fa-edit"></i> </button>
					<button type="button" class="btn btn-danger" onclick="del(this)"> <i class="fa fa-trash"></i> </button>
					@endif
					@if(Auth::guard('web')->user() && $value->status == 1 )
						<button type="button" class="btn btn-success" onclick="accept(this)"> <i class="fa fa-check"></i> </button>
						<button type="button" class="btn btn-danger" onclick="reject(this)"> <i class="fa fa-times"></i> </button>
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
	
	<div class="modal fade" id="modal-add">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Booking</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form action="" method="post">
            <div class="modal-body">
				<div class="row">
				<div class="col-12">
					@foreach($mechanic as $key => $value2)
					<div style="position:relative; float:left; margin:5px">
					<figure class="item" >
						<img width="50px" height="auto" src="/mechanic.png" />
						<figcaption class="caption"><small> Pit Stop {{$key+1}} : 
						</figcaption>
						<figcaption class="caption">
							@if(isset ($todayBooking[$key])) Servis {{ serviceType( $todayBooking[$key]->service_type ) }} 
							@else
								Available
							@endif</small></figcaption>
					</figure>
					</div>
					@endforeach
					
				</div>
				<small> *Bengkel buka dari jam 09.00 - 17.00. </small>
					<?php
						$menit=0;
						$i=0;
						foreach($todayBooking as $value){
							if($i < count($mechanic)){
								if($value->service_type == 1){
									$tmp=15;
								}elseif($value->service_type == 2){
									$tmp=30;
								}elseif($value->service_type == 3){
									$tmp=90;
								}else{
									$tmp=0;
								}
								if($tmp < $menit || $menit == 0){
									$menit=$tmp;
								}
							}else{
								if($value->service_type == 1){
									$menit=$menit+15;
								}elseif($value->service_type == 2){
									$menit=$menit+30;
								}else{
									$menit=$menit+90;
								}
							}
							$i++;
						}
						if($i < count($mechanic)){
							$menit=0;
						}
					?>
				<small> &nbsp Terdapat {{count($todayBooking)}} antrian, Jumlah mekanik {{count($mechanic)}} orang </small>
				</div>
				<br>
              <div class="row">
				<div class="col-6">
					Tanggal
				</div>
				<div class="col-6">
					<input type="date" name="date" class="form-control" />
				</div>
              </div>
			  <!--
			  <div class="row">
				<div class="col-6">
					Jam
				</div>
				<div class="col-6">
					<input type="time" name="time" min="09:00" max="17:00" step="300" class="form-control" />
				</div>
              </div>
			  -->
			  <div class="row">
				<div class="col-6">
					Catatan
				</div>
				<div class="col-6">
					<input type="text" name="complaint" class="form-control" />
				</div>
              </div>

			  <div class="row">
				<div class="col-6">
					Tipe Servis
				</div>
				<div class="col-6">
					<select name="service_type" class="form-control" >
						<option value="1">Ringan : Rp10.000</option>
						<option value="2">Sedang : Rp25.000</option>
						<option value="3">Berat : Rp50.000</option>
					</select>
				</div>
              </div>
			  
			  <div class="row">
				<div class="col-6">
					
					
				</div>
				<div class="col-6">
					<small> 
					@if ($menit == 0 )
						Antrian anda akan langsung dikerjakan
					@else
						Estimasi anda harus menunggu ~<b>{{$menit}} menit</b> 
					@endif
					</small>
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
	  
	<div class="modal fade" id="modal-accept">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Terima Booking</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form action="/accept" method="post">
            <div class="modal-body">
			  <div class="row">
				<div class="col-6">
					Pilih Mekanik
				</div>
				<div class="col-6">
					<input type="hidden" name="id_booking" />
					@if(Auth::guard('web')->user())
					<select name="id_mechanic" class="form-control" >
						@foreach($mechanic as $value)
						<option value="{{$value->id}}">{{$value->name}}</option>
						@endforeach
					</select>
					@endif
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
	$(modalName+' form').attr('action', '/booking');
}

function edit(el){
	const parent = el.parentElement.parentElement
	date_time = parent.querySelector(".booking_date").innerHTML.split(" ")
	$(modalName+' input[name="date"]').val( date_time[0] )
	$(modalName+' input[name="time"]').val( date_time[1] )
	$(modalName+' input[name="complaint"]').val( parent.querySelector(".complaint").innerHTML )
	$(modalName+' input[name="service_type"]').val( parent.querySelector(".service_type").innerHTML )
	
	$(modalName).modal('show')
	$(modalName+' form').attr('action', '/booking'+'Edit'+'/'+parent.querySelector(".id").innerHTML );
}

function del(el){
	if(confirm("Anda yakin untuk menghapus?")){
		const parent = el.parentElement.parentElement
		window.location.href = "/booking"+"Delete/"+parent.querySelector(".id").innerHTML;
	}
}
function accept(el){
	const parent = el.parentElement.parentElement
	$('#modal-accept input[name="id_booking"]').val( parent.querySelector(".id").innerHTML )
	$("#modal-accept").modal('show')
	//window.location.href = "/chStatus/"+parent.querySelector(".id").innerHTML+"/2";
}
function reject(el){
	if(confirm("Are you sure?")){
		const parent = el.parentElement.parentElement
		window.location.href = "/reject/"+parent.querySelector(".id").innerHTML;
	}
}

$( document ).ready(function() {
	if( document.querySelector(".notification").value === 'true' ){ toastr.success('Success') }
	
	if( document.querySelector(".notification").value === 'false' ){ toastr.error('Failed') }
});
</script>
