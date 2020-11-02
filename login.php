<?php
  session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MEA Reliability</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>MEA</b> Reliability</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">เข้าสูระบบเพื่อแก้ไขเหตุการณ์ไฟฟ้าดับ</p>

      <form method="post"> <!-- action="login_db.php" -->
        <div class="input-group mb-3">
          <input type="text" name="eid" class="form-control" placeholder="รหัสพนักงาน" maxlength="7" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="txt_password" class="form-control" placeholder="รหัสผ่าน">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <a href="forgot-password.php">ลืมรหัสผ่าน</a>
            </div>
          
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="btn_login" class="btn btn-primary btn-block">เข้าสู่ระบบ</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- error message here -->

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $.validator.setDefaults({
      submitHandler: loginForm
    });
    $('form').validate({
      rules: {
        eid: {
          required: true,
          digits: true,
          minlength: 7,
          maxlength: 7
        },
        txt_password: {
          required: true,
        },
      },
      messages: {
        eid: {
          required: "กรุณากรอกรหัสพนักงาน",
          digits: "รหัสพนักงานตัวเลข 7 หลัก",
          minlength: "รหัสพนักงานตัวเลข 7 หลัก",
          maxlength: "รหัสพนักงานตัวเลข 7 หลัก"
        },
        txt_password: "กรุณากรอกรหัสผ่าน",
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.input-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });

  /* Handling login functionality */
	function loginForm() {
    var data = $("form").serialize();
		$.ajax({				
			type : 'POST',
			url  : 'login_db.php',
			data : data,
			// beforeSend: function(){ },
			success : function(response){			
				if($.trim(response) === "1"){
					// console.log('login success');
					location.href = "index.php";
				} else {									
          // console.error('login fail');
          let errorMsgElem = document.querySelector(".social-auth-links");
          if (!errorMsgElem) {
            let errorMsg = `<div class="social-auth-links mb-0">
                            <div class="alert alert-danger alert-dismissible mb-0">
                              <h6 class="mb-0"><i class="icon fas fa-ban"></i>`+$.trim(response)+`</h6>
                            </div>
                          </div>`;
            let formElem = document.querySelector("form");
            formElem.insertAdjacentHTML("afterend", errorMsg);
          } else {
            let errorTextMsgElem = document.querySelector(".social-auth-links").children[0].children[0];
            // console.log(errorTextMsgElem);
            errorTextMsgElem.innerHTML = '<i class="icon fas fa-ban"></i>'+$.trim(response);
          }          
				}
			}
		});
		return false;
	}
</script>
</body>
</html>
