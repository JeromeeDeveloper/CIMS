<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CEMETERY</title>

  @include('references/links')

</head>
<style>
  body {
      background: url("/dist/img/lugait-map.png") no-repeat center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
  }

  .login-box {
      background: rgba(255, 255, 255, 0.8);
      margin-top: 50px;
      padding: 30px;
      border-radius: 10px;
      max-width: 500px;
      margin: 0 auto;
  }

  .login-logo {
      text-align: center;
      margin-bottom: 20px;
  }

  .login-logo img {
      max-width: 120px;
      max-height: 120px;
  }

  .login-box-msg {
      text-align: center;
  }

  .form-control {
      border: 1px solid #ccc;
      border-radius: 5px;
  }

  .input-group-text {
      border: 1px solid #ccc;
      border-radius: 5px;
  }

  .btn-success {
      background-color: #28a745;
      color: #fff;
      border: none;
      border-radius: 5px;
  }
</style>
<body class="hold-transition login-page">
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="card animated flash infinite">
    <div class="card-body login-card-body">
      <div class="login-logo" >
        <!-- <img src="{{ asset('/assets/img/logos/calvarylogo.png') }}" style = "width: 120px; height: 120px" alt=""> -->
        <img src="{{ asset('/assets/img/logos/Lugait.png') }}" style = " background-size: cover; " alt="">
      </div>
      <h5 class="login-box-msg">CREATE A NEW PASSWORD</h5>

      <form action="" id = "changePassword_form" method="post">
      <input type="hidden" id = "user_id" value = "{{ $id }}">
        <input type="hidden" value="{{ csrf_token() }}">
        <div class="input-group mb-3">
          <input type="password" name = "" id = "nw_password" class="form-control" placeholder="Enter new Password " autocomplete = "off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <span id = "sp_nwpassword" style = "color: red"></span>
        <div class="input-group mb-3">
          <input type="password" name = "" id = "conf_password" class="form-control" placeholder="Confirm Password " autocomplete = "off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <span id = "sp_confpassword" style = "color: red"></span>
        <button class = "btn btn-block btn-success"><i class = "fas fa-submit"></i>&nbsp;&nbsp; Submit</button>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- Include the Google Maps API library - required for embedding maps -->

<script type = "text/javascript">
  $(document).ready(function() {
    $("#email").removeClass('is-invalid');
    $("#error").text("");
    $("#changePassword_form").on('submit', function(e){
      e.preventDefault();
      $.ajax({
        type: 'post',
        data: {
          nw_password: $("#nw_password").val(),
          conf_password: $("#conf_password").val(),
          user_id: $("#user_id").val(),
          "_token": "{{ csrf_token() }}",
        },
        url: '{{ route("users.submitNewPassword") }}',
        dataType: 'json',
        success:  function(response)
        {
          if(response.status == 1)
          {
            $("#changePassword_form")[0].reset();
            alert("You have successfully change your password. Go back to login.");
            window.location.href = "{{ route('admin.login') }}";
          }
          else
          {
            $.each(response.messages, function(key, value) {
              if(key == 'nw_password')
              {
                $("#nw_password").addClass('is-invalid');
                $("#sp_nwpassword").text(value);
              }
              if(key == 'conf_password')
              {
                $("#conf_password").addClass('is-invalid');
                $("#sp_confpassword").text(value);
              }
            })
          }
        },
      })
    })
  })
</script>
</body>
</html>
