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
    <img class="animation__shake" src="{{ asset('dist/img/loader.gif')}}" alt="LCIMS Logo" height="60" width="60">
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
    
  </style>
  <style>
    #tbl_deceaseds_filter label {
    display: none;
  }
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
    @media screen {
        #printSection {
            display: none;
        }
    }

    @media print {
        .noPrint{
            display: none;
        }
        body * {
            visibility:hidden;
            -webkit-print-color-adjust: exact;
        }
        #tbl_deceasedinfo tbody tr{
            color: 'black';
        }
        #tbl_contactinfo tr{
            color: 'black';
            print-color-adjust: exact; 
        }
    }
  </style>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4>Burial Requests</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('managers.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Burial Requests</li>
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
                  <div class="col-md-6">
                        <button class = "btn btn-primary " id = "btn_reload" type = "button"><i class = "fa fa-sync"></i> &nbsp;&nbsp;Reload Table</button>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text" ><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class = "form-control is-primary" style ="text-transform: uppercase" placeholder = "Search Record Here" id = "search">
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
                        <th>Address (Barangay, City/Municipality)</th>
                        <th>Date of Burial</th>
                        <th>Sex</th>
                        <th>Action Buttons</th>
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

<script type = "text/javascript">
    $(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();

    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;    
    $('#dateofbirth').attr('max', maxDate);
    $('#dateof_death').attr('max', maxDate);
});
</script>
<script>
  $(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token':$("input[name=_token").val()
        }
    }) 
    $("#forapproval_notif").addClass('display', 'none');
    $("#s_deceasedforapproval").addClass('active')
    $("#search").addClass('active');

    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tbl_deceaseds tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    var _token = $('input[name="_token"]').val();
   
    function show_allData()
    {
        $.ajax({
            type: 'get',
            url: "{{ route('deceaseds.get_allData') }}",
            dataType: 'json',
            success:function(data)
            {
                var row = "";
                
                var total = 0;
                if(data.length > 0)
                {
                    for(var i = 0; i<data.length; i++)
                    {
                      if(data[i].approvalStatus == 0)
                      {
                        row += '<tr data-id = '+data[i].deceased_id+' style = "text-transform: uppercase">';
                        row += '<td>'+data[i].lastname+", "+data[i].middlename+", "+data[i].firstname+'</td>';
                        row += '<td>'+data[i].barangay+", "+data[i].city+", "+data[i].province+'</td>';
                        row += '<td align="center">'+formatDate(data[i].dateof_burial)+'</td>';
                        row += '<td align="center">'+data[i].sex+'</td>';
                        row += '<td align="center"><span class = "badge badge-danger right"> '+data[i].service_name+'</span></td>';
                        row += '<td align = "center">';
                        row += '<button data-id = '+data[i].deceased_id+' id = "btn_approve" type="button" class="btn btn-primary btn-sm btn-flat">';
                        row += '<i class = "fa fas fa-approve"></i>&nbsp;&nbsp;APPROVE';
                        row += '</button>';
                        row += "</td>";
                        row += '</tr>';
                        total += 1;
                      }
                      if(data[i].approvalStatus == 1)
                      {
                        row += '<tr data-id = '+data[i].deceased_id+' style = "text-transform: uppercase">';
                        row += '<td>'+data[i].lastname+", "+data[i].middlename+", "+data[i].firstname+'</td>';
                        row += '<td>'+data[i].barangay+", "+data[i].city+", "+data[i].province+'</td>';
                        row += '<td align="center">'+formatDate(data[i].dateof_burial)+'</td>';
                        row += '<td align="center">'+data[i].sex+'</td>';
                        row += '<td align="center"><span class = "badge badge-danger right"> '+data[i].service_name+'</span></td>';
                        row += '<td align = "center">';
                        row += '<button data-id = '+data[i].deceased_id+' id = "btn_disapprove" type="button" class="btn btn-danger btn-sm btn-flat">';
                        row += '<i class = "fa fas fa-approve"></i>&nbsp;&nbsp;DISAPPROVE';
                        row += '</button>';
                        row += "</td>";
                        row += '</tr>';
                      }
                    }
                }
                else
                {
                    row += '<tr style = "text-transform: uppercase"><td colspan = "6">No data available</td></tr>';
                }
                $("#no_ofrecords").text(total + " Records");
                $("#tbl_deceaseds tbody").html(row);
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
    function show_datatable()
    {
        $('#tbl_deceaseds').DataTable({
            ajax: {
                type: 'get',
                url: '{{route("deceaseds.data_forApproval")}}',
                dataType: 'json',
            },
            serverSide: true,
            processing: true,
            columns: [
                {data: "fullname", name: "fullname"},
                {data: "address", name: "address"},
                {data: 'dateofburial', name: 'dateofburial'},
                {data: 'sex', name: 'sex'},
                {data: 'action', name: 'action'}
            ],
            order: [[2, "desc"]],
            columnDefs: [{
                  className: "text-center", // Add 'text-center' class to the targeted column
                  targets: [2, 3, 4] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
              },
              {
                  "targets": 2, // Replace with the index of the column you want to format
                  "render": function(data, type, row, meta) {
                      var dateStr = data;
                      var dateObj = new Date(dateStr);
                      
                      var options = { year: 'numeric', month: 'long', day: 'numeric' };
                      var formattedDate = dateObj.toLocaleDateString('en-US', options);
                      return formattedDate;
                  }
              }],
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
        RefreshTable('#tbl_deceaseds', '{{route("deceaseds.data_forApproval")}}');
    }
    $("#btn_reload").on('click', function(){
      AutoReload();
    })
    show_datatable();
   
    $("#tbl_deceaseds tbody").on('click', '#btn_approve', function(){
    var id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure you want to approve this deceased?',
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
            $.ajax({
                type: 'get',
                url: '/deceased/approve/' + id,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 1) {
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Responses',
                            autohide: true,
                            delay: 3000,
                            body: response.message,
                        });
                        deceased_forApprovalNotification();
                        AutoReload();
                    } else {
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Responses',
                            autohide: true,
                            delay: 3000,
                            body: response.message,
                        });
                    }
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info');
        }
    })

    })
    $("#tbl_deceaseds tbody").on('click', '#btn_disapprove', function(){
    var id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure you want to disapprove this deceased?',
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
            $.ajax({
                type: 'get',
                url: '/deceased/disapprove/' + id,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 1) {
                        $(document).Toasts('create', {
                            class: 'bg-success',
                            title: 'Responses',
                            autohide: true,
                            delay: 3000,
                            body: response.message,
                        });
                        deceased_forApprovalNotification();
                        AutoReload();
                    } else {
                        $(document).Toasts('create', {
                            class: 'bg-danger',
                            title: 'Responses',
                            autohide: true,
                            delay: 3000,
                            body: response.message,
                        });
                    }
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
  })
</script>

</body>
</html>
