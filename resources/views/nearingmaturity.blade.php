<!DOCTYPE html>
<html lang="en">
<head>
  @include('references.links')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->
   <!-- Preloader -->
   <div id = "pageloader" class="preloader flex-column justify-content-center align-items-center" style = "display: none">
    <img class="animation__shake" src="{{ asset('dist/img/loader.gif')}}" alt="AdminLTELogo" height="60" width="60">
    <p>Please wait ... </p>
  </div>
   
  <!-- Navbar -->
  @include('layouts.header')
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

  <style>
    select,option,input{
        text-transform: uppercase;
    }
    .modal{
        background: url("/dist/img/cemetery.jpg") no-repeat center fixed;
        background-size: cover;
      
    }

    /* #tbl_deceaseds_filter label {
    display: none;
  } */
  </style>
  <style>
    input[type=text]:focus {
        border: 3px solid #17a2b8;
        color: black;
    }
    select:focus {
        border: 3px solid #17a2b8;
        color: black;
    }
    input[type=number]:focus {
        border: 3px solid #17a2b8;
    }
    input[type=text]{
        border-color: 3px solid #17a2b8;
    }
    input[type=date]{
        font-family: 'Segoe UI' 
    }

  </style>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4>Burial Records</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('managers.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Burial Records</li>
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
                    <div class="col-md-3">
                    <button class = "btn btn-primary"  id = "btn_reload" type = "button"><i class = "fa fa-sync"></i> &nbsp;&nbsp;Reload Table</button>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group" style ="display: none">
                            <div class="input-group-prepend">
                            <span class="input-group-text" ><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class = "form-control is-primary" style ="text-transform: uppercase" placeholder = "Search Record Here" id = "search">
                        </div>
                    </div>
                    <div class="col-md-5" style =  "text-align: center">
                        <div id="export_buttons">

                        </div>
                    </div>
                </div>
              </div>
              <style>
                table, td, th{
                    border: 1px solid #0A1931;
                }
              </style>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tbl_deceaseds"  class="table table-stripped table-hovered">
                  <thead style = "background-color: #0A1931; color: white">
                    <tr style = "text-align: center">
                        <th>Full Name (L,M,F)</th>
                        <th>Date of Burial</th>
                        <th>Block Assigned / Burried</th>
                        <th>Expiration</th>
                        <th>Status</th>
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


  <!-- Designation of deceased after validation -->
  <div class="modal"  id="assignment_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style = "background-color: #0A1931; color: white">
                <div class="col-md-5" style = "font-size: 23px; font-family: Algerian">
                    <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 100px; height: 100px" alt="">    
                    DECEASED ASSIGNMENT
                </div>
                <div class="col-md-6" style = "text-align: right">
                    Republic of the Philipines <br>
                    <b>MUNICIPAL ECONOMIC ENTERPRISE AND DEVELOPMENT OFFICE</b> <br>
                    LUGAIT CEMETERY ENTERPRISE <br>
                    9025 Lugait, Misamis Oriental <br>
                    Tel. No. (+63) 225-6170 <br>
                </div>
                <div class = "col-md-1">
                    <button type="button" style = "color: white" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style = "color: white">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                  {{ csrf_field() }}
                    <input type="text" style = "display: none" id = "coffin_id" value = "">
                    <div class="col-md-6" style = "background-color: #0A1931; color: white">
                        <h6>CHOOSE A SERVICE TO ASSIGN THE DECEASED NAMED BELOW: </h6>
                        <h5 id = "_deceasedName1" style = "text-transform: uppercase; color: green; font-weight: 1px solid bold"></h5>
                    </div>
                    <div class="col-md-6">
                        <h6></h6>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text" ><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class = "form-control is-primary" style ="text-transform: uppercase" placeholder = "Search Services Here.." id = "search_services">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class = "table table-stripped" id="tbl_services">
                        <thead style = "background-color: darkred; color: white; text-align: center; font-size: 20px">
                            <tr>
                                <th colspan = "2">Other Services</th>
                                <th>Click Here</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class = "fa fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
  </div>

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
  $(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token':$("input[name=_token").val()
        }
    }) 
    document.title = "LUGAIT CEMETERY INFORMATION MANAGEMENT SYSTEM (LCIMS)";
    show_datatable();
    //DUGAY KAAYO NI GIGANA ABTAN TAG PILA KA ORAS ANI HAHAHA
    function show_datatable()
    {
        $('#tbl_deceaseds').DataTable({
            ajax: {
                type: 'get',
                url: '{{ route("deceaseds.get_allMaturityByDatatable") }}',
                dataType: 'json',
            },
            serverSide: true,
            processing: true,
            columnDefs: [{
                className: "text-center", // Add 'text-center' class to the targeted column
                targets: [1, 2, 3, 4, 5] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
            }],
            dom: 'lBfrtip',
            buttons: [
                'length',
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4] // Set columns 0, 2, and 3 for export
                    },
                    className: 'btn btn-primary',
                },  
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4] // Set columns 0, 2, and 3 for export
                    },
                    className: 'btn btn-danger',
                },  
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4] // Set columns 0, 2, and 3 for export
                    },
                    className: 'btn btn-warning',
                },  
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4] // Set columns 0, 2, and 3 for export
                    },
                    className: 'btn btn-success',
                },  
            ],
            initComplete: function () {
                this.api().buttons().container().appendTo('#export_buttons');
            },
            columns: [
                {data: "fullname", name: "fullname"},
                {data: 'burialdate', name: 'burialdate'},
                {data: 'block', name: 'block'},
                {data: 'validity', name: 'validity'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'}
            ]
        });
    }

    function RefreshTable(tableId, urlData) {
        $.getJSON(urlData, null, function(json) {
            table = $(tableId).dataTable();
            oSettings = table.fnSettings();

            table.fnClearTable(this);

            for (var i = 0; i < json.aaData.length; i++) {
                table.oApi._fnAddData(oSettings, json.aaData[i]);
            }

            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            table.fnDraw();
        });
    }
    function AutoReload() 
    {
        RefreshTable('#tbl_deceaseds', '{{ route("deceaseds.get_allMaturityByDatatable") }}');
    }
    $("#btn_reload").on('click', function(){
        AutoReload();
    })
    $("#s_nearingMaturity").addClass('active')
    $("#search").addClass('active');

    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbl_deceaseds tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $("#search_services").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbl_services tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    var _token = $('input[name="_token"]').val();
    function calculateCoffinYears(dateofburial, validity)
    {
        var dob = new Date(dateofburial);
        var val = new Date();
        var count = Math.floor((val-dob) / (365.25 * 24 * 60 * 60 * 1000));
        return count;
    }
    function show_allServices(deceased_id)
    {
        $.ajax({
            type: 'get',
            url: "/services/classified/"+deceased_id,
            dataType: 'json',
            success:function(data)
            {
                console.log(data)
                var row = "";
                for(var i = 0; i<data.length; i++)
                {
                    if(data[i].service_name != "BURIAL")
                    {
                        if(data[i].status == 1)
                        {
                            row += '<tr data-id = '+data[i].id+' style = "text-transform: uppercase">';
                            row += '<td style = "color: red; font-size: 23px" data-column_name  = "service_name" data-id = '+data[i].id+' colspan="2">'+data[i].service_name+'</td>';
                            row += '<td align = "center" style = "font-size: 23px">';
                            row += '<span class = "badge badge-success" >MAPPED OUT</span></td>';
                            row += '</tr>';
                        }
                        else
                        {
                            row += '<tr data-id = '+data[i].id+' style = "text-transform: uppercase">';
                            row += '<td style = "color: red; font-size: 23px" data-column_name  = "service_name" data-id = '+data[i].id+' colspan="2">'+data[i].service_name+'</td>';
                            row += '<td align = "center">';
                            row += '<button data-deceased_id = '+deceased_id+' data-id = '+data[i].id+' id = "btn_designation" style = "font-size: 23px" type="button" class="btn btn-primary btn-sm btn-flat">';
                            row += '<i class = "fas fa-check-circle"></i>&nbsp; CHOOSE';
                            row += '</button></td>';
                            row += '</tr>';
                        }
                    }
                }
               
                $("#tbl_services tbody").html(row);
            },
            error: function() {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'System cannot process request.',
    });
}

        })
    }
    $("#tbl_services tbody").on('click', "#btn_designation", function(e){
    var deceased_id = $(this).data('deceased_id');
    var service_id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure you want to proceed with this service?',
        text: 'This action cannot be undone!',
        icon: "info",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {    
            actions: 'my-actions',
            cancelButton: 'order-1 right-gap',
            confirmButton: 'order-2',
            denyButton: 'order-3',
        },
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Please enter your password:',
                input: 'password',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                inputValidator: (value) => {
                    if (!value || value.length < 4) {
                        return 'Password must be at least 4 characters long!';
                    }
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel'
            }).then((passwordResult) => {
                if (passwordResult.isConfirmed) {
                    var password = passwordResult.value;
                    $.ajax({
                        type: 'put',
                        url: '/deceaseds/designation/' + deceased_id + '/' + service_id,
                        data: {
                            status: 'designation',
                            password: password,
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 1) {
                                nearingmaturity();
                                show_allServices(deceased_id);
                                AutoReload();
                                Swal.fire('Success', response.message, 'success');
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function(error) {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        }
                    });
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info');
        }
    })
})

    function formatDate(userdate)
    {
        var month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        var date    = new Date(userdate);
        return month[date.getMonth()] + " "+date.getDate() + ", "+date.getFullYear();
    }
    $("#tbl_deceaseds tbody").on('click', "#btn_assignment", function(e){
        var deceased_id = $(this).data('id');
        show_allServices(deceased_id);
        $.ajax({
            type: 'get',
            url: "/deceaseds/show/"+deceased_id,
            dataType: 'json',
            success:function(data)
            {
                var name = data[0][0].firstname+" "+data[0][0].middlename+ " "+data[0][0].lastname;
                $("#_deceasedName1").text(name);
            },
        });
        $("#assignment_modal").modal({
            'backdrop': 'static',
            'keyboard': false
        });
    })
  })
</script>
</body>
</html>
