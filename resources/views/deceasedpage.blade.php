<!DOCTYPE html>
<html lang="en">
<head>
  @include('references.links')
</head>
<link rel="icon" href="{{ asset('/assets/img/logos/Lugait.png') }}" type="image/png">

<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- <div class="preloader flex-column justify-content-center align-items-center" >
    <img class="animation__shake" src="{{ asset('dist/img/logolugait.png')}}" alt="AdminLTELogo" height="60" width="60">
    <p>Please wait ... </p>
  </div> -->
   <!-- Preloader -->
   <div id = "pageloader" class="preloader flex-column justify-content-center align-items-center" style = "display: none">
    <img class="animation__shake" src="{{ asset('dist/img/loader.gif')}}" alt="AdminLTELogo" height="60" width="60">
    <p>Please wait ... </p>
  </div>
    @if(Auth::user()->role == 1) 
    <input type="text" style = "display: none" value = "1" id = "user_role">
    @endif
    @if(Auth::user()->role == 2) 
    <input type="text" style = "display: none" value = "2" id = "user_role">
    @endif
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
        background: url("/dist/img/lugait-map.png") no-repeat center fixed;
        background-size: cover;
      
    }
      /* Target the options in the select dropdown */
      .form-control option {
        color: black !important; /* Change the color to ensure visibility */
    }
    
    /* Override any other styles that might be affecting the options */
    .form-control option:-moz-placeholder {
        color: black !important;
    }

    .form-control option::-moz-placeholder {
        color: black !important;
    }

    .form-control option:-ms-input-placeholder {
        color: black !important;
    }

    .form-control option::-webkit-input-placeholder {
        color: black !important;
    }
   
  </style>
  <style>
    input[type=text]:focus {
        border: 3px solid #17a2b8;
        color: black;
    }
    #province option,
#city option {
    color: black !important;
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
    /* #tbl_deceaseds_filter label {
    display: none;
  } */

  in


  </style>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4>Manage Deceaseds</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('managers.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Manage Deceaseds</li>
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
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <button class="btn btn-danger" id="btn_add"><i class="fa fa-skull"></i> &nbsp;&nbsp;Add New Deceased</button>
                    <button class="btn btn-primary" id="btn_reload" type="button"><i class="fa fa-sync"></i> &nbsp;&nbsp;Reload Table</button>
                  </div>
                  <div id="export_buttons">
                    <!-- Export buttons content here -->
                  </div>
                  <div class="input-group" style="display: none; ">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control is-primary" style="text-transform: uppercase" placeholder="Search Record Here" id="search">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <style>
            table, td, th {
              border: 2px solid #0A1931;
            }
          </style>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tbl_deceaseds" class="table table-stripped table-hovered">
              <thead style="background-color: #0A1931; color: white; text-align: center">
                <tr style="background-color: darkred;">
                  <th style="background-color: darkred; vertical-align: middle; text-align: center;">DEFINITION OF ACTION ICONS</th>
                  <th style="background-color: darkblue; vertical-align: middle; text-align: center;"><i class="fas fa-map-marked-alt"></i>&nbsp;&nbsp;Plotting of Deceased</th>
                  <th style="background-color: darkgreen; vertical-align: middle; text-align: center;"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit Deceased Details</th>
                  <th style="background-color: darkblue; vertical-align: middle; text-align: center;"><i class="fas fa-info"></i>&nbsp;&nbsp;Information of Deceased</th>
                  <th style="background-color: darkgreen; vertical-align: middle; text-align: center;" colspan="3"><i class="fas fa-print"></i>&nbsp;&nbsp;View Print Page</th>
                </tr>
                <tr>
                  <th>Full Name (L,M,F)</th>
                  <th>Address (Barangay, City/Municipality)</th>
                  <th>Date of Burial</th>
                  <th>Sex</th>
                  <th>Status</th>
                  <th>Last Action</th>
                  <th>Action Buttons</th>
                </tr>
              </thead>
              <tbody>
                <!-- Table body content -->
              </tbody>
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

  <!-- Coffin plot, block assignment of deceased -->
  <div class="modal"  id="assignment">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style = "background-color: #0A1931; color: white">
                <div class="col-md-5" style = "font-size: 23px; font-family: Segoe UI">
                    <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 100px; height: 100px" alt="">    
                    DECEASED BLOCK PLOTTING
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
                    <input type="text" style = "display: none" id = "coffin_id" value = "">
                    <div class="col-md-6" style = "background-color: #0A1931; color: white">
                        <h6>CHOOSE A BLOCK TO PLOT THE DECEASED NAMED BELOW: </h6>
                        <h5 id = "_deceasedName" style = "text-transform: uppercase; color: rgb(10, 209, 4); font-weight: 1px solid bold"></h5>
                    </div>
                    <div class="col-md-6">
                        <h6></h6>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text" ><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class = "form-control is-primary" style ="text-transform: uppercase" placeholder = "Search Block Here.." id = "search_block">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class = "table table-stripped" id="spaceareas">
                        <thead style = "background-color: #0A1931; color: white; text-align: center; font-size: 20px">
                            <tr>
                                <th>Image</th>
                                <th>Block Name</th>
                                <th>Assignment</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- Page Loading While Ajax Requesting ... -->
  <div class="modal"  id="ajax_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <center>
                        <h5>Please Wait ...</h5>
                        <h7>The server is waiting for connection to send email</h7>
                    </center>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- Designation of deceased after validation -->
  <div class="modal"  id="assignment_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style = "background-color: #0A1931; color: white">
                <div class="col-md-5" style = "font-size: 23px; font-family: Segoe UI">
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
                    <input type="text" style = "display: none" id = "coffin_id" value = "">
                    <div class="col-md-6" style = "background-color: #0A1931; color: white">
                        <h6>CHOOSE A SERVICE TO ASSIGN THE DECEASED NAMED BELOW: </h6>
                        <h5 id = "_deceasedName1" style = "text-transform: uppercase; color: rgb(0, 255, 128); font-weight: 1px solid bold"></h5>
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
                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- Deceased Information -->
  <div >
  <div class="modal fade"  id="deceased_info"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="printThis" >
        <div class="modal-content" >
            <div class="modal-header" style = "background-color: #0A1931; color: white">
                <div class="col-md-5" style = "font-size: 24px; font-family: Segoe UI">
                    <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 100px; height: 100px" alt="">    
                    DECEASED INFORMATION
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
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <table class = "table table-stripped table-hovered" id = "tbl_years">
                                
                            </table>
                            <br>
                            <div align="center">
                                <img src="" class = "img-fluid" style = "width: 300px; height: 300px; align: center" alt="" id="img_rip">
                            </div>
                            <br>
                            <table class = "table table-stripped table-hovered" id = "tbl_contactinfo">
                                
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class = "table table-stripped table-hovered" id = "tbl_deceasedinfo">
                                
                            </table>
                        </div>
                            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class = "fas fa fa-times"></i> Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  </div>
  

  <!-- Deceased CRUD FORM -->
  <div class="modal"  id="modal_form">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style = "background-color: #0A1931; color: white">
                <div class="col-md-5" style = "font-size: 26px; font-family: Segoe UI">
                    <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 100px; height: 100px" alt="">    
                    CEMETERY FORM
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
            <form action="" id = "cemetery_form" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="contactperson_id" id = "contactperson_id" value = "">
                <input type="hidden" name="contactperson_id1" id = "contactperson_id1" value = "">
                <input type="hidden" name="cemetery_id" id = "cemetery_id" value = "">
                <div class="modal-body">
                    <h5 style = "color: green;"><b>Deceased Information</b> </h5><p></p>
                    <div class="row" >
                        <div class="col-md-3" >
                            <label for="">Last Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" 
                                onkeydown="return /[a-zA-Z ]/i.test(event.key)" oninput="return $('#sp_lastname').html(''), $(this).removeClass('is-invalid')"
                                name="lastname" id="lastname" class="form-control form-control-border">
                            </div>
                            <span style = "color: red" class = "span" id = "sp_lastname"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Middle Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" 
                                onkeydown="return /[a-zA-Z ]/i.test(event.key)" oninput="return $('#sp_middlename').html(''), $(this).removeClass('is-invalid')"
                                name="middlename" id="middlename" class="form-control form-control-border">
                            </div>
                            <span style = "color: red" class = "span" id = "sp_middlename"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">First Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" autocomplete = "off" oninput="return $('#sp_firstname').html(''), $(this).removeClass('is-invalid')" onkeydown="return /[a-zA-Z ]/i.test(event.key)" name="firstname" id="firstname" class="form-control form-control-border">
                            </div>
                            <span style = "color: red" class = "span" id = "sp_firstname"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Suffix</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_suffix').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "suffix" name = "suffix" style="width: 100%;">
                                <option value="">-- Please select here</option>
                                <option value="N">NONE</option>
                                <option value="SR">SR</option>
                                <option value="JR">JR</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="VI">VI</option>
                                <option value="VII">VII</option>
                                <option value="VIII">VIII</option>
                                <option value="IX">IX</option>
                                <option value="X">X</option>
                            </select>
                            <span style = "color: red" class = "span" id = "sp_suffix"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Date of Birth</label>
                            <input type="date" name="dateofbirth" oninput="return $('#sp_dateofbirth').html(''), $(this).removeClass('is-invalid')" id="dateofbirth" class="form-control form-control-border">
                            <span style = "color: red" class = "span" id = "sp_dateofbirth"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Date of Burial</label>
                            <input type="date" name="dateof_burial" id="dateof_burial" oninput="return $('#sp_dateofburial').html(''), $(this).removeClass('is-invalid')" class="form-control form-control-border">
                            <span style = "color: red" class = "span" id = "sp_dateofburial"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Time</label>
                            <input type="time" name="burial_time" id="burial_time" oninput="return $('#sp_burialtime').html(''), $(this).removeClass('is-invalid')" class ="form-control form-control-border">
                            <span style = "color: red" class = "span" id = "sp_burialtime"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Sex</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary5" value = "M" id = "sex" name="sex">
                                    <label for="radioPrimary5">
                                        Male
                                    </label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="radioPrimary6" value = "F" id = "sex" name="sex">
                                    <label for="radioPrimary6">
                                        Female
                                    </label>
                                </div>
                            </div>
                            <span style = "color: red" class = "span" id = "sp_sex"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-4">
                            <label for=""><u>Cause of Death</u></label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_causeofdeath').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "causeofdeath" name = "causeofdeath" style="width: 100%;">
                                <option value="">-- Please select here</option>
                                <option value="N">NATURAL</option>
                                <option value="A">ACCIDENT</option>
                                <option value="H">HOMICIDE</option>
                                <option value="S">SUICIDE</option>
                                <option value="U">UNDETERMINED</option>
                                <option value="O">OTHER</option>
                            </select>
                            <span style = "color: red" class = "span" id = "sp_causeofdeath"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="">Date of Death</label>
                            <input type="date" name="dateof_death" oninput="return $('#sp_dateofdeath').html(''), $(this).removeClass('is-invalid')" id="dateof_death" class="form-control form-control-border">
                            <span style = "color: red" class = "span" id = "sp_dateofdeath"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="">Marital Status</label>
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary1" value = "S" id = "civilstatus" name="civilstatus">
                                    <label for="radioPrimary1">
                                        Single
                                    </label>
                                </div>
                                <div class="icheck-success d-inline">
                                    <input type="radio" id="radioPrimary2"  value = "M" id = "civilstatus" name="civilstatus">
                                    <label for="radioPrimary2">
                                        Married
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="radioPrimary3" value = "W" id = "civilstatus" name="civilstatus">
                                    <label for="radioPrimary3">
                                        Widowed
                                    </label>
                                </div>
                                <div class="icheck-danger d-inline">
                                    <input type="radio" id="radioPrimary4" value = "D" id = "civilstatus" name="civilstatus">
                                    <label for="radioPrimary4">
                                        Divorced
                                    </label>
                                </div>
                            </div>
                            <span style = "color: red" class = "span" id = "sp_civilstatus"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Region</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_region').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "region" name = "region" style="width: 100%;">
                                
                            </select>
                            <span style = "color: red" class = "span" id = "sp_region"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_province').html(''), $(this).removeClass('is-invalid')"data-dropdown-css-class="select2-primary" id = "province" name = "province" style="width: 100%; color: black;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_province"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">City / Municipality</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_city').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "city" name = "city" style="width: 100%; color: black;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_city"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_barangay').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "barangay" name = "barangay" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_barangay"></span>
                        </div>
                    </div>
                    <p></p>
                    <h5 style = "color: green"><b>Contact Person Information</b> </h5><p></p>
                    <div class="row">
                        <div class="col-md-3" >
                            <label for="">Contact Person</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input list = "contactpersons" type="text" autocomplete = "off" onkeydown="return /[a-zA-Z, ]/i.test(event.key)" oninput="return $('#sp_contactperson').html(''), $(this).removeClass('is-invalid')" name="contactperson" id="contactperson" class="form-control form-control-border">
                                <datalist id = "contactpersons"></datalist>
                            </div>
                            <span style = "color: red" class = "span" id = "sp_contactperson"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Relationship to the Deceased</label>
                            <select  class="form-control form-control-border select2-primary"  data-dropdown-css-class="select2-primary" onchange="return $('#sp_relationship').html(''), $(this).removeClass('is-invalid')" id = "relationship" name = "relationship" style="width: 100%;">
                                <option value="">-- Please select here</option>
                                <option value="1">SIBLING</option>
                                <option value="2">COUSIN</option>
                                <option value="3">PARENT</option>
                                <option value="4">CHILDREN</option>
                                <option value="5">SPOUSE</option>
                                <option value="6">OTHER</option>
                            </select>
                            <span style = "color: red" class = "span" id = "sp_relationship"></span>
                        </div>
                        <div class="col-md-3" >
                            <label for="">Contact Number (<i>Ex. 9303087678</i>)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i>&nbsp; +63</span>
                                </div>
                                <input type="tel" maxlength = "10" pattern = "^(9|\+639)\d{9}$" id = "contactnumber" oninput="return $('#sp_contactnumber').html(''), $(this).removeClass('is-invalid')" name = "contactnumber" class="form-control form-control-border" >
                            </div>
                            <span style = "color: red" class = "span" id = "sp_contactnumber"></span>
                        </div>
                        <div class="col-md-3" >
                            <label for="">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i>&nbsp;</span>
                                </div>
                                <input type="email" id = "email" oninput="return $('#sp_email').html(''), $(this).removeClass('is-invalid')" name = "email" class="form-control form-control-border" >
                            </div>
                            <span style = "color: red" class = "span" id = "sp_email"></span>
                        </div>
                    </div>  
                    <p></p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary22" value = "1" name = "sameaddress">
                                        <label for="checkboxPrimary22">Same as above address ?
                                    </label>
                                    <input type="hidden" id = "check_sameaddress" name = "check_sameaddress" value = "0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <p></p>
                    <div class="row" id= "contactperson_address">
                        <div class="col-md-3">
                            <label for="">Region</label>
                            <select class="form-control form-control-border select2-primary"  onchange="return $('#sp_region1').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "region1" name = "region1" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_region1"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_province1').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "province1" name = "province1" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_province1"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">City</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_city1').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "city1" name = "city1" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_city1"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary" onchange="return $('#sp_barangay1').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "barangay1" name = "barangay1" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span" id = "sp_barangay1"></span>
                        </div>
                    </div>
                    <p></p>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="checkboxPrimary25" value = "1" name = "add_contactperson">
                                        <label for="checkboxPrimary25" style = "color: #007bff; font-size: 15px">Check to add other contact person.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id = "other_contactperson" style = "display: none">
                        <h5 style = "color: green"><b>Other Contact Person </b> </h5><p></p>
                        <div class="row" >
                            <div class="col-md-3" >
                                <label for="">Contact Person</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" list="contactpersons1" autocomplete = "off" oninput="return $('#sp_contactperson1').html(''), $(this).removeClass('is-invalid')" onkeydown="return /[a-zA-Z ]/i.test(event.key)" name="contactperson1" id="contactperson1" class="form-control form-control-border">
                                    <datalist id = "contactpersons1"></datalist>
                                </div>
                                <span style = "color: red" class = "span" id = "sp_contactperson1"></span>
                            </div>
                            <div class="col-md-3">
                                <label for="">Relationship to the Deceased</label>
                                <select  class="form-control form-control-border select2-primary" onchange="return $('#sp_relationship1').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "relationship1" name = "relationship1" style="width: 100%;">
                                    <option value="">-- Please select here</option>
                                    <option value="1">SIBLING</option>
                                    <option value="2">COUSIN</option>
                                    <option value="3">PARENT</option>
                                    <option value="4">CHILDREN</option>
                                    <option value="5">SPOUSE</option>
                                    <option value="6">OTHER</option>
                                </select>
                                <span style = "color: red" class = "span" id = "sp_relationship1"></span>
                            </div>
                            <div class="col-md-3" >
                                <label for="">Contact Number (<i>Ex. 9303087678</i>)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i>&nbsp; +63</span>
                                    </div>
                                    <input type="tel" maxlength = "10" pattern = "^(9|\+639)\d{9}$" oninput="return $('#sp_contactnumber1').html(''), $(this).removeClass('is-invalid')" id = "contactnumber1" name = "contactnumber1" class="form-control form-control-border" >
                                </div>
                                <span style = "color: red" class = "span" id = "sp_contactnumber1"></span>
                            </div>
                            <div class="col-md-3" >
                                <label for="">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i>&nbsp;</span>
                                    </div>
                                    <input type="email"  id = "email1" name = "email1" class="form-control form-control-border" >
                                </div>
                                <span style = "color: red" class = "span" id = "sp_email1"></span>
                            </div>
                        </div>
                        <p></p>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="checkboxPrimary23" value = "1" name = "sameaddress1">
                                            <label for="checkboxPrimary23">Same as deceased address ?
                                        </label>
                                        <input type="hidden" id = "check_sameaddress1" name = "check_sameaddress1" value = "0">
                                    </div>
                                </div>
                            </div>
                            <p></p>
                            <div class="row" id= "contactperson_address1">
                                <div class="col-md-3">
                                    <label for="">Region</label>
                                    <select class="form-control form-control-border select2-primary" onchange="return $('#sp_region2').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "region2" name = "region2" style="width: 100%;">
                                    </select>
                                    <span style = "color: red" class = "span" id = "sp_region2"></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Province</label>
                                    <select class="form-control form-control-border select2-primary" onchange="return $('#sp_province2').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "province2" name = "province2" style="width: 100%;">
                                    </select>
                                    <span style = "color: red" class = "span" id = "sp_province2"></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">City</label>
                                    <select class="form-control form-control-border select2-primary" onchange="return $('#sp_city2').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "city2" name = "city2" style="width: 100%;">
                                    </select>
                                    <span style = "color: red" class = "span" id = "sp_city2"></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Barangay</label>
                                    <select class="form-control form-control-border select2-primary" onchange="return $('#sp_barangay2').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "barangay2" name = "barangay2" style="width: 100%;">
                                    </select>
                                    <span style = "color: red" class = "span" id = "sp_barangay2"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" id = "btn_save" class="btn btn-primary btn-block"><i class = "fas fa fa-save"></i> Save changes</button>
                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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
<!-- <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.2.js"></script> -->
<script>
$(document).ready(function() {
    // Add CSS to set the text color of select elements to black
    $('select').css('color', 'black');

    $.getJSON('/data/ph.json', function(data) {
        console.log('Data:', data); 

        var populateDropdown = function(element, items) {
            console.log('Items:', items); 
            element.empty().append($('<option>', {
                value: '',
                text: '--select--'
            }));
            items.forEach(function(item) {
                element.append($('<option>', {
                    value: item.code,
                    text: item.name
                }));
            });
        };

        var regions = $.map(data, function(region, key) {
            return { code: key, name: region.region_name };
        });
        console.log('Regions:', regions); 
        populateDropdown($('#region'), regions);

        // Populating dropdowns for region1
        populateDropdown($('#region1'), regions);

        // Populating dropdowns for region2
        populateDropdown($('#region2'), regions);

        $('#region').change(function() {
            var regionCode = $(this).val();
            console.log('Selected Region Code:', regionCode); 
            if (regionCode) {
                var regionData = data[regionCode];
                if (regionData && regionData.province_list) {
                    var provinces = $.map(regionData.province_list, function(province, key) {
                        return { code: key, name: key };
                    });
                    console.log('Provinces:', provinces); 
                    populateDropdown($('#province'), provinces);
                    $('#city').empty().append($('<option>', { value: '', text: '--select--' }));
                    $('#barangay').empty().append($('<option>', { text: '--select--' }));
                }
            } else {
                $('#province').empty().append($('<option>', { value: '', text: '--select--' }));
                $('#city').empty().append($('<option>', { value: '', text: '--select--' }));
                $('#barangay').empty().append($('<option>', { text: '--select--' }));
            }
        });

        // Event listener for province change
        $('#province').change(function() {
            var regionCode = $('#region').val();
            var provinceName = $(this).val();
            console.log('Selected Province:', provinceName); 
            if (regionCode && provinceName) {
                var provinceData = data[regionCode].province_list[provinceName];
                if (provinceData && provinceData.municipality_list) {
                    var municipalities = $.map(provinceData.municipality_list, function(municipality, key) {
                        return { code: key, name: key };
                    });
                    console.log('Municipalities:', municipalities); 
                    populateDropdown($('#city'), municipalities);
                    $('#barangay').empty().append($('<option>', { text: '--select--' }));
                }
            } else {
                $('#city').empty().append($('<option>', { value: '', text: '--select--' }));
                $('#barangay').empty().append($('<option>', { text: '--select--' }));
            }
        });

        // Event listener for city change
        $('#city').change(function() {
            var regionCode = $('#region').val();
            var provinceName = $('#province').val();
            var cityName = $(this).val();
            console.log('Selected City:', cityName); 
            if (regionCode && provinceName && cityName) {
                var cityData = data[regionCode].province_list[provinceName].municipality_list[cityName];
                if (cityData && cityData.barangay_list) {
                    var barangays = cityData.barangay_list;
                    console.log('Barangays:', barangays); 
                    populateDropdown($('#barangay'), barangays.map(function(barangay) {
                        return { code: barangay, name: barangay };
                    }));
                }
            } else {
                $('#barangay').empty().append($('<option>', { text: '--select--' }));
            }
        });

        // Populating dropdowns for region1
        $('#region1').change(function() {
            var regionCode = $(this).val();
            console.log('Selected Region Code for region1:', regionCode); 
            if (regionCode) {
                var regionData = data[regionCode];
                if (regionData && regionData.province_list) {
                    var provinces = $.map(regionData.province_list, function(province, key) {
                        return { code: key, name: key };
                    });
                    console.log('Provinces for region1:', provinces); 
                    populateDropdown($('#province1'), provinces);
                    $('#city1').empty().append($('<option>', { value: '', text: '--select--' }));
                    $('#barangay1').empty().append($('<option>', { text: '--select--' }));
                }
            } else {
                $('#province1').empty().append($('<option>', { value: '', text: '--select--' }));
                $('#city1').empty().append($('<option>', { value: '', text: '--select--' }));
                $('#barangay1').empty().append($('<option>', { text: '--select--' }));
            }
        });

        // Event listener for province change for region1
        $('#province1').change(function() {
            var regionCode = $('#region1').val();
            var provinceName = $(this).val();
            console.log('Selected Province for region1:', provinceName); 
            if (regionCode && provinceName) {
                var provinceData = data[regionCode].province_list[provinceName];
                if (provinceData && provinceData.municipality_list) {
                    var municipalities = $.map(provinceData.municipality_list, function(municipality, key) {
                        return { code: key, name: key };
                    });
                    console.log('Municipalities for region1:', municipalities); 
                    populateDropdown($('#city1'), municipalities);
                    $('#barangay1').empty().append($('<option>', { text: '--select--' }));
                }
            } else {
                $('#city1').empty().append($('<option>', { value: '', text: '--select--' }));
                $('#barangay1').empty().append($('<option>', { text: '--select--' }));
            }
        });

        // Event listener for city change for region1
        $('#city1').change(function() {
            var regionCode = $('#region1').val();
            var provinceName = $('#province1').val();
            var cityName = $(this).val();
            console.log('Selected City for region1:', cityName); 
            if (regionCode && provinceName && cityName) {
                var cityData = data[regionCode].province_list[provinceName].municipality_list[cityName];
                if (cityData && cityData.barangay_list) {
                    var barangays = cityData.barangay_list;
                    console.log('Barangays for region1:', barangays); 
                    populateDropdown($('#barangay1'), barangays.map(function(barangay) {
                        return { code: barangay, name: barangay };
                    }));
                }
            } else {
                $('#barangay1').empty().append($('<option>', { text: '--select--' }));
            }
        });

        // Populating dropdowns for region2
        $('#region2').change(function() {
            var regionCode = $(this).val();
            console.log('Selected Region Code for region2:', regionCode); 
            if (regionCode) {
                var regionData = data[regionCode];
                if (regionData && regionData.province_list) {
                    var provinces = $.map(regionData.province_list, function(province, key) {
                        return { code: key, name: key };
                    });
                    console.log('Provinces for region2:', provinces); 
                    populateDropdown($('#province2'), provinces);
                    $('#city2').empty().append($('<option>', { value: '', text: '--select--' }));
                    $('#barangay2').empty().append($('<option>', { text: '--select--' }));
                }
            } else {
                $('#province2').empty().append($('<option>', { value: '', text: '--select--' }));
                $('#city2').empty().append($('<option>', { value: '', text: '--select--' }));
                $('#barangay2').empty().append($('<option>', { text: '--select--' }));
            }
        });

        // Event listener for province change for region2
        $('#province2').change(function() {
            var regionCode = $('#region2').val();
            var provinceName = $(this).val();
            console.log('Selected Province for region2:', provinceName); 
            if (regionCode && provinceName) {
                var provinceData = data[regionCode].province_list[provinceName];
                if (provinceData && provinceData.municipality_list) {
                    var municipalities = $.map(provinceData.municipality_list, function(municipality, key) {
                        return { code: key, name: key };
                    });
                    console.log('Municipalities for region2:', municipalities); 
                    populateDropdown($('#city2'), municipalities);
                    $('#barangay2').empty().append($('<option>', { text: '--select--' }));
                }
            } else {
                $('#city2').empty().append($('<option>', { value: '', text: '--select--' }));
                $('#barangay2').empty().append($('<option>', { text: '--select--' }));
            }
        });

        // Event listener for city change for region2
        $('#city2').change(function() {
            var regionCode = $('#region2').val();
            var provinceName = $('#province2').val();
            var cityName = $(this).val();
            console.log('Selected City for region2:', cityName); 
            if (regionCode && provinceName && cityName) {
                var cityData = data[regionCode].province_list[provinceName].municipality_list[cityName];
                if (cityData && cityData.barangay_list) {
                    var barangays = cityData.barangay_list;
                    console.log('Barangays for region2:', barangays); 
                    populateDropdown($('#barangay2'), barangays.map(function(barangay) {
                        return { code: barangay, name: barangay };
                    }));
                }
            } else {
                $('#barangay2').empty().append($('<option>', { text: '--select--' }));
            }
        });
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
    document.title = "LUGAIT CEMETERY INFORMATION MANAGEMENT SYSTEM (LCIMS)";
    $("#search").addClass('active');
    function show_datatable()
    {
        
        $('#tbl_deceaseds').DataTable({
            ajax: {
                type: 'get',
                url: '{{route("deceaseds.get_allData")}}',
                dataType: 'json',
            },
            serverSide: true,
            processing: true,
            order: [[2, "desc"]],
            //Naglisud ta diri 
            columnDefs: [
                {
                    className: "text-center", // Add 'text-center' class to the targeted column
                    targets: [2, 3, 4, 5] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
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
                }
            ],
            dom: 'lBftrip',
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
            responsive: true,
            initComplete: function () {
                this.api().buttons().container().appendTo('#export_buttons');
            },
            columns: [
                {data: "fullname", name: "fullname"},
                {data: "address", name: "address"},
                {data: 'dateofburial', name: 'dateofburial'},
                {data: 'sex', name: 'sex'},
                {data: 'status', name: 'status'},
                {data: 'lastaction', name: 'lastaction'},
                {data: 'action', name: 'action'}
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
        RefreshTable('#tbl_deceaseds', '{{route("deceaseds.get_allData")}}');
    }
    $("#btn_reload").on('click', function(){
        AutoReload();
    })
    show_datatable();
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
    $("#search_block").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#spaceareas tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    var _token = $('input[name="_token"]').val();
        //Money Euro
    $('[data-mask]').inputmask()
    $("#s_deceaseds").addClass('active');
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    var haschecked = 0;
    var haschecked1 = 0;
    $("input[name='sameaddress']").on('click', function(){
       
        if($(this).prop('checked') == true)
        {
            haschecked  = 1;
           $("#contactperson_address").hide();
        }
        else
        {
           haschecked = 0;
            $("#contactperson_address").show();
        }
        $("#check_sameaddress").val(haschecked);
    })
    $("input[name='sameaddress1']").on('click', function(){
       
       if($(this).prop('checked') == true)
       {
           haschecked1  = 1;
          $("#contactperson_address1").hide();
       }
       else
       {
          haschecked1 = 0;
           $("#contactperson_address1").show();
       }
       $("#check_sameaddress1").val(haschecked1);
   })
   var addcontact_person = 0;
   $("input[name='add_contactperson']").on('click', function(){
        if($(this).prop('checked') == true)
        {
            $("#other_contactperson").show();
            addcontact_person = 1;
        }
        else
        {
            $("#other_contactperson").hide();
            addcontact_person = 0;
        }
   })
    show_allBlocks();
    $("#btn_add").on('click', function(){
        if(navigator.onLine)
        {
            $("#cemetery_form").trigger('reset');
            $("#cemetery_id").val("");
            $("#contactperson_id").val("");
            $("#contactperson_id1").val("");
            $('input[type="radio"]').prop('checked', false);
            $('input[type="checkbox"]').prop('checked', false);
            $("#contactperson_address").show();
            $("#contactperson_address1").hide();
            // $('#region').ph_locations('fetch_list');
            // $('#region1').ph_locations('fetch_list');
            // $('#region2').ph_locations('fetch_list'); 
            $("#other_contactperson").hide();
            $("select").val("");

            $("input").removeClass('is-invalid');
            $("input[type='text']").removeClass('is-invalid');
            $("input[type='radio']").removeClass('is-invalid');
            $("input[type='checkbox']").removeClass('is-invalid');
            $("input[type='date']").removeClass('is-invalid');
            $("input[type='number']").removeClass('is-invalid');
            $(".select2-primary").removeClass('is-invalid');
            $(".select2-info").removeClass('is-invalid');
            $(".span").html("");
            addcontact_person = 0;
            haschecked = 0;
            haschecked1 = 0;
            $("#modal_form").modal({backdrop:'static', keyboard: false});
        }
        else
        {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Sorry, we cannot proceed. Please check your internet connection. The issue may be related to the address generated from the internet.',
            });
        }
    })
    function calculateCoffinYears(dateofburial )
    {
        dob = new Date(dateofburial);
        var today = new Date();
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        return age + " YEARS";
    }
    function calculateAge(birthdate, dateofdeath)
    {
        dob = new Date(birthdate);
        var today = new Date(dateofdeath);
        var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
        if(age > 0) return age + " YEARS OLD";
        else return "MONTHS OLD";
    }
    function formatDate(userdate)
    {
        var month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        var date    = new Date(userdate);
        return month[date.getMonth()] + " "+date.getDate() + ", "+date.getFullYear();
    }

    // Space Areas Block
    $("#tbl_deceaseds tbody").on('click', '#btn_assign', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $("#assign_id").val(id);
        $("#assignment").modal({
            'backdrop': 'static',
            'keyboard': false
        });
        show_allSpaceAreas(id);
    })
    function show_allSpaceAreas(assign_id)
    {
        $.ajax({
            type: 'get',
            url: "/deceaseds/show/"+assign_id,
            dataType: 'json',
            success:function(data)
            {
                var name = data[0][0].firstname+" "+data[0][0].middlename+ " "+data[0][0].lastname;
                $("#_deceasedName").text(name);
            },
        });
        $.ajax({
            type: 'get',
            url: "/get/classifiedBlocks/"+assign_id,
            dataType: 'json',
            success:function(data)
            {
                var row = "";
                if(data.cb.length > 0)
                {
                    for(var i = 0; i<data.cb.length; i++)
                    {
                        row += '<tr data-id = '+data.cb[i].id+' style = "text-transform: uppercase">'
                        if(data.cb[i].image != null) row += '<td data-id = '+data.cb[i].id+'><img src = "/upload_images/'+data.cb[i].image+'"  class = "img-responsive" style = "height: 200px; width: 200px" ></td>';    
                        else  row += '<td data-id = '+data.cb[i].id+'><img src= "{{ asset("dist/img/coffin.jpg") }}" class = "img-responsive" style = "width: 200px; height: 200px"></td>';  
                        row += '<td data-id=' + data.cb[i].id + ' style="font-size: 25px; text-align: center; font-family: Segoe UI; font-weight: bold; color: #363737">' + data.cb[i].section_name + '<p> SLOT = ' + data.cb[i].slot + '</p><p> PRICE = ₱' + data.cb[i].block_cost.toFixed(2) + '</p></td>';


                        row += '<td align="center">';
                        if(data.cb[i].status == 1)
                        {
                            $("#coffin_id").val(data.cb[i].coffin_id);
                            row += "<span class = 'badge badge-success' style = 'font-size: 20px'><i class = 'fa fas fa-map-marked-alt'></i>&nbsp; Designated Section </span> <br>";
                        }
                        else
                        {
                            if(data.status == 1)
                            {
                                row += '<button data-id = '+data.cb[i].id+'  data-deceased_id = '+assign_id+' id = "btn_move" style = "" type="button" class="btn btn-danger btn-lg btn-flat">';
                                row += '<i class = "fa fas fa-map-marked-alt"></i>&nbsp; MOVE HERE';
                                row += "</button> <br>";
                            }
                            else
                            {
                                row += '<button data-id = '+data.cb[i].id+' data-deceased_id = '+assign_id+' id = "btn_assign" style = "" type="button" class="btn btn-primary btn-lg btn-flat">';
                                row += '<i class = "fa fas fa-map-marked-alt"></i>&nbsp; PLOT HERE';
                                row += "</button> <br>";
                            }
                        }
                        row += "</td>"
                        row += '</tr>';
                    }
                    $("#spaceareas tbody").html(row);
                }
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
    $("#spaceareas tbody").on('click', "#btn_assign", function(e){
    var space_id = $(this).data('id');
    var deceased_id = $(this).data('deceased_id');
    Swal.fire({
        title: 'Are you sure you want to ASSIGN the deceased in this block?',
        showDenyButton: true,
        showCancelButton: true,
        icon: "info",
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
                title: 'Please enter the payment:',
                input: 'text',
                inputPlaceholder: 'Enter payment amount',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                preConfirm: (payment) => {
                    if (!payment) {
                        Swal.showValidationMessage('You need to enter a payment amount!');
                    }
                    return payment;
                }
            }).then((paymentResult) => {
                if (paymentResult.isConfirmed) {
                    var payment = paymentResult.value;
                    $("#ajax_modal").modal({
                        'backdrop': 'static',
                        'keyboard': false,
                    });
                    $.ajax({
                        type: 'put',
                        url: '/deceaseds/assign_block/' + deceased_id + '/' + space_id,
                        data: {
                            status: 'assign',
                            payment: payment,
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 1) {
                                Swal.fire('Success', response.message, 'success');
                                show_allSpaceAreas(deceased_id);
                                AutoReload();
                            } else if (response.status == 2) {
                                    Swal.fire('Info', response.message, 'info');
                                } else if (response.status == 3) {
                                    Swal.fire('Error', response.message, 'error');
                                } else {
                                    Swal.fire('Error', "Something went wrong cannot process", 'error');
                                }
                            },
                        complete: function(resp) {
                            $("#ajax_modal").modal('hide');
                        },
                        error: function(resp) {
                            $("#ajax_modal").modal('hide');
                            Swal.fire('Error', "Something went wrong!\nPlease check your connection\nThis issue might be on sending email to the recipient.", 'error');
                        }
                    });
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info');
        }
    })
});

    $("#tbl_services tbody").on('click', "#btn_designation", function(e){
        var deceased_id = $(this).data('deceased_id');
        var service_id = $(this).data('id');
        if(confirm("Are you sure you want to proceed with this service?\n\nThis action cannot be undone!"))
        {
            var password;
            do{
                password =  prompt("Please enter your password: ");
            }while(password.length < 4);
            $("#ajax_modal").modal({
                'backdrop': 'static',
                'keyboard': false,
            })
            $.ajax({
                type: 'put',
                url: '/deceaseds/designation/'+deceased_id+'/'+service_id,
                data: {
                    status: 'designation',
                    password: password,
                },
                dataType:'json',
                success: function(response){
                    if(response.status == 1)
                        {
                            show_allServices(deceased_id);
                            AutoReload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                        else
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                },
                complete: function(resp)
                    {
                        $("#ajax_modal").modal('hide');
                    },
                    error: function(resp)
                    {
                        $("#ajax_modal").modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong! Please check your connection. This issue might be on sending email to the recipient.',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }

            })
        }
    })
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
    $("#spaceareas tbody").on('click', "#btn_move", function(e){
    var space_id = $(this).data('id');
    var deceased_id = $(this).data('deceased_id');
    var coffin_id = $('#coffin_id').val();
    var name = "";

    Swal.fire({
        title: 'Are you sure you want to MOVE the deceased in this block?',
        showDenyButton: true,
        showCancelButton: true,
        icon: "question",
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
                inputPlaceholder: 'Enter your password',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                preConfirm: (password) => {
                    if (!password) {
                        Swal.showValidationMessage('You need to enter your password!');
                    }
                    return password;
                }
            }).then((passwordResult) => {
                if (passwordResult.isConfirmed) {
                    var password = passwordResult.value;
                    Swal.fire({
                        title: 'Enter the payment:',
                        input: 'text',
                        inputPlaceholder: 'Enter payment amount',
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        cancelButtonText: 'Cancel',
                        preConfirm: (payment) => {
                            if (!payment) {
                                Swal.showValidationMessage('You need to enter a payment amount!');
                            }
                            return payment;
                        }
                    }).then((paymentResult) => {
                        if (paymentResult.isConfirmed) {
                            var payment = paymentResult.value;
                            $("#ajax_modal").modal({
                                'backdrop': 'static',
                                'keyboard': false,
                            });
                            $.ajax({
                                type: 'put',
                                url: '/deceaseds/assign_block/' + deceased_id + '/' + space_id,
                                data: {
                                    status: 'move',  
                                    coffin_id: coffin_id,
                                    password: password,
                                    payment: payment,
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status == 1) {
                                        Swal.fire('Success', response.message, 'success');
                                        show_allSpaceAreas(deceased_id);
                                        AutoReload(); 
                                    } else if (response.status == 2) {
                                        Swal.fire('Info', response.message, 'info');
                                    } else {
                                        Swal.fire('Error', response.message, 'error');
                                    }
                                },
                                complete: function(resp) {
                                    $("#ajax_modal").modal('hide');
                                },
                                error: function(resp) {
                                    $("#ajax_modal").modal('hide');
                                    Swal.fire('Error', "Something went wrong!\nPlease check your connection\nThis issue might be on sending email to the recipient.", 'error');
                                }
                            });
                        }
                    });
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info');
        }
    })
});

   
    $("#tbl_deceaseds tbody").on('click', "#btn_info", function(e){
        e.preventDefault();
        var deceased_id = $(this).data('id');
        $.ajax({
            type: 'get',
            url: "/deceaseds/show/"+deceased_id,
            dataType: 'json',
            success:function(data)
            {
                $("#deceased_info").modal({
                    'backdrop': 'static',
                    'keyboard': false
                });
                var tbl_years = "<tbody>";
                tbl_years += "<tr style = 'background-color: darkred; color: white' class = 'tbl_burialyears'>";
                tbl_years += "<th>YEARS FROM BURIAL</th>";
                tbl_years += "<th>"+calculateCoffinYears(data[0][0].dateof_death)+"</th>";
                tbl_years += "</tr>";

                if(data[1] != "")
                {
                    if(data[1][0].image == "")
                    {
                        $("#img_rip").attr('src', '{{ asset("dist/img/coffin.jpg") }}');  
                    }
                    else
                    {
                        $("#img_rip").attr('src', '/upload_images/'+data[1][0].image+'');  
                        tbl_years += "<tr style = 'background-color: #0A1931; color: white' class = 'tbl_burialyears'>";
                        tbl_years += "<th>BLOCK ASSIGNED</th>";
                        tbl_years += "<th>"+data[1][0].section_name+"</th>";
                        tbl_years += "</tr>";
                        tbl_years += "</tbody>";
                    }
                }
                else
                {
                    $("#img_rip").attr('src', '{{ asset("dist/img/coffin.jpg") }}');  
                }
                
                $("#tbl_years").html(tbl_years);

                var table = "<tbody>";
                table += "<tr style = 'background-color: darkred; color: white'>";
                table += "<th colspan ='2' style = 'text-align:center'>DECEASED INFORMATION</th>";
                table += "</tr>";

                table += "<tr style = 'background-color: darkred; color: white'>";
                table += "<th colspan ='2'>PERSONAL INFO</th>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>LAST NAME</th>";
                table += "<th style = 'font-size: 16px'>"+data[0][0].lastname+"</th?>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>MIDDLE NAME</th>";
                table += "<th style = 'font-size: 16px'>"+data[0][0].middlename+"</th>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>FIRST NAME</th>";
                table += "<th style = 'font-size: 16px'>"+data[0][0].firstname+"</th>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>EXTENSION NAME</th>";
                table += "<td>"+data[0][0].suffix +"</td>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>SEX</th>";
                table += "<td>"+data[0][0].sex+"</td>";
                table += "</tr>";

                var maritalstatus = "";

                if(data[0][0].civilstatus == "S") maritalstatus = "SINGLE";
                if(data[0][0].civilstatus == "M") maritalstatus = "MARRIED";
                if(data[0][0].civilstatus == "W") maritalstatus = "WIDOWED";
                if(data[0][0].civilstatus == "D") maritalstatus = "DIVORCED";

                table += "<tr>";
                table += "<th>MARITAL STATUS</th>";
                table += "<td>"+maritalstatus+"</td>";
                table += "</tr>";

                var causeofdeath = "";
                
                if(data[0][0].causeofdeath == "N") causeofdeath = "NATURAL";
                if(data[0][0].causeofdeath == "A") causeofdeath = "ACCIDENT";
                if(data[0][0].causeofdeath == "H") causeofdeath = "HOMICIDE";
                if(data[0][0].causeofdeath == "S") causeofdeath = "SUICIDE";
                if(data[0][0].causeofdeath == "U") causeofdeath = "UNDETERMINED";
                if(data[0][0].causeofdeath == "O") causeofdeath = "OTHER";

                table += "<tr>";
                table += "<th>CAUSE OF DEATH</th>";
                table += "<td><span class = 'badge badge-danger'>"+causeofdeath+"</span></td>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>AGE DIED</th>";
                table += "<td>"+calculateAge(data[0][0].dateofbirth, data[0][0].dateof_death)+"</td>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>DATE OF BIRTH</th>";
                table += "<td>"+formatDate(data[0][0].dateofbirth)+"</td>";
                table += "</tr>";

                table += "<tr style = 'background-color: darkred; color: white'>";
                table += "<th colspan ='2'>ADDRESS</th>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>BARANGAY</th>";
                table += "<td>"+data[0][0].barangay+"</td>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>CITY/MUNICIPALITY</th>";
                table += "<td>"+data[0][0].city+"</td>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>PROVINCE</th>";
                table += "<td>"+data[0][0].province+"</td>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>REGION</th>";
                table += "<td>"+data[0][0].region+"</td>";
                table += "</tr>";

                table += "<tr style = 'background-color: darkred; color: white'>";
                table += "<th colspan ='2'>BURIAL INFO</th>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>DATE OF DEATH</th>";
                table += "<td>"+formatDate(data[0][0].dateof_death)+"</td>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>DATE OF BURIAL</th>";
                table += "<td>"+formatDate(data[0][0].dateof_burial)+"</td>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>BURIAL TIME</th>";
                table += "<td>"+data[0][0].burial_time+"</td>";
                table += "</tr>";

                table += "<tr style = 'background-color: darkred; color: white'>";
                table += "<th colspan ='2'>PAYMENT DETAILS</th>";
                table += "</tr>";

                table += "<tr>";
                table += "<th>REMAINING BALANCE</th>";
                var formattedBalance = "&#8369; " + parseFloat(data[0][0].remaining_balance).toFixed(2);
                table += "<td align='center'>" + formattedBalance + "</td>";

                table += "</tr>";


                table += "</tbody>";

                var row = "";
                var no = 1;
                row += "<tr style = 'background-color: darkred; color: white'>";
                row += "<th colspan ='2' style = 'text-align:center'>CONTACT PEOPLE INFORMATION</th>";
                row += "</tr>";
                for(var i = 0; i<data[2].length; i++)
                {
                    row += "<tr style = 'background-color: #0A1931; color: white'>";
                    row += "<th>CONTACT NAME NO. "+no+"</th>";
                    row += "<th style = 'font-size: 16px'>"+data[2][i].name+"</th>";
                    row += "</tr>";

                    if(data[2][i].barangay != null)
                    {
                        row += "<tr>";
                        row += "<th>BARANGAY</th>";
                        row += "<td>"+data[2][i].barangay+"</td>";
                        row += "</tr>";
                    }
                    
                    row += "<tr>";
                    row += "<th>PHONE NUMBER (+63)</th>";
                    row += "<td><span class = 'badge badge-primary' style = 'font-size: 15px'>"+data[2][i].contactnumber+"</span></td>";
                    row += "</tr>";

                    row += "<tr>";
                    row += "<th>EMAIL</th>";
                    row += "<td><span class = 'badge badge-secondary' style = 'font-size: 15px'>"+data[2][i].email+"</span></td>";
                    row += "</tr>";
                    
                    var relationship = "";
                    if(data[2][i].relationshipthdeceased == "1") relationship = "SIBLING";
                    if(data[2][i].relationshipthdeceased == "2") relationship = "COUSIN";
                    if(data[2][i].relationshipthdeceased == "3") relationship = "PARENT";
                    if(data[2][i].relationshipthdeceased == "4") relationship = "CHILDREN";
                    if(data[2][i].relationshipthdeceased == "5") relationship = "SPOUSE";
                    if(data[2][i].relationshipthdeceased == "6") relationship = "OTHER";

                    row += "<tr>";
                    row += "<th>RELATIONSHIP</th>";
                    row += "<td><span class = 'badge badge-success'>"+relationship+"</span> </td>";
                    row += "</tr>";

                    row += "<tr>";
                    row += "<th>CITY/MUNICIPALITY</th>";
                    row += "<td>"+data[2][i].city+"</td>";
                    row += "</tr>";

                    row += "<tr>";
                    row += "<th>PROVINCE</th>";
                    row += "<td>"+data[2][i].province+"</td>";
                    row += "</tr>";

                    row += "<tr>";
                    row += "<th>REGION</th>";
                    row += "<td>"+data[2][i].region+"</td>";
                    row += "</tr>";
                    no = no + 1;
                }
                $("#tbl_deceasedinfo").html(table);
                $("#tbl_contactinfo").html(row);
            },
            error: function() {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'System cannot process request.',
    });
}

        })
    })
    $("#tbl_deceaseds tbody").on('click', '#btn_edit', function(e){
        e.preventDefault();
        if(navigator.onLine)
        {
            $("#cemetery_form").trigger('reset');
            $("select").val("");
            var id = $(this).data('id');
            haschecked = 0;
            haschecked1 = 0;
            $('input[type="radio"]').attr('checked', false);
            $('input[type="checkbox"]').attr('checked', false);
            $.ajax({
                type: 'get',
                url: "/deceaseds/show/"+id,
                dataType: 'json',
                success:function(data)
                {
                    $("#contactperson_address").show();
                    $("#contactperson_address1").show();
                    $("#cemetery_id").val(id);
                    $("#contactperson_id").val(data[2][0].contactperson_id);
                    $("#lastname").val(data[0][0].lastname)
                    $("#middlename").val(data[0][0].middlename)
                    $("#firstname").val(data[0][0].firstname)
                    $("#suffix").val(data[0][0].suffix)
                    $("#dateof_death").val(data[0][0].dateof_death)
                    $("#dateofbirth").val(data[0][0].dateofbirth)
                    $("input[name='civilstatus'][value="+data[0][0].civilstatus+"]").attr('checked', true)
                    $("#dateof_burial").val(data[0][0].dateof_burial)
                    $("#burial_time").val(data[0][0].burial_time)
                    $("input[name='sex'][value="+data[0][0].sex+"]").attr('checked', true)
                    
                    //PINAHIRAPAN MO AKO
                    $("#address_id").val(data[0][0].a_address_id)
                    $("#region option").filter(function() {
                        return $(this).val() == data[0][0].region_no;
                    }).prop('selected', true);
                    $("#province").prepend("<option selected='selected' value = "+data[0][0].province_no+">"+data[0][0].province+"</option>");
                    $("#city").prepend("<option selected='selected' value = "+data[0][0].city_no+">"+data[0][0].city+"</option>");
                    $("#barangay").prepend("<option selected='selected' value = "+data[0][0].barangay_no+">"+data[0][0].barangay+"</option>");
                    
                    $("#causeofdeath option").filter(function() {
                        return $(this).val() == data[0][0].causeofdeath;
                    }).prop('selected', true);

                    $("#contactperson").val(data[2][0].name),
                    $("#relationship option").filter(function() {
                        return $(this).val() == data[2][0].relationshipthdeceased;
                    }).prop('selected', true);
                    $("#contactnumber").val(data[2][0].contactnumber.replace("63", ""));
                    $("#email").val(data[2][0].email);

                    $("#region1 option").filter(function() {
                        return $(this).val() == data[2][0].region_no;
                    }).prop('selected', true);
                    $("input[name='add_contactperson']").prop('checked', false);
                    $("#province1").prepend("<option selected='selected' value = "+data[2][0].province_no+">"+data[2][0].province+"</option>");
                    $("#city1").prepend("<option selected='selected' value = "+data[2][0].city_no+">"+data[2][0].city+"</option>");
                    if(data[2][0].barangay != null)
                    {
                        $("#barangay1").prepend("<option selected='selected' value = "+data[2][0].barangay_no+">"+data[2][0].barangay+"</option>");
                    }
                    $("#address_id1").val(data[2][0].address_id);
                    addcontact_person = 0;
                    $("#other_contactperson").hide();
                    if(data[2].length > 1)
                    {
                        $("input[name='add_contactperson']").prop('checked', true);
                        addcontact_person = 1;
                        $("#address_id2").val(data[2][1].address_id);
                        $("#contactperson_id1").val(data[2][1].contactperson_id);
                        $("#contactperson1").val(data[2][1].name),
                        $("#relationship1 option").filter(function() {
                            return $(this).val() == data[2][1].relationshipthdeceased;
                        }).prop('selected', true);
                        $("#contactnumber1").val(data[2][1].contactnumber.replace("63", ""));
                        $("#email1").val(data[2][1].email);
                        $("#other_contactperson").show();
                        $("#region2 option").filter(function() {
                            return $(this).val() == data[2][1].region_no;
                        }).attr('selected', true);
                        $("#province2").prepend("<option selected='selected' value = "+data[2][1].province_no+">"+data[2][1].province+"</option>");
                        $("#city2").prepend("<option selected='selected' value = "+data[2][1].city_no+">"+data[2][1].city+"</option>");
                        if(data[2][1].barangay != null)
                        {
                            $("#barangay2").prepend("<option selected='selected' value = "+data[2][1].barangay_no+">"+data[2][1].barangay+"</option>");
                        }
                    }
                
                    $("#modal_form").modal({
                        'backdrop': 'static',
                        'keyboard': false
                    })
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
        else {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Sorry, we cannot proceed. Please check your internet connection. The issue may be related to the address generated from the internet.',
    });
}

    })
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
                    if(data[i].status == 1)
                    {
                        row += '<tr data-id = '+data[i].id+' style = "text-transform: uppercase">';
                        row += '<td style = "color: red; font-size: 23px" data-column_name  = "service_name" data-id = '+data[i].id+' colspan="2">'+data[i].service_name+'</td>';
                        row += '<td align = "center" style = "font-size: 23px">';
                        row += '<span class = "badge badge-success" >PROCESSED</span></td>';
                        row += '</tr>';
                    }
                    else
                    {
                        row += '<tr data-id = '+data[i].id+' style = "text-transform: uppercase">';
                        row += '<td style = "color: red; font-size: 23px" data-column_name  = "service_name" data-id = '+data[i].id+' colspan="2">'+data[i].service_name+'</td>';
                        row += '<td align = "center">';
                        row += '<button data-deceased_id = '+deceased_id+' data-id = '+data[i].id+' id = "btn_designation" style = "font-size: 23px" type="button" class="btn btn-primary btn-sm btn-flat">';
                        row += '<i class = "fas fa-chess-king"></i>&nbsp; CHOOSE';
                        row += '</button></td>';
                        row += '</tr>';
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
    function show_allBlocks()
    {
        $.ajax({
            type: 'get',
            url: "{{ route('spaceareas.get_allBlocks') }}",
            dataType: 'json',
            success:function(data)
            {
                var row = "<option></option>";
                if(data.length > 0)
                {
                    for(var i = 0; i<data.length; i++)
                    {
                        row += "<option value = "+data[i].id+">"+data[i].block_number+" - "+data[i].section_name+"</option>";
                    }
                }
                else
                {
                    row += '<option>No data available.</option>';
                }
                $(".block_id").html(row);
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
    show_allContactPeople();
    function show_allContactPeople()
    {
        $.ajax({
            type: 'get',
            url: "{{ route('users.contactpeople') }}",
            dataType: 'json',
            success:function(data)
            {
                var row = "<option></option>";
                if(data.length > 0)
                {
                    for(var i = 0; i<data.length; i++)
                    {
                        row += "<option>"+data[i].name+"</option>";
                    }
                }
                else
                {
                    row += '<option>No data available.</option>';
                }
                $("#contactpersons").html(row);
                $("#contactpersons1").html(row);
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
    
    $("#cemetery_form").on('submit', function(e){
        e.preventDefault();
        // $("#pageloader").show();
        var cem_id = $("#cemetery_id").val();
        var data = $(this).serialize();
        var region_text = $("#region option:selected").text();
        var province_text = $("#province option:selected").text();
        var city_text = $("#city option:selected").text();
        var barangay_text = $("#barangay option:selected").text();

        var region_text1 = $("#region1 option:selected").text();
        var province_text1 = $("#province1 option:selected").text();
        var city_text1 = $("#city1 option:selected").text();
        var barangay_text1 = $("#barangay1 option:selected").text();

        var region_text2 = $("#region2 option:selected").text();
        var province_text2 = $("#province2 option:selected").text();
        var city_text2 = $("#city2 option:selected").text();
        var barangay_text2 = $("#barangay2 option:selected").text();
        
        
        var sameaddress = "";
        $("input[type='text']").removeClass('is-invalid');
        $("input[type='radio']").removeClass('is-invalid');
        $("input[type='checkbox']").removeClass('is-invalid');
        $("input[type='date']").removeClass('is-invalid');
        $("input[type='number']").removeClass('is-invalid');
        $(".select2-primary").removeClass('is-invalid');
        $(".select2-info").removeClass('is-invalid');
        $(".span").html("");

        if(cem_id === "")
        {
            $.ajax({
                type: 'post',
                url: '{{ route("deceaseds.store") }}',
                data: {
                    lastname: $("#lastname").val(),
                    middlename: $("#middlename").val(),
                    firstname: $("#firstname").val(),
                    suffix: $("#suffix").val(),
                    dateof_death: $("#dateof_death").val(),
                    dateofbirth: $("#dateofbirth").val(),
                    civilstatus: $("input[name='civilstatus']:checked").val(),
                    dateof_burial: $("#dateof_burial").val(),
                    burial_time: $("#burial_time").val(),
                    sex: $("input[name='sex']:checked").val(),
                    region: $("#region").val(),
                    province: $("#province").val(),
                    city: $("#city").val(),
                    barangay: $("#barangay").val(),
                    causeofdeath: $("#causeofdeath").val(),
                    contactperson: $("#contactperson").val(),
                    relationship: $("#relationship").val(),
                    contactnumber: $("#contactnumber").val(),
                    email: $("#email").val(),
                    region1: $("#region1").val(),
                    province1: $("#province1").val(),
                    city1: $("#city1").val(),
                    barangay1: $("#barangay1").val(),
                    region_text: region_text,
                    province_text: province_text,
                    city_text: city_text,
                    barangay_text: barangay_text,
                    region_text1: region_text1,
                    province_text1: province_text1,
                    city_text1: city_text1,
                    barangay_text1: barangay_text1,
                    sameaddress: haschecked,
                    contactperson1: $("#contactperson1").val(),
                    relationship1: $("#relationship1").val(),
                    contactnumber1: $("#contactnumber1").val(),
                    email1: $("#email1").val(),
                    region2: $("#region2").val(),
                    province2: $("#province2").val(),
                    city2: $("#city2").val(),
                    barangay2: $("#barangay2").val(),
                    region_text2: region_text2,
                    province_text2: province_text2,
                    city_text2: city_text2,
                    barangay_text2: barangay_text2,
                    sameaddress1: haschecked1,
                    addcontactperson: addcontact_person,
                },
                dataType: 'json',
                success: function(response){
                    if(response.status == 1)
                    {
                        show_allBlocks();
                        AutoReload();
                        $("input[type='text']").removeClass('is-invalid');
                        $("input[type='radio']").removeClass('is-invalid');
                        $("input[type='checkbox']").removeClass('is-invalid');
                        $("input[type='date']").removeClass('is-invalid');
                        $("input[type='number']").removeClass('is-invalid');
                        $(".select2-primary").removeClass('is-invalid');
                        $(".select2-info").removeClass('is-invalid');
                        $(".span").html("");
                        $("#modal_form").modal('hide');
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
                         $.each(response.message, function(key, value){
                            if(key == "lastname")
                            {
                                $("#sp_lastname").text(value);
                                $("#lastname").addClass('is-invalid');
                            }
                            else  if(key == "firstname")
                            {
                                $("#sp_firstname").text(value);
                                $("#firstname").addClass('is-invalid');
                            }
                            else if(key == "middlename")
                            {
                                $("#sp_middlename").text(value);
                                $("#middlename").addClass('is-invalid');
                            }
                            else if(key == "suffix")
                            {
                                $("#sp_suffix").text(value);
                                $("#suffix").addClass('is-invalid');
                            }
                            else if(key == "dateof_death")
                            {
                                $("#sp_dateofdeath").text(value);
                                $("#dateof_death").addClass('is-invalid');
                            }
                            else if(key == "dateofbirth")
                            {
                                $("#sp_dateofbirth").text(value);
                                $("#dateofbirth").addClass('is-invalid');
                            }
                            else if(key == "civilstatus")
                            {
                                $("#sp_civilstatus").text(value);
                                $("#civilstatus").addClass('is-invalid');
                            }
                            else if(key == "dateof_burial")
                            {
                                $("#sp_dateofburial").text(value);
                                $("#dateof_burial").addClass('is-invalid');
                            }
                            else if(key == "burial_time")
                            {
                                $("#sp_burialtime").text(value);
                                $("#burial_time").addClass('is-invalid');
                            }
                            else if(key == "sex")
                            {
                                $("#sp_sex").text(value);
                                $("#sex").addClass('is-invalid');
                            }
                            else if(key == "region")
                            {
                                $("#sp_region").text(value);
                                $("#region").addClass('is-invalid');
                            }
                            else if(key == "province")
                            {
                                $("#sp_province").text(value);
                                $("#province").addClass('is-invalid');
                            }
                            else if(key == "city")
                            {
                                $("#sp_city").text(value);
                                $("#city").addClass('is-invalid');
                            }
                            else if(key == "barangay")
                            {
                                $("#sp_barangay").text(value);
                                $("#barangay").addClass('is-invalid');
                            }
                            else if(key == "causeofdeath")
                            {
                                $("#sp_causeofdeath").text(value);
                                $("#causeofdeath").addClass('is-invalid');
                            }
                            else if(key == "service_id")
                            {
                                $("#sp_service").text(value);
                                $("#service_id").addClass('is-invalid');
                            }
                            else if(key == "contactperson")
                            {
                                $("#sp_contactperson").text(value);
                                $("#contactperson").addClass('is-invalid');
                            }
                            else if(key == "contactnumber")
                            {
                                $("#sp_contactnumber").text(value);
                                $("#contactnumber").addClass('is-invalid');
                            }
                            else if(key == "email")
                            {
                                $("#sp_email").text(value);
                                $("#email").addClass('is-invalid');
                            }
                            else if(key == "relationship")
                            {
                                $("#sp_relationship").text(value);
                                $("#relationship").addClass('is-invalid');
                            }
                            else if(key == "region1")
                            {
                                $("#sp_region1").text(value);
                                $("#region1").addClass('is-invalid');
                            }
                            else if(key == "province1")
                            {
                                $("#sp_province1").text(value);
                                $("#province1").addClass('is-invalid');
                            }
                            else if(key == "city1")
                            {
                                $("#sp_city1").text(value);
                                $("#city1").addClass('is-invalid');
                            }
                            else if(key == "barangay1")
                            {
                                $("#sp_barangay1").text(value);
                                $("#barangay1").addClass('is-invalid');
                            }

                            else if(key == "contactperson1")
                            {
                                $("#sp_contactperson1").text(value);
                                $("#contactperson1").addClass('is-invalid');
                            }
                            else if(key == "contactnumber1")
                            {
                                $("#sp_contactnumber1").text(value);
                                $("#contactnumber1").addClass('is-invalid');
                            }
                            else if(key == "email1")
                            {
                                $("#sp_email1").text(value);
                                $("#email1").addClass('is-invalid');
                            }
                            else if(key == "relationship1")
                            {
                                $("#sp_relationship1").text(value);
                                $("#relationship1").addClass('is-invalid');
                            }
                            else if(key == "region2")
                            {
                                $("#sp_region2").text(value);
                                $("#region2").addClass('is-invalid');
                            }
                            else if(key == "province2")
                            {
                                $("#sp_province2").text(value);
                                $("#province2").addClass('is-invalid');
                            }
                            else if(key == "city2")
                            {
                                $("#sp_city2").text(value);
                                $("#city2").addClass('is-invalid');
                            }
                            else if(key == "barangay2")
                            {
                                $("#sp_barangay2").text(value);
                                $("#barangay2").addClass('is-invalid');
                            }
                            else
                            {
                                
                            }
                    });
                    }
                    else
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }

                },
                complete: function(response){
                    $("#preloader").hide();
                },
                error: function(response) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Sorry for the inconvenience. Cannot process the request.',
    });
}

            });
        }
        else
        {
        Swal.fire({
        title: 'Are you sure you want to update the information of the deceased?',
        showDenyButton: true,
        icon: "question",
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
                    type: 'put',
                    url: "/deceaseds/update/"+cem_id,
                    data: {
                        cem_id: cem_id,
                        contactperson_id: $("#contactperson_id").val(),
                        contactperson_id1: $("#contactperson_id1").val(),
                        lastname: $("#lastname").val(),
                        middlename: $("#middlename").val(),
                        firstname: $("#firstname").val(),
                        suffix: $("#suffix").val(),
                        dateof_death: $("#dateof_death").val(),
                        dateofbirth: $("#dateofbirth").val(),
                        civilstatus: $("input[name='civilstatus']:checked").val(),
                        dateof_burial: $("#dateof_burial").val(),
                        burial_time: $("#burial_time").val(),
                        sex: $("input[name='sex']:checked").val(),
                        region: $("#region").val(),
                        province: $("#province").val(),
                        city: $("#city").val(),
                        barangay: $("#barangay").val(),
                        causeofdeath: $("#causeofdeath").val(),
                        contactperson: $("#contactperson").val(),
                        relationship: $("#relationship").val(),
                        contactnumber: $("#contactnumber").val(),
                        email: $("#email").val(),
                        region1: $("#region1").val(),
                        province1: $("#province1").val(),
                        city1: $("#city1").val(),
                        barangay1: $("#barangay1").val(),
                        region_text: region_text,
                        province_text: province_text,
                        city_text: city_text,
                        barangay_text: barangay_text,
                        region_text1: region_text1,
                        province_text1: province_text1,
                        city_text1: city_text1,
                        barangay_text1: barangay_text1,
                        sameaddress: haschecked,
                        contactperson1: $("#contactperson1").val(),
                        relationship1: $("#relationship1").val(),
                        contactnumber1: $("#contactnumber1").val(),
                        email1: $("#email1").val(),
                        region2: $("#region2").val(),
                        province2: $("#province2").val(),
                        city2: $("#city2").val(),
                        barangay2: $("#barangay2").val(),
                        region_text2: region_text2,
                        province_text2: province_text2,
                        city_text2: city_text2,
                        barangay_text2: barangay_text2,
                        sameaddress1: haschecked1,
                        addcontactperson: addcontact_person,
                    },
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 1)
                        {
                            show_allBlocks();
                            AutoReload();
                            $("input[type='text']").removeClass('is-invalid');
                            $("input[type='radio']").removeClass('is-invalid');
                            $("input[type='checkbox']").removeClass('is-invalid');
                            $("input[type='date']").removeClass('is-invalid');
                            $("input[type='number']").removeClass('is-invalid');
                            $(".select2-primary").removeClass('is-invalid');
                            $(".select2-info").removeClass('is-invalid');
                            $(".span").html("");
                            $("#modal_form").modal('hide');
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
                            $.each(response.message, function(key, value){
                                if(key == "lastname")
                                {
                                    $("#sp_lastname").text(value);
                                    $("#lastname").addClass('is-invalid');
                                }
                                else  if(key == "firstname")
                                {
                                    $("#sp_firstname").text(value);
                                    $("#firstname").addClass('is-invalid');
                                }
                                else if(key == "middlename")
                                {
                                    $("#sp_middlename").text(value);
                                    $("#middlename").addClass('is-invalid');
                                }
                                else if(key == "suffix")
                                {
                                    $("#sp_suffix").text(value);
                                    $("#suffix").addClass('is-invalid');
                                }
                                else if(key == "dateof_death")
                                {
                                    $("#sp_dateofdeath").text(value);
                                    $("#dateof_death").addClass('is-invalid');
                                }
                                else if(key == "dateofbirth")
                                {
                                    $("#sp_dateofbirth").text(value);
                                    $("#dateofbirth").addClass('is-invalid');
                                }
                                else if(key == "civilstatus")
                                {
                                    $("#sp_civilstatus").text(value);
                                    $("#civilstatus").addClass('is-invalid');
                                }
                                else if(key == "dateof_burial")
                                {
                                    $("#sp_dateofburial").text(value);
                                    $("#dateof_burial").addClass('is-invalid');
                                }
                                else if(key == "burial_time")
                                {
                                    $("#sp_burialtime").text(value);
                                    $("#burial_time").addClass('is-invalid');
                                }
                                else if(key == "sex")
                                {
                                    $("#sp_sex").text(value);
                                    $("#sex").addClass('is-invalid');
                                }
                                else if(key == "region")
                                {
                                    $("#sp_region").text(value);
                                    $("#region").addClass('is-invalid');
                                }
                                else if(key == "province")
                                {
                                    $("#sp_province").text(value);
                                    $("#province").addClass('is-invalid');
                                }
                                else if(key == "city")
                                {
                                    $("#sp_city").text(value);
                                    $("#city").addClass('is-invalid');
                                }
                                else if(key == "barangay")
                                {
                                    $("#sp_barangay").text(value);
                                    $("#barangay").addClass('is-invalid');
                                }
                                else if(key == "causeofdeath")
                                {
                                    $("#sp_causeofdeath").text(value);
                                    $("#causeofdeath").addClass('is-invalid');
                                }
                                else if(key == "service_id")
                                {
                                    $("#sp_service").text(value);
                                    $("#service_id").addClass('is-invalid');
                                }
                                else if(key == "contactperson")
                                {
                                    $("#sp_contactperson").text(value);
                                    $("#contactperson").addClass('is-invalid');
                                }
                                else if(key == "contactnumber")
                                {
                                    $("#sp_contactnumber").text(value);
                                    $("#contactnumber").addClass('is-invalid');
                                }
                                else if(key == "email")
                                {
                                    $("#sp_email").text(value);
                                    $("#email").addClass('is-invalid');
                                }
                                else if(key == "relationship")
                                {
                                    $("#sp_relationship").text(value);
                                    $("#relationship").addClass('is-invalid');
                                }
                                else if(key == "region1")
                                {
                                    $("#sp_region1").text(value);
                                    $("#region1").addClass('is-invalid');
                                }
                                else if(key == "province1")
                                {
                                    $("#sp_province1").text(value);
                                    $("#province1").addClass('is-invalid');
                                }
                                else if(key == "city1")
                                {
                                    $("#sp_city1").text(value);
                                    $("#city1").addClass('is-invalid');
                                }
                                else if(key == "barangay1")
                                {
                                    $("#sp_barangay1").text(value);
                                    $("#barangay1").addClass('is-invalid');
                                }

                                else if(key == "contactperson1")
                                {
                                    $("#sp_contactperson1").text(value);
                                    $("#contactperson1").addClass('is-invalid');
                                }
                                else if(key == "contactnumber1")
                                {
                                    $("#sp_contactnumbe1r").text(value);
                                    $("#contactnumber1").addClass('is-invalid');
                                }
                                else if(key == "email1")
                                {
                                    $("#sp_email1").text(value);
                                    $("#email1").addClass('is-invalid');
                                }
                                else if(key == "relationship1")
                                {
                                    $("#sp_relationship1").text(value);
                                    $("#relationship1").addClass('is-invalid');
                                }
                                else if(key == "region2")
                                {
                                    $("#sp_region2").text(value);
                                    $("#region2").addClass('is-invalid');
                                }
                                else if(key == "province2")
                                {
                                    $("#sp_province2").text(value);
                                    $("#province2").addClass('is-invalid');
                                }
                                else if(key == "city2")
                                {
                                    $("#sp_city2").text(value);
                                    $("#city2").addClass('is-invalid');
                                }
                                else if(key == "barangay2")
                                {
                                    $("#sp_barangay2").text(value);
                                    $("#barangay2").addClass('is-invalid');
                                }
                                else
                                {
                                    
                                }
                        });
                        }
                        else
                        {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }

                    },
                    complete: function(response){
                        $("#preloader").hide();
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Request Failed',
                            text: 'Sorry for the inconvenience. Cannot process the request. Might be your email or other details already existing.',
                        });
                    }

                });
            }
        }
    )}
    });
  })
</script>
</body>
</html>