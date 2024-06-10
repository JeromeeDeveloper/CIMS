<!DOCTYPE html>
<html lang="en">
<head>
  @include('references.links')
  
</head>
<style>
     #tbl_services_filter label {
    display: none;
  }
</style>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  @include('layouts.header')
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4>Services</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Services</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="form-group row">
                    {{ csrf_field() }}
                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-universal-access"></i></span>
                            </div>
                            <input type="hidden" value = "" id = "service_id" name = "id">
                            <input type="text" placeholder = "Encode Service Here" style ="text-transform: uppercase" name = "service_name" class = "form-control " id = "service_name">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button class = "btn btn-success btn-block btn-flat" type = "button" id = "btn_add" ><i class = "fa fa-plus-square"></i>&nbsp; Submit Service</button>
                     
                    </div>
                    <div class="col-sm-3">
                    <button id = "btn_reload" class = "btn btn-primary btn-block btn-flat" ><i class = "fas fa fa-sync"></i> &nbsp;&nbsp; Reload Table</button>
                    </div>
                    <div class="col-sm-3">
                        <!-- <label for="">Search</label> -->
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text" ><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class = "form-control" style ="text-transform: uppercase" placeholder = "Search Here" id = "search">
                        </div>
                    </div>
                </div>
              </div>
             
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbl_services" class="table  table-stripped table-bordered table-hovered">
        
                <thead style = "background-color: #0A1931; color: white">
                  <tr>
                    <th>Service Name</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody >
                 
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
@include('references.scripts')
<script>
  $(function () {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
  });
</script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token':$("input[name=_token").val()
            }
        })
     
        //DUGAY KAAYO NI GIGANA ABTAN TAG PILA KA ORAS ANI HAHAHA
        function show_datatable()
         {
            $('#tbl_services').DataTable({
                ajax: {
                    type: 'get',
                    url: '{{ route("services.all_dataByDatatable") }}',
                    dataType: 'json',
                },
                serverSide: true,
                processing: true,
                columnDefs: [{
                    className: "text-center", // Add 'text-center' class to the targeted column
                    targets: [1] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                }],
                columns: [
                    {data: 'service_name', name: 'service_name'},
                    {data: 'action', name: 'action'},
                ]
            });
         }
    
        function RefreshTable(tableId, urlData) {
            $.getJSON(urlData, null, function(json) {
                table = $(tableId).dataTable();
                oSettings = table.fnSettings();

                table.fnClearTable(this);

                for (var i = 0; i < json.data.length; i++) {
                    table.oApi._fnAddData(oSettings, json.data[i]);
                }

                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                table.fnDraw();
            });
        }
        function AutoReload() 
        {
            RefreshTable('#tbl_services', '{{ route("services.all_dataByDatatable") }}');
        }
        show_datatable();
        $("#btn_reload").on('click', function(){
          AutoReload();
        })
        var _token = $('input[name="_token"]').val();
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tbl_services tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $("#s_services").addClass('active');
       
        $("#btn_add").on('click', function(){
            var service_name = $("#service_name").val();
            var id = $("#service_id").val();
            if(id != "")
            {
                if(service_name != "")
                {
                    $.ajax({
                        type: 'put',
                        url: "{{ route('services.update', 'id') }}",
                        data: {
                            service_name: service_name,
                            service_id: id,
                        },
                        dataType: 'json',
                        success: function(response)
                        {
                            if(response.status == 1)
                            {
                                $("#service_name").removeClass('is-invalid');
                                $("#service_name").val("");
                                AutoReload();
                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Responses',
                                    autohide: true,
                                    delay: 3000,
                                    body: response.message,
                                })
                            }
                            else if(response.status == 2)
                            {
                                $("#service_name").addClass('is-invalid');
                                $.each(response.message, function(key,value) {
                                    $(document).Toasts('create', {
                                        class: 'bg-danger',
                                        title: 'Responses',
                                        autohide: true,
                                        delay: 3000,
                                        body: value,
                                    })
                                }); 
                            }
                            else
                            {
                                $(document).Toasts('create', {
                                    class: 'bg-danger',
                                    title: 'Responses',
                                    autohide: true,
                                    delay: 3000,
                                    body: response.message,
                                })
                            }
                        },
                        error: function(error)
                        {
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Responses',
                                autohide: true,
                                delay: 3000,
                                body: "Cannot process the request.",
                            })
                        }
                    })
                }
                else
                {
                    $("#service_name").addClass('is-invalid')
                }
            }
            else
            {
                if(service_name != "")
                {
                    $.ajax({
                        type: 'post',
                        url: "{{ route('services.store') }}",
                        data: {
                            service_name: service_name,
                        },
                        dataType: 'json',
                        success: function(response)
                        {
                            if(response.status == 1)
                            {
                                $("#service_name").removeClass('is-invalid');
                                $("#service_name").val("");
                                $("#service_id").val("");
                                AutoReload();
                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Responses',
                                    autohide: true,
                                    delay: 3000,
                                    body: response.message,
                                })
                            }
                            else if(response.status == 2)
                            {
                                $("#service_name").addClass('is-invalid');
                                $.each(response.message, function(key,value) {
                                    $(document).Toasts('create', {
                                        class: 'bg-danger',
                                        title: 'Responses',
                                        autohide: true,
                                        delay: 3000,
                                        body: value,
                                    })
                                }); 
                            }
                            else
                            {
                                $(document).Toasts('create', {
                                    class: 'bg-danger',
                                    title: 'Responses',
                                    autohide: true,
                                    delay: 3000,
                                    body: response.message,
                                })
                            }
                        },
                        error: function(error)
                        {
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Responses',
                                autohide: true,
                                delay: 3000,
                                body: "Cannot process the request.",
                            })
                        }
                    })
                }
                else
                {
                    $("#service_name").addClass('is-invalid')
                }
            }
        })
        $("#tbl_services tbody").on('click', '#btn_edit', function(){
            var id = $(this).data('id');
            $.ajax({
                type: 'get',
                url: '/services/show/'+id,
                dataType: 'json',
                success: function(data)
                {
                    $("#service_id").val(data.id);
                    $("#service_name").val(data.service_name.toUpperCase());
                },
                error: function(error)
                {
                    $(document).Toasts('create', {
                        class: 'bg-danger',
                        title: 'Responses',
                        autohide: true,
                        delay: 3000,
                        body: "Cannot process the request.",
                    })
                }
            })
        })
        $("#tbl_services tbody").on('click', '#btn_remove', function(){
            var id = $(this).data('id');
            if(confirm("Are you sure you want to delete this record? \nCannot be undone."))
            {
                $.ajax({
                    type: 'get',
                    url: '/services/delete/'+id,
                    dataType: 'json',
                    success: function(data)
                    {
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Responses',
                            autohide: true,
                            delay: 3000,
                            body: data.message,
                        })
                        $("#service_id").val("");
                        AutoReload();
                    },
                    error: function(error)
                    {
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Responses',
                            autohide: true,
                            delay: 3000,
                            body: "Cannot process the request.",
                        })
                    }
                })
            }
        })
    })
</script>
</body>
</html>
