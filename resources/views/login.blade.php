<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CEMETERY</title>

  @include('references/links')

</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
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
          padding: 25px; 
          border-radius: 10px;
          max-width: 500px; 
          margin: 0 auto;
      }
  
      .login-logo {
          text-align: center;
          margin-bottom: 20px;
      }
  
      .login-logo img {
          max-width: 150px;
          max-height: 150px;
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
  
      .btn-primary {
          background-color: #007bff;
          color: #fff;
          border: none;
          border-radius: 5px;
      }
  
      .btn-success {
          background-color: #28a745;
          color: #fff;
          border: none;
          border-radius: 5px;
      }
      .input-group > input:focus + .input-group-append .fas {
  color: #007bff;
}

  </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
        <a href="{{ route('landing.page') }}" class="logo-link">
            <img src="{{ asset('/assets/img/logos/Lugait.png') }}" alt="" class="inline-class">
        </a>
        </div>

        <h5 class="login-box-msg">MEEDO USER LOGIN</h5>

        <form action="" id="login_form" method="post">
            <input type="hidden" value="{{ csrf_token() }}">
            <div class="input-group mb-3">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" autocomplete="off">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope" style="font-size: 16px;"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock" style="font-size: 18.5px;"></span>
                    </div>
                </div>
            </div>
            @if(Session::has('NotFound'))
                <div class="input-group mb-3">
                    <span style="color: red; delay: 3000">{{ Session::get('NotFound')}} </span>
                </div>
            @endif
            @if(Session::has('passwordResetMsg'))
                <div class="input-group mb-3">
                    <span style="color: red; delay: 3000">{{ Session::get('passwordResetMsg')}} </span>
                </div>
            @endif
            <ul id="validation-errors" style="color: red"></ul>
            <div class="row">
                <div class="col-6">
                    <button type="submit" id="btn_signin" class="btn btn-primary btn-block">
                        <i class="fas fa fa-sign-in-alt"></i>&nbsp;&nbsp;&nbsp; Sign In
                    </button>
                </div>
                <div class="col-6">
                    <a href="/" class="btn btn-success btn-block">
                        <i class="fas fa fa-user"></i>&nbsp; Customer
                    </a>
                </div>
            </div>
            <br>
            <div class="row">
                <a href="{{ route('users.passwordReset') }}">Forgot Password?</a>
            </div>
        </form>
    </div>

    <div class="modal fade" id="customAlertModal" tabindex="-1" role="dialog" aria-labelledby="customAlertModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customAlertModalLabel">Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="notificationMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

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
       $("#login_form").on('submit', function(e){
         e.preventDefault();
         var email = $("#email").val();
         var password = $("#password").val();

         $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '{{ route("user.login") }}',
            data: {
                email: email,
                password: password,
                "_token": "{{ csrf_token() }}",
            },
            dataType: 'json',
            success: function(response)
            {
              if(response.status == 1)
              {
                        $('#notificationMessage').text(response.message);
                        $('#customAlertModal').modal('show');
                        setTimeout(function() {
                            window.location.href = "{{ route('managers.dashboard') }}";
                        }, 2000); // Redirect after 3 seconds (adjust time as needed)
                      }
              else if(response.status == 2)
              {
                $("#validation-errors").html("");
                $("input[type='text']").removeClass('is-invalid');
                $.each(response.message, function(key,value) {
                    if(key == "email")
                    {
                      $("input[name='email']").addClass('is-invalid');
                    }
                    if(key == "password")
                    {
                      $("input[name='password']").addClass('is-invalid');
                    }
                    $('#validation-errors').append("<li>"+value+"</li>");
                }); 
              }
              else{
                $("#validation-errors").html("");
                $("#validation-errors").html("<li>"+response.message+"</li>");
              }
            },
            error: function(resp) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }

         })
       })
    })
</script>
</body>
</html>
