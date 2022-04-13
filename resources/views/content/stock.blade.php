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
		<h3 class="card-title">Stock</h3>
		</div>
		  <div class="card-header">
			<button type="button" class="btn btn-info" onclick="add()" > + </button>
			&nbsp
			<button type="button" class="btn btn-info" onclick="doPrint()" > Print </button>
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
				  <th>Nama Barang</th>
				  <th>Jumlah</th>
				  <th>Kode</th>
				  <th>Harga</th>
				  <th>#</th>
				</tr>
			  </thead>
			  <tbody>
			  @foreach($stock as $value)
				<tr>
				  <td class="id">{{$value->id}}</td>
				  <td class="name">{{$value->name}}</td>
				  <td class="qty">{{$value->qty}}</td>
				  <td class="code">{{$value->code}}</td>
				  <td class="price">{{$value->price}}</td>
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
              <h4 class="modal-title">Stock</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form action="" method="post">
            <div class="modal-body">
              <div class="row">
				<div class="col-6">
					Nama Barang
				</div>
				<div class="col-6">
					<input type="text" name="name" class="form-control" />
				</div>
              </div>
			  <div class="row">
				<div class="col-6">
					Kuantity
				</div>
				<div class="col-6">
					<input type="number" name="qty" min="1" class="form-control" />
				</div>
              </div>
			  <div class="row">
				<div class="col-6">
					Kode
				</div>
				<div class="col-6">
					<input type="text" name="code" class="form-control" />
				</div>
              </div>
			  @if( $user['role'] == 0 )
			  <div class="row">
				<div class="col-6">
					Harga
				</div>
				<div class="col-6">
					<input type="number" name="price" class="form-control" />
				</div>
              </div>
			  @endif
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
	$(modalName+' form').attr('action', '/stock');
}

function edit(el){
	const parent = el.parentElement.parentElement
	
	$(modalName+' input[name="name"]').val( parent.querySelector(".name").innerHTML )
	$(modalName+' input[name="qty"]').val( parent.querySelector(".qty").innerHTML )
	$(modalName+' input[name="code"]').val( parent.querySelector(".code").innerHTML )
	$(modalName+' input[name="price"]').val( parent.querySelector(".price").innerHTML )
	
	$(modalName).modal('show')
	$(modalName+' form').attr('action', '/stock'+'Edit'+'/'+parent.querySelector(".id").innerHTML );
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
	$('.table').DataTable();
	if( document.querySelector(".notification").value === 'true' ){ toastr.success('Success') }
	
	if( document.querySelector(".notification").value === 'false' ){ toastr.error('Failed') }
});
</script>
