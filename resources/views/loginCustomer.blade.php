<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sinar Mutiara Motor | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
		<img src="/Sinar.png" />
      <h4>Sinar mutiara motor</h4>
    </div>
	<input class="notification" type="hidden" value="<?php if(isset($notification))if($notification)echo $notification; ?>" />
	<?php
		if( isset($email) ){
			if($exist){
				$action='/verification';
				$button="Login";
			}else{
				$action='/register';
				$button="Register";
			}
			$disabled = 'readonly';
			$method = 'post';
		}else{
			$action='/loginInput';
			$email = '';
			$disabled = '';
			$button="Login";
			$method = 'get';
		}
	?>
    <div class="card-body">
      <form action="{{$action}}" method="{{$method}}">
        <div class="input-group mb-3">
          <input type="text" name="email" class="form-control" value="{{$email}}" placeholder="Email / No Hp" required {{$disabled }}>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
		@if ( $email != '' )
			@if( !$exist )
			<small> Anda belum terdaftar, silahkan lengkapi data dibawah ini </small>
			<div class="input-group mb-3">
			  <input type="password" pattern="\w*" name="password" class="form-control" value="" placeholder="Password" >
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fa fa-edit"></span>
				</div>
			  </div>
			</div>
			<div class="input-group mb-3">
			  <input type="text" pattern="\w*" name="name" class="form-control" value="" placeholder="Nama Anda" >
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fa fa-edit"></span>
				</div>
			  </div>
			</div>
			<div class="input-group mb-3">
			  <input type="text"  name="address" class="form-control" value="" placeholder="Alamat" >
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fa fa-edit"></span>
				</div>
			  </div>
			</div>
			<div class="input-group mb-3">
			  <input type="text" pattern="\w*" name="phone" class="form-control" value="" placeholder="Telepon" >
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fa fa-edit"></span>
				</div>
			  </div>
			</div>
			<div class="input-group mb-3">
			  <input type="text" pattern="\w*" name="vehicle_type" class="form-control" value="" placeholder="Tipe Kendaraan" >
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fa fa-edit"></span>
				</div>
			  </div>
			</div>
			<div class="input-group mb-3">
			  <input type="text" pattern="\w*" style="text-transform:uppercase" name="license_plate" class="form-control" value="" placeholder="Plat Nomor" >
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fa fa-edit"></span>
				</div>
			  </div>
			</div>
			<small> Masukkan OTP yang telah dikirim ke email diatas </small>
			<div class="input-group mb-3">
			  <input type="text" pattern="\d*" maxlength="6" name="otp" class="form-control" value="" placeholder="OTP" >
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fa fa-edit"></span>
				</div>
			  </div>
			</div>
			@else
			<div class="input-group mb-3">
			  <input type="password"  name="password" class="form-control"  placeholder="password" >
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fa fa-edit"></span>
				</div>
			  </div>
			</div>
			<div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" name="remember" id="remember" checked>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
			@endif
		@endif
		<div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">{{$button}}</button>
          </div>
          <!-- /.col -->
        </div>
		
      </form>
	  <a href="#" onclick="forgotpass()"> Forgot pass?</a>
	  <br />
	  <hr />
	  <a href="/admin"> Anda admin / mekanik?</a>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<script>
function forgotpass(){
	if( $('input[name="email"]').val().includes("@") ){
		window.location.href = "/forgotpass?email="+ $('input[name="email"]').val() ;
	}else{
		alert("Harap masukkan email pada kolom input dan klik 'Forgot pass'")
	}
}
$( document ).ready(function() {
	if( document.querySelector(".notification").value === 'true' ){ toastr.success('Success') }
	
	if( document.querySelector(".notification").value === 'false' ){ toastr.error('Failed') }
});
</script>
</body>
</html>
