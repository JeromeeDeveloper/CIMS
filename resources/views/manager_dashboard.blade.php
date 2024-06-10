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
  <div class="preloader flex-column justify-content-center align-items-center" >
    <img class="animation__shake" src="{{ asset('dist/img/logolugait.png')}}" alt="AdminLTELogo" height="60" width="60">
    <p>Please wait ... </p>
  </div>
  <!-- Navbar -->
  @include('layouts.header')
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  @include('layouts.sidebar')
<style>
  .info-box-text{
    font-weight: bold;
   
  }
  .info-box-number{
    font-size: 25px;
  }
</style>
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2" style = " background-color: #0A1931; color: #F8F0E5; ">
          <div class="col-sm-12">
            <div class="card-header" >
              <div class="text-center">
                <h1 style="font-family: monospace; font-weight: bold; text-transform: uppercase; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ asset('/assets/img/logos/Lugait.png') }}" alt="Lugait Icon" width="50" height="50" style="margin-right: 10px;">
                    Welcome to Lugait Cemetery Electronic Information Management System
                    <img src="{{ asset('/assets/img/logos/Lugait.png') }}" alt="Lugait Icon" width="50" height="50" style="margin-left: 10px;">
                </h1>
            </div>
            
              </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
         

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><a href="{{route('deceaseds.index')}}"><i class="fas fa-skull"></i></a></span>

              <div class="info-box-content">
                <span class="info-box-text">Total No. of Deceaseds (Burried)</span>
                <span class="info-box-number">
                  {{ $counts['deceasedtotal'] }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"> <a data-id = "{{ Auth::user()->role }}" id = "_forApproval" type="button"><i class="fas fa-thumbs-up"></i></a></span>

              <div class="info-box-content">
                <span class="info-box-text">Burial Requests</span> 
                <span class="info-box-number"id = "dh_forApproval"> </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><a href="{{ route('deceaseds.index') }}"><i class="fas fa fa-bed"></i></a></span>

              <div class="info-box-content">
                <span class="info-box-text">Deceased for Burial / To Plot</span>
                <span class="info-box-number"> {{ $counts['forBurial'] }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hourglass-half"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Burial Records(Notified)</span>
                <span class="info-box-number" id = "dh_nm"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0" style = "background-color: #0A1931; color: white">
                <div class="d-flex justify-content-between" >
                  <h3 class="card-title">Death by Year</h3>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                  <span style="font-weight: bold; font-size: 18px;">Total No. of Deceaseds: {{ $no_ofdeceaseds }}</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="deathbyyears_chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">

                
                  <!-- <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Year deceased died
                  </span> -->
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>


          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0" style = "background-color: #0A1931; color: white">
                <div class="d-flex justify-content-between" >
                  <h3 class="card-title">Deceased by Age</h3>
                 
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span style="font-weight: bold; font-size: 18px;">Recently added deceased: {{ $recent_deceased->firstname }} {{ $recent_deceased->middlename }} {{ $recent_deceased->lastname }}</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="ageofdeceased_chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <!-- <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Age of deceased
                  </span> -->
                
                </div>
              </div>
              
            </div>
            <!-- /.card -->
        
          </div>
          <div class="col-lg-12">
    <div class="card">
      <div class="card-header" style="background-color: #0A1931; color: white;">
        <h3 class="card-title">Deceased Statistics</h3>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas id="deceasedChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
      </div>
    </div>
  </div>

          <div class="col-lg-12">
            <div class="card card-warning">
                <div class="card-header" style="background-color: #0A1931; color: white;">
                    <h5>Deceased for Approval</h5>
                </div>
              
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
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
  $("#_forApproval").on('click', function(){
    var role = $(this).data('id');
    if(role == 1) 
    {
      window.location.href="{{ route('deceaseds.forApproval') }}"
    }
    else
{
    Swal.fire({
        icon: 'error',
        title: 'Access Denied',
        text: 'You do not have permission to access this page!',
        confirmButtonText: 'OK'
    });
}

  })
</script>
<script>
  $(document).ready(function(){
    'use strict'
    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold',
    }

    var mode = 'index'
    var intersect = true
    var years_ofdeads = {{Js::From($deaths_label)}};
    var deaths_values = {{Js::From($deaths_values)}};
    var salesChart = $('#deathbyyears_chart')
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart(salesChart, {
      type: 'bar',
      data: {
        labels: years_ofdeads,
        datasets: [
          {
            backgroundColor: '#9E6F21',
            borderColor: '#007bff',
            data: deaths_values,
          },
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false,
        },
        scales: {
          yAxes: [{
            display: true,
            gridLines: {
              display: true,
              // lineWidth: '4px',
              // color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            scaleLabel: {
              display: true,
              labelString: 'No. of Deceaseds'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function (value) {
                if (value >= 1000) {
                  value /= 1000
                  value += ''
                }

                return value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle,
            scaleLabel: {
              display: true,
              labelString: 'Year Died'
            },
          }]
        }
      }
    })
  })
</script>

<!-- Age of deceased chart presentation-->
<script>
  $(document).ready(function(){
    'use strict'
    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold',
    }

    var mode = 'index'
    var intersect = true
    var dateofbirth_label = {{Js::From($dateofbirth_label)}};
    var dateofbirth_values = {{Js::From($dateofbirth_values)}};
    var salesChart = $('#ageofdeceased_chart')
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart(salesChart, {
      type: 'bar',
      data: {
        labels: dateofbirth_label,
        datasets: [
          {
            backgroundColor: '#9E6F21',
            borderColor: '#007bff',
            data: dateofbirth_values,
          },
        ] 
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            display: true,
            gridLines: {
              display: true,
              // lineWidth: '4px',
              // color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            scaleLabel: {
              display: true,
              labelString: 'No. of Deceaseds'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function (value) {
                if (value >= 1000) {
                  value /= 1000
                  value += ''
                }

                return value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: true
            },
            ticks: ticksStyle,
            scaleLabel: {
              display: true,
              labelString: 'Age of  the Deceaseds'
            },
          }]
        }
      }
    })
  })
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#s_dashboard").addClass('active');
  })
</script>
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (https://fullcalendar.io/docs/event-object)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }


    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;

    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------
    var schedules_data = {{Js::From($schedules_data)}};
    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left  : 'prev,next today',
        center: 'title',
        right : 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      
      
      themeSystem: 'bootstrap',
      //Random default events
      events: schedules_data,
      editable  : false,
      droppable :false, // this allows things to be dropped onto the calendar !!!
    });
    $("#viewAllYearsBtn").on('click', function() {
  calendar.changeView('dayGridYear'); // Switch to year view
});

    calendar.render();
   

  
    // $('#calendar').fullCalendar()
  })

  var deceasedChartCanvas = $('#deceasedChart').get(0).getContext('2d');
    var deceasedData = {
      labels: ['Today', 'This Week', 'This Month', 'This Year'],
      datasets: [{
        label: 'Deceased',
        backgroundColor: '#9E6F21',
        borderColor: '#007bff',
        data: [
          {{ $no_ofdeceaseds_today }},
          {{ $no_ofdeceaseds_week }},
          {{ $no_ofdeceaseds_month }},
          {{ $no_ofdeceaseds_year }}
        ],
      }]
    };

    var deceasedChart = new Chart(deceasedChartCanvas, {
      type: 'bar',
      data: deceasedData,
      options: {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines: {
              display: true,
            },
            ticks: {
              fontColor: '#495057',
              fontStyle: 'bold',
            },
          }],
          yAxes: [{
            gridLines: {
              display: true,
            },
            ticks: {
              beginAtZero: true,
              suggestedMax: 10,
              fontColor: '#495057',
              fontStyle: 'bold',
            },
          }]
        }
      }
    });
</script>
</body>
</html>
