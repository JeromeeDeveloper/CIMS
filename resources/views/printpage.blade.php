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

  <!-- Navbar -->
  @include('layouts.header')
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')

  <style>
    input[type=text]:focus {
        border: 3px solid #555;
        color: black;
    }
    input[type=number]:focus {
        border: 3px solid #555;
    }
    input[type=text]{
        border-color: 3px solid #555;
    }
  </style>
  @if(Session::get('NotFound'))
    <script>
        alert({{ Session::get('NotFound') }});
    </script>
  @endif
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4>Deceased Print Page <span class = "badge badge-success" id = "no_ofrecords"></span></h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li><a href="#" class = "btn btn-sm btn-flat btn-default">Home</a></li>
              <li><a href="{{ route('deceaseds.index') }}" class = "btn btn-sm btn-flat btn-primary">Deceaseds</a> </li>
              <li> <a href="#" class = "btn btn-sm btn-flat btn-success">Print Page</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div id = "toprint" class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-user"></i> Deceased ID: {{ $data['deceased_info'][0]->deceased_id}}
                    <small class="float-right">Date: {{ now()->format('M-d-Y') }}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                <img src="{{ asset('assets/img/logos/Lugait.png') }}" alt="CIMS LOGO" style = "width: 100px; height: 100px">
                </div>
                <!-- /.col -->
            
                <!-- /.col -->
                <div class="col-sm-8 invoice-col" style = "text-align: right;">
                    Republic of the Philippines<br>
                  <b style = "font-size: 18px">MUNICIPAL ECONOMIC ENTERPRISE AND DEVELOPMENT</b><br>
                  LUGAIT CEMETERY ENTERPRISE<br>
                  9025, Lugait, Misamis Oriental<br>
                  Tel.No. (063)225-6170
                </div>
                <!-- /.col -->
              </div>
              <br>
              <!-- /.row -->
              <div class="row">
                <div class="col-12">
                    <div class="row invoice-info" style = "text-align: center; font-weight: bold; font-style: italic">
                        <div class="col-sm-12 invoice-col">
                            <h3 style = "font-family: Helvetica">CEMETERY FORM</h3>
                        </div>
                    </div>
                </div>
              </div>
                <br><br>
              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                    <style>
                        h5{
                            font-size: 17px;
                            text-transform: uppercase;
                        }
                        input[type='checkbox']{
                            width: 28px;
                            height: 28px;
                        }
                    </style>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group row">
                                <h5 class="col-sm-5"> NAME OF DECEASED: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">{{$data['deceased_info'][0]->firstname.' '.$data['deceased_info'][0]->middlename.' '.$data['deceased_info'][0]->lastname}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group row">
                                <h5 class="col-sm-5">DATE OF DEATH: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">{{$data['deceased_info'][0]->dateof_death}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group row">
                                <h5 class="col-sm-5">SEX: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">{{$data['deceased_info'][0]->sex}} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group row">
                                <h5 class="col-sm-2"> AGE: </h5>
                                <div class="col-sm-10" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold;">{{\Carbon\Carbon::parse($data['deceased_info'][0]->dateofbirth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days');}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group row">
                                <h5 class="col-sm-5">STATUS: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    @if($data['deceased_info'][0]->civilstatus == "W")
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">WIDOWED</h5>
                                    @endif
                                    @if($data['deceased_info'][0]->civilstatus == "D")
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">DIVORCED</h5>
                                    @endif
                                    @if($data['deceased_info'][0]->civilstatus == "M")
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">MARRIED</h5>
                                    @endif
                                    @if($data['deceased_info'][0]->civilstatus == "S")
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">SINGLE</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group row">
                                <h5 class="col-sm-5"> DATE OF BURIAL: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold;">{{$data['deceased_info'][0]->dateof_burial}} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group row">
                                <h5 class="col-sm-2"> ADDRESS: </h5>
                                <div class="col-sm-10" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold;">{{$data['deceased_info'][0]->barangay.", ".$data['deceased_info'][0]->city.", ".$data['deceased_info'][0]->province}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group row">
                                <h5 class="col-sm-5">DAY: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold; text-transform: uppercase">{{\Carbon\Carbon::createFromFormat('Y-m-d', $data['deceased_info'][0]->dateof_burial)->format('l');}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group row">
                                <h5 class="col-sm-5">TIME: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">{{date('h:i A', strtotime($data['deceased_info'][0]->burial_time))}} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <h5 style = "font-weight: bold; "><u> SPACE / AREA / BLOCKS: </u></h5>
                            <ul>
                                <?php $space_area = "";?>
                                @foreach($data['blocks'] as $b)
                                    @if($b['isPlotted'] == 1)
                                        <?php $space_area = $b['section_name']; ?>
                                        <div class="form-group row">
                                            <div class="col-sm-1" style = "text-align: center">
                                                <input disabled type = "checkbox" checked class = "form-control"></input>
                                            </div>
                                            @if($data['deceased_info'][0]->remaining_balance == 0)
                                            <h5 class="col-sm-11">{{ $b['section_name'] }} <i style = "color: blue">PAID {{$b['block_cost']}}</i> </h5>
                                            @endif
                                            @if($data['deceased_info'][0]->remaining_balance != 0)
                                            <h5 class="col-sm-11">{{ $b['section_name'] }} <i style = "color: red">PARTIAL {{$data['deceased_info'][0]->remaining_balance}} </i> </h5>
                                            @endif
                                        </div>
                                    @endif
                                    @if($b['isPlotted'] == 0)
                                        <div class="form-group row">
                                            <div class="col-sm-1" style = "text-align: center">
                                                <input disabled type = "checkbox" class = "form-control"></input>
                                            </div>
                                            <h5 class="col-sm-11">{{ $b['section_name'] }}</h5>
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-5">
                            <h5 style = "font-weight: bold; "><u> SERVICES: </u></h5>
                            <ul>
                                @foreach($data['services'] as $s)
                                    @if($s['is_selected'] == 1)
                                        <div class="form-group row">
                                            <div class="col-sm-1" style = "text-align: center">
                                                <input disabled type = "checkbox"  class = "form-control" checked></input>
                                            </div>
                                            <h5 class="col-sm-11">{{ $s['service_name'] }}</h5>
                                        </div>
                                    @endif
                                    @if($s['is_selected'] == 0)
                                        <div class="form-group row">
                                            <div class="col-sm-1" style = "text-align: center">
                                                <input disabled type = "checkbox" class = "form-control"></input>
                                            </div>
                                            <h5 class="col-sm-11">{{ $s['service_name'] }}</h5>
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <?php $i = 1;?>
                        @foreach($data['contactpeople'] as $cp)
                            <div class="col-7">
                                <div class="form-group row">
                                    <h5 class="col-sm-4"> CONTACT PERSON {{$i}} :  </h5>
                                    <div class="col-sm-8" style = "text-align: center">
                                        <h5 style = "border-bottom: 1px solid black; font-weight: bold;">{{$cp->name}} </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group row">
                                    <h5 class="col-sm-4"> RELATIONSHIP :  </h5>
                                    <div class="col-sm-8" style = "text-align: center">
                                        @if($cp->relationshipthdeceased == 1)
                                         <h5 style = "border-bottom: 1px solid black; font-weight: bold;">SIBLING </h5>
                                        @endif
                                        @if($cp->relationshipthdeceased == 2)
                                         <h5 style = "border-bottom: 1px solid black; font-weight: bold;">COUSIN</h5>
                                        @endif
                                        @if($cp->relationshipthdeceased == 3)
                                         <h5 style = "border-bottom: 1px solid black; font-weight: bold;">PARENT </h5>
                                        @endif
                                        @if($cp->relationshipthdeceased == 4)
                                         <h5 style = "border-bottom: 1px solid black; font-weight: bold;">CHILDREN</h5>
                                        @endif
                                        @if($cp->relationshipthdeceased == 5)
                                         <h5 style = "border-bottom: 1px solid black; font-weight: bold;">SPOUSE</h5>
                                        @endif
                                        @if($cp->relationshipthdeceased == 6)
                                         <h5 style = "border-bottom: 1px solid black; font-weight: bold;">OTHER</h5>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group row">
                                    <h5 class="col-sm-2"> ADDRESS:  </h5>
                                    <div class="col-sm-10" style = "text-align: center">
                                        <h5 style = "border-bottom: 1px solid black; font-weight: bold;">{{$cp->barangay.", ".$cp->city.", ".$cp->province}} </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group row">
                                    <h5 class="col-sm-5"> CONTACT NO :  </h5>
                                    <div class="col-sm-7" style = "text-align: center">
                                        <h5 style = "border-bottom: 1px solid black; font-weight: bold;">{{$cp->contactnumber}} </h5>
                                    </div>
                                </div>
                            </div>
                            <?php $i++ ?>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group row">
                                <h5 class="col-sm-12" style = "border-bottom: 1px solid black"></h5>
                                <h5 class="col-sm-12" style = "text-align: center; text-transform: none">Name & Signature of Contact Person or any Family Representative</h5>
                                
                            </div>
                        </div>
                        <div class="col-3">

                        </div>
                        <div class="col-4">
                            <h5 style = "text-transform: none">Approved By:</h5>
                            <div class="form-group row">
                                <h5 class="col-sm-12" ></h5> 
                                <!-- <h5 class="col-sm-12"><hr></h5>  -->
                                <h5 class="col-sm-12" style = "font-weight: bold; text-align: center ">DR. PATRICIO P. PARAMI, JR.</h5> 
                                <h5 class="col-sm-12" style = "text-align: center; text-transform: none">MEEDO/Cemetery In-Charge</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group row">
                                <h5 class="col-sm-12" style = "border-bottom: 1px solid black"></h5>
                                <h5 class="col-sm-12" style = "text-align: center; text-transform: none">(NOTE TO BE FILLED-UP BY MEEDO)</h5>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                         
                        </div>
                        <div class="col-11">
                            <h5><b>AMOUNT TO BE PAID AT MUNICIPAL TREASURER'S OFFICE</b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                        </div>
                        <div class="col-11">
                            <ul>
                                <li>
                                    <div class="form-group row">
                                        <h5 class="col-sm-2" style = "text-transform: none">Burial Permit Fee: </h5>
                                        <h5 class="col-sm-2" style = "text-transform: none; text-align: center; border-bottom: 1px solid black; font-weight: bold">P 150</h5>
                                        <h5 class="col-sm-2" style = "text-transform: none">OR# : </h5>
                                        <h5 class="col-sm-2" style = "text-transform: none; text-align: center; border-bottom: 1px solid black; font-weight: bold"></h5>
                                        <h5 class="col-sm-2" style = "text-transform: none">Date: </h5>
                                        <h5 class="col-sm-2" style = "text-transform: none; text-align: center; border-bottom: 1px solid black; font-weight: bold"></h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12" style = "text-align: center">
                            <div class="form-group row">
                                <h5 class="col-sm-6" style = "text-transform: none">x x x x x x x x x x x x x x x x x x x x x x x x x x x x x x x x </h5>
                                <h5 class="col-sm-6" style = "text-transform: none">x x x x x x x x x x x x x x x x x x x x x x x x x x x x x x x x</h5>
                            </div>
                            <div class="form-group row">
                                <h3 class = "col-sm-12" style = "font-family: Helvetica; font-style: italic;">CEMETERY GATE PASS</h3>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <div class="form-group row">
                                <h5 class="col-sm-4"> NAME OF DECEASED: </h5>
                                <div class="col-sm-8" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">{{$data['deceased_info'][0]->firstname.' '.$data['deceased_info'][0]->middlename.' '.$data['deceased_info'][0]->lastname}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group row">
                                <h5 class="col-sm-5">DATE OF BURIAL: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">{{$data['deceased_info'][0]->dateof_burial}} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group row">
                                <h5 class="col-sm-2"> ADDRESS: </h5>
                                <div class="col-sm-10" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold;">{{$data['deceased_info'][0]->barangay.", ".$data['deceased_info'][0]->city.", ".$data['deceased_info'][0]->province}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group row">
                                <h5 class="col-sm-5">DAY: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold; text-transform: uppercase">{{\Carbon\Carbon::createFromFormat('Y-m-d', $data['deceased_info'][0]->dateof_burial)->format('l');}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group row">
                                <h5 class="col-sm-5">TIME: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold">{{date('h:i A', strtotime($data['deceased_info'][0]->burial_time))}} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group row">
                                <h5 class="col-sm-3">SPACE AREA: </h5>
                                <div class="col-sm-9" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold;">{{$space_area == null ? "FOR ALLOCATION": $space_area}} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group row">
                                <h5 class="col-sm-5">CONTACT PERSON: </h5>
                                <div class="col-sm-7" style = "text-align: center">
                                    <h5 style = "border-bottom: 1px solid black; font-weight: bold; text-transform: uppercase">{{$data['contactpeople'] == null? "NONE": $data['contactpeople'][0]->name }} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <div class="col-6 float-right">
                            <h5 style = "text-transform: none">By: </h5>
                            <div class="form-group row">
                                <h5 class="col-sm-12"><b>LOCAL GOVERNMENT UNIT OF LUGAIT</b></h5>
                               
                            </div>
                            <div class="form-group row">
                                <h5 class="col-sm-4"><img src="{{ asset('assets/img/logos/Lugait.png') }}" alt="CIMS LOGO" style = "width: 100px; height: 100px"></h5>
                                <div class="col-sm-8">
                                    <table>
                                        <thead style = "font-size: 18px">
                                            <tr>
                                                <th>DR. PATRICIO P. PARAMI, JR</th>
                                            </tr>
                                            <tr>
                                                <td> MEEDO/Cemetery In-Charge</td>
                                            </tr>
                                            <tr>
                                                <td> Tel. No.: (063) 225-6170</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                
              </div>
              <!-- /.row -->
                        <br>
              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a onclick="window.print()" rel="noopener" target="_blank" class="btn btn-block btn-danger float-right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</a> 
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <div class="row no-print">
  <!-- Main Footer -->
  @include('layouts.footer')
  </div>    
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
@include('references.scripts')
<script>
    $("#s_deceaseds").addClass('active');
</script>
</body>
</html>
