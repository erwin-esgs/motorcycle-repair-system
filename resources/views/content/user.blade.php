<!-- /.row -->
	<input class="notification" type="hidden" value="<?php if(isset($notification))if($notification)echo $notification; ?>" />
	<div class="row">
	  <div class="col-12">
		<div class="card">
		<div class="card-header">
		<h3 class="card-title">User</h3>
		</div>
		  <div class="card-header">
		
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
		  </div>
		  <!-- /.card-header -->
		  <div class="card-body table-responsive p-0">
			<table class="table table-hover text-nowrap">
			  <thead>
				<tr>
				  <th>ID</th>
				  <th>Nama User</th>
				  <th>Email</th>
				  <th>Role</th>
				  <th>Updated At</th>
				  <th>#</th>
				</tr>
			  </thead>
			  <tbody>
			  @foreach($users as $value)
				<tr>
				  <td class="id">{{$value->id}}</td>
				  <td class="name">{{$value->name}}</td>
				  <td class="email">{{$value->email}}</td>
				  <td class="role">{{$value->role}}</td>
				  <td class="updated_at">{{$value->updated_at}}</td>
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
              <h4 class="modal-title">User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
			<form action="" method="post">
            <div class="modal-body">
              <div class="row">
				<div class="col-6">
					Nama User
				</div>
				<div class="col-6">
					<input type="text" name="name" class="form-control" />
				</div>
              </div>
			  <div class="row">
				<div class="col-6">
					Email
				</div>
				<div class="col-6">
					<input type="text" name="email" min="1" class="form-control" />
				</div>
              </div>
			  <div class="row">
				<div class="col-6">
					Password
				</div>
				<div class="col-6">
					<input type="password" name="password" class="form-control" />
				</div>
              </div>
              <div class="row">
				<div class="col-6">
					Role
				</div>
				<div class="col-6">
					<input type="number" name="role" class="form-control" />
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
	$(modalName+' input').attr("placeholder", "");
	$(modalName).modal('show')
	$(modalName+' form').attr('action', '/user');
}

function edit(el){
	const parent = el.parentElement.parentElement
	
	$(modalName+' input[name="name"]').val( parent.querySelector(".name").innerHTML )
	$(modalName+' input[name="email"]').val( parent.querySelector(".email").innerHTML )
	$(modalName+' input[name="password"]').attr("placeholder", "Kosong = Tidak berubah");
	$(modalName+' input[name="role"]').val( parent.querySelector(".role").innerHTML )
	
	$(modalName).modal('show')
	$(modalName+' form').attr('action', '/user'+'Edit'+'/'+parent.querySelector(".id").innerHTML );
}

function del(el){
	if(confirm("Are you sure?")){
		const parent = el.parentElement.parentElement
		window.location.href = "/user"+"Delete/"+parent.querySelector(".id").innerHTML;
	}
}

$( document ).ready(function() {
	if( document.querySelector(".notification").value === 'true' ){ toastr.success('Success') }
	
	if( document.querySelector(".notification").value === 'false' ){ toastr.error('Failed') }
});
</script>
