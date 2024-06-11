<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CEMETERY</title>

  @include('references/links')

</head>
<style>
  body{
  background: url("/dist/img/lugait-map.png") no-repeat center fixed;
  background-size: cover;
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
      <h5 class="login-box-msg">FORGOT PASSWORD?</h5>
      <p id = "processing" style = "text-align:center; color: Green; display: none">Please Wait ...</p>
      <form action="" id = "email_form" method="post">
        <input type="hidden" value="{{ csrf_token() }}">
        <div class="input-group mb-2">
          <input type="email" name = "email" id = "email" class="form-control" placeholder="Email" autocomplete = "off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></i></span>
            </div>
          </div>
        </div>
        <span id = "error" style = "color: red; text-align: center"></span>
        <div class="row">
          <div class="col-md-6">
            <button type = "submit"  class = "btn btn-success btn-block"><i class = "fas fa fa-paper-plane"></i>&nbsp; Submit</button>
          </div>
          <div class="col-md-6">
            <a href="{{ route('admin.login') }}"  class = "btn btn-danger btn-block"><i class = "fas fa fa-times"></i>&nbsp; Cancel</a>
          </div>
        </div>
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
    $("#email_form").on('submit', function(e){
      e.preventDefault();
      $("#processing").fadeIn(2000);
      $.ajax({
        type: 'post',
        url: '{{ route("users.submitEmail") }}',
        data: {
          email: $("#email").val(),
          "_token": "{{ csrf_token() }}",
        },
        dataType: 'json',
        success:  function(response)
        {
          if(response.status == 1)
          {
              $("#processing").fadeOut();
              $("#email").val("");
              $("#error").text("");
              Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: 'Please check your email to change your password.',
                  timer: 3000,
                  showConfirmButton: false
              });
          }
          if(response.status == 0)
          {
            $("#processing").fadeOut();
            $.each(response.messages, function(key, value) {
              if(key == 'email')
              {
                $("#email").addClass('is-invalid');
                $("#error").text(value);
              }
            })
          }
        },
        error: function(resp)
          { 
            $("#email").removeClass('is-invalid');
            $("#error").text("");
            $("#processing").fadeOut();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please check your connection and try again!',
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
