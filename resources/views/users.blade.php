<!DOCTYPE html>
<html lang="en">
<head>
  @include('references.links')
  <style>
    select,option{
      text-transform: uppercase;
    }
  </style>
</head>
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
            <h4>Users</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                    @if(Auth::user()->role == 1)
                    <div class="col-sm-6">
                        <button class = "btn btn-default btn-flat" id = "btn_openform"><i class = "fas fa fa-user-plus"></i>&nbsp;&nbsp; Create User</button>
                        <button class = "btn btn-primary btn-flat" id = "btn_reload"><i class = "fas fa fa-sync"></i>&nbsp;&nbsp; Reload Table</button>
                    </div>
                    @endif
                    <div class="col-sm-6">
                        <div id="export_buttons">

                        </div>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="users" class="table  table-stripped table-bordered table-hovered">

                <thead style = "background-color: #0A1931; color: white">
                  <tr>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Role</th>
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

  <div class="modal fade" id="modal_form">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style = "background-color: #0A1931; color: white">
                <h4 class="modal-title"> 
                <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 50px; height: 50px" alt="">    
                 Create New User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id = "user_form" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}    
                <div class="modal-body">
                    <div class="row" >
                        <input type="hidden"  name = "user_id" id = "user_id" value = "0">
                        <input type="hidden"  name = "role" id = "role"  value  = "0">
                        <input type="hidden"  name = "changepass" id = "changepass"  value  = "0">
                        <input type="hidden"  name = "address_id" id = "address_id"  value  = "">
                        <input type="hidden"  name = "address_id1" id = "address_id1"  value  = "">

                        <div class="col-md-4">
                            <label for="">Name<span style="color:red">*</span></label>
                            <input type="text" style = "text-transform: uppercase" name="name" id="name" class="form-control form-control-border border-width-3" autocomplete = "off" 
                                onkeydown="return /[a-zA-Z ]/i.test(event.key)" oninput="return $('#errmsg_name').html(''), $(this).removeClass('is-invalid')">
                            <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_name"></span>
                        </div>
                        <div class="col-md-4" >
                            <label for="">Email<span style="color:red">*</span></label>
                            <input type="email" oninput="return $('#errmsg_email').html(''), $(this).removeClass('is-invalid')" style = "text-transform: uppercase" name="email" id="email" class="form-control form-control-border border-width-3" autocomplete = "off">
                            <span class = "span_error" style ="color:red; font-size: 12px" id = "errmsg_email"></span>
                        </div>
                        <div class="col-md-4" >
                            <label for="">Contact Number (<i>Ex. 9303087678</i>)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i>&nbsp; +63</span>
                                </div>
                                <input type="tel" maxlength = "10" pattern = "^(9|\+639)\d{9}$" oninput="return $('#sp_contactnumber').html(''), $(this).removeClass('is-invalid')" id = "contactnumber" name = "contactnumber" class="form-control form-control-border" >
                            </div>
                            <span style = "color: red" class = "span_error" id = "sp_contactnumber"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-6">
                          <button type = "button" class = "button btn btn-sm btn-primary" id = "btn_changeaddress">Change Address</button>
                          <button  style = "display: none" type = "button" class = "button btn btn-sm btn-secondary" id = "btn_unchangeaddress">Unchange Address</button>
                        </div>
                      </div>
                    <p></p>
                    <div class="row" id = "address_area1">
                        <div class="col-md-3">
                            <label for="">Region</label>
                            <select class="form-control form-control-border select2 select2-primary " disabled data-dropdown-css-class="select2-primary" id = "region1"  style="width: 100%;">
                                
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary " disabled data-dropdown-css-class="select2-primary" id = "province1" style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">City / Municipality</label>
                            <select class="form-control form-control-border select2-primary"  disabled data-dropdown-css-class="select2-primary" id = "city1"  style="width: 100%;">
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary" disabled data-dropdown-css-class="select2-primary" id = "barangay1" n style="width: 100%; text-transform: uppercase">
                            </select>
                        </div>
                    </div>
                    <p></p>
                    <div class="row" id = "address_area" style = "display: none">
                        <div class="col-md-3">
                            <label for="">Region</label>
                            <select class="form-control form-control-border select2 select2-primary" onchange="return $('#sp_region').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "region" name = "region" style="width: 100%;">
                                
                            </select>
                            <span style = "color: red" class = "span_error" id = "sp_region"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Province</label>
                            <select class="form-control form-control-border select2-primary " onchange="return $('#sp_province').html(''), $(this).removeClass('is-invalid')"data-dropdown-css-class="select2-primary" id = "province" name = "province" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span_error" id = "sp_province"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">City / Municipality</label>
                            <select class="form-control form-control-border select2-primary " onchange="return $('#sp_city').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "city" name = "city" style="width: 100%;">
                            </select>
                            <span style = "color: red" class = "span_error" id = "sp_city"></span>
                        </div>
                        <div class="col-md-3">
                            <label for="">Barangay</label>
                            <select class="form-control form-control-border select2-primary " onchange="return $('#sp_barangay').html(''), $(this).removeClass('is-invalid')" data-dropdown-css-class="select2-primary" id = "barangay" name = "barangay" style="width: 100%; text-transform: uppercase">
                            </select>
                            <span style = "color: red" class = "span_error" id = "sp_barangay"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="login-cred" >
                      <h4>Login Credentials</h4>
                      <div class="row">
                        <div class="col-md-6">
                          <button type = "button" class = "button btn btn-sm btn-primary" id = "btn_changepass">Change Login Credentials</button>
                          <button  style = "display: none" type = "button" class = "button btn btn-sm btn-secondary" id = "btn_unchangepass">Unchange Login Credentials</button>
                        </div>
                      </div>
                      <p></p>
                      <div class="row" id = "creden" style = "display: none">
                          <div class="col-md-4">
                            <label for="">Current Password<span style="color:red">*</span></label>
                            <input class="form-control form-control-border select2-primary" type="password" name="prev_pwd" id="prev_pwd" oninput="return $('#sp_prevpwd').html(''), $(this).removeClass('is-invalid')">
                            <span style = "color: red" class = "span_error" id = "sp_prevpwd"></span>
                          </div>
                          <div class="col-md-4">
                            <label for="">New Password<span style="color:red">*</span></label>
                            <input class="form-control form-control-border select2-primary" type="password" name="new_pwd" id="new_pwd" oninput="return $('#sp_newpwd').html(''), $(this).removeClass('is-invalid')">
                            <span style = "color: red" class = "span_error" id = "sp_newpwd"></span>
                          </div>
                          <div class="col-md-4">
                            <label for="">Confirm Password<span style="color:red">*</span></label>
                            <input class="form-control form-control-border select2-primary" type="password" name="con_pwd" id="con_pwd" oninput="return $('#sp_conpwd').html(''), $(this).removeClass('is-invalid')">
                            <span style = "color: red" class = "span_error" id = "sp_conpwd"></span>
                          </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary btn-flat "><i class="fa fa-save"></i>&nbsp;&nbsp; Save changes</button>
                    <button type="button" class="btn btn-danger btn-flat " data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp; Close</button>
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
<!-- jQuery -->
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
<!-- <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script> -->
<script type="text/javascript">
$(document).ready(function() {

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

        populateDropdown($('#region1'), regions);

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
   $(document).ready(function() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-Token':$("input[name=_token").val()
          }
      })
      document.title = "LUGAIT CEMETERY INFORMATION MANAGEMENT SYSTEM (LCIMS)";
       //Initialize Select2 Elements
     $('.select2').select2()

     var populateDropdown = function(element, items) {
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
    var regions = [];
var provinces = [];
var cities = [];
var barangays = [];

$.getJSON('/data/ph.json', function(data) {
    regions = $.map(data, function(region, key) {
        return { code: key, name: region.region_name };
    });
    populateDropdown($('#region'), regions);
    populateDropdown($('#region1'), regions);
    populateDropdown($('#region2'), regions);

    $('#region, #region1, #region2').change(function() {
        var regionCode = $(this).val();
        var targetDropdowns = [$('#province'), $('#province1'), $('#province2')];
        targetDropdowns.forEach(function(element) {
            element.empty().append($('<option>', { value: '', text: '--select--' }));
        });
        if (regionCode) {
            var regionData = data[regionCode];
            if (regionData && regionData.province_list) {
                var provinces = $.map(regionData.province_list, function(province, key) {
                    return { code: key, name: key };
                });
                targetDropdowns.forEach(function(element) {
                    populateDropdown(element, provinces);
                });
            }
        }
    });

    $('#province, #province1, #province2').change(function() {
        var regionCode = $('#region').val();
        var provinceName = $(this).val();
        var targetDropdowns = [$('#city'), $('#city1'), $('#city2')];
        targetDropdowns.forEach(function(element) {
            element.empty().append($('<option>', { value: '', text: '--select--' }));
        });
        if (regionCode && provinceName) {
            var provinceData = data[regionCode].province_list[provinceName];
            if (provinceData && provinceData.municipality_list) {
                var cities = $.map(provinceData.municipality_list, function(municipality, key) {
                    return { code: key, name: key };
                });
                targetDropdowns.forEach(function(element) {
                    populateDropdown(element, cities);
                });
            }
        }
    });

    $('#city, #city1, #city2').change(function() {
        var regionCode = $('#region').val();
        var provinceName = $('#province').val();
        var cityName = $(this).val();
        $('#barangay, #barangay1, #barangay2').empty().append($('<option>', { text: '--select--' }));
        if (regionCode && provinceName && cityName) {
            var barangayList = data[regionCode].province_list[provinceName].municipality_list[cityName].barangay_list;
            if (barangayList) {
                populateDropdown($('#barangay'), barangayList.map(function(barangay) {
                    return { code: barangay, name: barangay };
                }));
            }
        }
    });
});

function display_phlocations() {
    populateDropdown($('#region'), regions);
    populateDropdown($('#region1'), regions);
    populateDropdown($('#region2'), regions);
    populateDropdown($('#province'), provinces);
    populateDropdown($('#province1'), provinces);
    populateDropdown($('#province2'), provinces);
    populateDropdown($('#city'), cities);
    populateDropdown($('#city1'), cities);
    populateDropdown($('#city2'), cities);
    populateDropdown($('#barangay'), barangays);
    populateDropdown($('#barangay1'), barangays);
    populateDropdown($('#barangay2'), barangays);
}

      $("#s_users").addClass('active');
         //DUGAY KAAYO NI GIGANA ABTAN TAG PILA KA ORAS ANI HAHAHA
         function show_datatable()
         {
            $('#users').DataTable({
                ajax: {
                    type: 'get',
                    url: 'api/users',
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
                    {data: "name", name: "name"},
                    {data: 'contactnumber', name: 'contactnumber'},
                    {data: 'email', name: 'email'},
                    {data: 'role', name: 'role'},
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
            RefreshTable('#users', 'api/users');
        }
        show_datatable();
        $("#users").on('click', '#btn_deactivate', function(){
    var id = $(this).data('rowid');
    Swal.fire({
        title: 'Are you sure?',
        text: "Upon deactivation, the user will no longer have access to the system and will be currently locked. Do you want to proceed?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, deactivate user'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'get',
                url: 'users/deactivate/' + id,
                dataType: 'json',
                success: function(resp) {
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Responses',
                        autohide: true,
                        delay: 3000,
                        body: resp.message,
                    });
                    AutoReload();
                }
            })
        }
    })
})

$("#users").on('click', '#btn_activate', function(){
    var id = $(this).data('rowid');
    Swal.fire({
        title: 'Are you sure?',
        text: "Upon activation, the user will have access to the system. Do you want to proceed?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, activate user'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'get',
                url: 'users/activate/' + id,
                dataType: 'json',
                success: function(resp) {
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Responses',
                        autohide: true,
                        delay: 3000,
                        body: resp.message,
                    });
                    AutoReload();
                }
            })
        }
    })
})


        $("#btn_reload").on('click', function(){
          AutoReload();
        })
        $("#btn_changepass").on('click', function(){
          $("#changepass").val("1");
          $("#creden").show();
          $("#role").val("1");
          $("#btn_unchangepass").show();
        })
        $("#btn_unchangepass").on('click', function(){
          $("#changepass").val("0");
          $("#creden").hide();
          $("#role").val("1");
          $("#btn_unchangepass").hide();
        })

        $("#btn_openform").on('click', function(){
          $("#user_form")[0].reset();
          $(".login-cred").hide();
          $("#user_id").val("");
          $("#role").val("");
          $("#address_id").val("");
          $("#changepass").val("");
          $("select").val("");

          $("#address_area1").hide();
          $("#address_area").show();
          $("#btn_unchangeaddress").hide();
          $("#btn_changeaddress").hide();
          $("#modal_form").modal({
              'backdrop': 'static',
              'keyboard': false
          });
          // $('#region').ph_locations('fetch_list');
        })
     
          $('#btn_changeaddress').on('click', function() {
            $("#address_area1").hide();
            $("#address_area").show();
            $("#btn_unchangeaddress").show();
            $("#address_id").val("");
            display_phlocations();
            // $('#region').ph_locations('fetch_list');
        })
   
        $("#btn_unchangeaddress").on('click', function(){
          $("#address_area1").show();
          $("#address_area").hide();
          var address1 = $("#address_id1").val();
          $("#address_id").val(address1);
          $("#btn_unchangeaddress").hide();
        })
        $("#users").on('click', '#btn_edit', function(e){
          e.preventDefault();
          var id = $(this).data('rowid');
          $("#user_id").val(id);
          $("#user_form")[0].reset();
          $("select").html("");
          display_phlocations();

          //Remove invalid error messages of inputs.
          $("#name").removeClass('is-invalid');
          $("#email").removeClass('is-invalid');
          $("#contactnumber").removeClass('is-invalid');
          $("#region").removeClass('is-invalid');
          $("#province").removeClass('is-invalid');
          $("#city").removeClass('is-invalid');
          $("#barangay").removeClass('is-invalid');
          $(".span_error").html("");
          //Show address area
          $("#address_area1").show();
          $("#address_area").hide();
          $("#btn_changeaddress").show();
          $("#btn_unchangeaddress").hide();

          $("#creden").hide();
          $("#btn_unchangepass").hide();
          $(".login-cred").hide();
          $.ajax({
            type:'get',
            url: 'users/show/'+id,
            dataType: 'json',
            success: function(user){
              $("#name").val(user[0].name);
              $("#email").val(user[0].email);
              $("#contactnumber").val(user[0].contactnumber.replace("63", ""));
              $("#address_id").val(user[0].address_id);
              $("#address_id1").val(user[0].address_id);
              
              $("#region1").prepend("<option selected='selected' value = "+user[0].region_no+">"+user[0].region+"</option>");
              $("#province1").prepend("<option selected='selected' value = "+user[0].province_no+">"+user[0].province+"</option>");
              $("#city1").prepend("<option selected='selected' value = "+user[0].city_no+">"+user[0].city+"</option>");
              $("#barangay1").prepend("<option selected='selected' value = "+user[0].barangay_no+">"+user[0].barangay+"</option>");
            
              $("#modal_form").modal({
                  'backdrop': 'static',
                  'keyboard': false
              });
             
            },
            error: function(error){
              console.log("Responding error...")
            }
          })
         
        })
        $("#users").on('click', '#myprofile', function(){
          var id = $(this).data('rowid');
          $("#user_id").val(id);
          $("#user_form")[0].reset();
          $("select").html("");
          $(".login-cred").show();
          $("#role").val("1");
          $("#changepass").val("0");

          //Remove invalid error messages of inputs.
          $("#name").removeClass('is-invalid');
          $("#email").removeClass('is-invalid');
          $("#contactnumber").removeClass('is-invalid');
          $("#region").removeClass('is-invalid');
          $("#province").removeClass('is-invalid');
          $("#city").removeClass('is-invalid');
          $("#barangay").removeClass('is-invalid');
          $(".span_error").html("");
          //Show address area
          $("#address_area1").show();
          $("#address_area").hide();
          $("#btn_changeaddress").show();
          $("#btn_unchangeaddress").hide();

          $.ajax({
            type:'get',
            url: 'users/show/'+id,
            dataType: 'json',
            success: function(user){
              $("#name").val(user[0].name);
              $("#email").val(user[0].email);
              $("#contactnumber").val(user[0].contactnumber.replace("63", ""));
              $("#address_id").val(user[0].address_id);
              $("#address_id1").val(user[0].address_id);
              
              $("#region1").prepend("<option selected='selected' value = "+user[0].region_no+">"+user[0].region+"</option>");
              $("#province1").prepend("<option selected='selected' value = "+user[0].province_no+">"+user[0].province+"</option>");
              $("#city1").prepend("<option selected='selected' value = "+user[0].city_no+">"+user[0].city+"</option>");
              $("#barangay1").prepend("<option selected='selected' value = "+user[0].barangay_no+">"+user[0].barangay+"</option>");
             
              $("#modal_form").modal({
                  'backdrop': 'static',
                  'keyboard': false
              });
            }
          })

        })
        $("#user_form").on('submit', function(e){
          e.preventDefault();
          if($("#user_id").val() != "")
          {
            $.ajax({
              type: 'put',
              url: 'users/update/'+$("#user_id").val(),
              data: {
                name: $("#name").val(),
                email: $("#email").val(),
                contactnumber: $("#contactnumber").val(),
                region: $("#region").val(),
                region_text: $("#region option:selected").text(),
                province: $("#province").val(),
                province_text: $("#province option:selected").text(),
                city: $("#city").val(),
                city_text: $("#city option:selected").text(),
                barangay: $("#barangay").val(),
                barangay_text: $("#barangay option:selected").text(),
                changepass: $("#changepass").val(),
                role: $("#role").val(),
                address_id: $("#address_id").val(),
                curr_pwd: $("#prev_pwd").val(),
                new_pwd: $("#new_pwd").val(),
                con_pwd: $("#con_pwd").val(),
              },
              dataType: 'json',
              success: function(resp){
                if(resp.status == 200)
                {
                  $(document).Toasts('create', {
                      class: 'bg-success',
                      title: 'Responses',
                      autohide: true,
                      delay: 3000,
                      body: resp.messages,
                  })
                  $("#modal_form").modal('hide');
                  $("#user_form")[0].reset();
                  $("select").html();
                  $("input").removeClass('is-invalid');
                  AutoReload();
                }
                else
                {
                  $(document).Toasts('create', {
                      class: 'bg-danger',
                      title: 'Response',
                      autohide: true,
                      delay: 3000,
                      body: "Can't change other's details.",
                  })
                  $.each(resp.messages, function(key, value){
                    if(key == "name")
                    {
                        $("#errmsg_name").text(value);
                        $("#name").addClass('is-invalid');
                    }
                    if(key == "email")
                    {
                        $("#errmsg_email").text(value);
                        $("#email").addClass('is-invalid');
                    }
                    if(key == "contactnumber")
                    {
                        $("#sp_contactnumber").text(value);
                        $("#contactnumber").addClass('is-invalid');
                    }
                    if(key == "region")
                    {
                        $("#sp_region").text(value);
                        $("#region").addClass('is-invalid');
                    }
                    if(key == "province")
                    {
                        $("#sp_province").text(value);
                        $("#province").addClass('is-invalid');
                    }
                    if(key == "city")
                    {
                        $("#sp_city").text(value);
                        $("#city").addClass('is-invalid');
                    }
                    if(key == "barangay")
                    {
                        $("#sp_barangay").text(value);
                        $("#barangay").addClass('is-invalid');
                    }
                    if(key == "curr_pwd")
                    {
                        $("#sp_prevpwd").text(value);
                        $("#prev_pwd").addClass('is-invalid');
                    }
                    if(key == "new_pwd")
                    {
                        $("#sp_newpwd").text(value);
                        $("#new_pwd").addClass('is-invalid');
                    }
                    if(key == "con_pwd")
                    {
                        $("#sp_conpwd").text(value);
                        $("#con_pwd").addClass('is-invalid');
                    }
                  })
                }
              }
          })
          }
          else
          {
            $.ajax({
              type: 'post',
              url: '{{ route("users.store") }}',
              data: {
                address_id: $("#address_id").val(),
                name: $("#name").val(),
                email: $("#email").val(),
                contactnumber: $("#contactnumber").val(),
                region: $("#region").val(),
                region_text: $("#region option:selected").text(),
                province: $("#province").val(),
                province_text: $("#province option:selected").text(),
                city: $("#city").val(),
                city_text: $("#city option:selected").text(),
                barangay: $("#barangay").val(),
                barangay_text: $("#barangay option:selected").text(),
              },
              dataType: 'json',
              success: function(resp){
                if(resp.status == 200)
                {
                  $(document).Toasts('create', {
                      class: 'bg-success',
                      title: 'Responses',
                      autohide: true,
                      delay: 3000,
                      body: resp.messages,
                  })
                  $("#modal_form").modal('hide');
                  $("#user_form")[0].reset();
                  $("select").html();
                  $("input").removeClass('is-invalid');
                  AutoReload();
                }
                else
                {
                  $(document).Toasts('create', {
                      class: 'bg-danger',
                      title: 'Responses',
                      autohide: true,
                      delay: 3000,
                      body: "Check your form.",
                  })
                  $.each(resp.messages, function(key, value){
                    if(key == "name")
                    {
                        $("#errmsg_name").text(value);
                        $("#name").addClass('is-invalid');
                    }
                    if(key == "email")
                    {
                        $("#errmsg_email").text(value);
                        $("#email").addClass('is-invalid');
                    }
                    if(key == "contactnumber")
                    {
                        $("#sp_contactnumber").text(value);
                        $("#contactnumber").addClass('is-invalid');
                    }
                    if(key == "region")
                    {
                        $("#sp_region").text(value);
                        $("#region").addClass('is-invalid');
                    }
                    if(key == "province")
                    {
                        $("#sp_province").text(value);
                        $("#province").addClass('is-invalid');
                    }
                    if(key == "city")
                    {
                        $("#sp_city").text(value);
                        $("#city").addClass('is-invalid');
                    }
                    if(key == "barangay")
                    {
                        $("#sp_barangay").text(value);
                        $("#barangay").addClass('is-invalid');
                    }
                  })
                }
              }
            })
          }
        })
    })
</script>

</body>
</html>
