<!DOCTYPE html>
<html lang="en">

<head>
    @include('references.links')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zooming/1.6.3/zooming.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">


        @include('layouts.header')

        @include('layouts.sidebar')

        <style>
            input[type=text]:focus {
                border: 3px solid #555;
                color: black;
            }

            input[type=number]:focus {
                border: 3px solid #555;
            }

            input[type=text] {
                border-color: 3px solid #555;
            }
        </style>
        <style>
            .fullsize {
                border: 2px solid rgb(5, 17, 63);
                z-index: 999;
                cursor: zoom-out;
                display: block;
                width: 800px;
                max-width: 800px;
                height: 800px;
                position: fixed;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                transition: transform 0.5s;
            }

            .original-size {
                max-width: 200%;
                max-height: 200%;
            }
       
    #tbl_spaceAreas_filter label {
    display: none;
  }

     
        </style>
        @if (Session::get('NotFound'))
            <script>
                alert({{ Session::get('NotFound') }});
            </script>
        @endif

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4>Space Areas </h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Space Areas</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="form-group row">
              {{ csrf_field() }}
              <div class="col-sm-6 d-flex align-items-center">
                <button class="btn btn-default btn-flat" id="btn_openform">
                  <i class="fas fa-cube"></i> &nbsp;&nbsp; Add Block
                </button>
                <button id="btn_reload" class="btn btn-primary btn-flat">
                  <i class="fas fa-sync"></i> &nbsp;&nbsp; Reload Table
                </button>
              </div>
              <div class="col-sm-6 d-flex justify-content-end align-items-center">
                <div id="export_buttons">
                  <!-- Export buttons content here -->
                </div>
                <div class="input-group" style="max-width: 300px; margin-left: 10px;">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                  </div>
                  <input type="text" class="form-control is-primary" style="text-transform: uppercase" placeholder="Search Record Here" id="search">
                </div>
              </div>
            </div>
          </div>
          <style>
            table,
            td,
            th {
              border: 1px solid #0A1931;
            }
          </style>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tbl_spaceAreas" class="table responsive">
              <thead style="background-color: #0A1931; color: white">
                <tr align="center">
                  <th>Image</th>
                  <th>Section Name</th>
                  <th>Slot / Vacancy</th>
                  <th>Section Cost</th>
                  <th>Years of Validity</th>
                  <th style="text-align: center">Action</th>
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

        <!-- Space Area Modal -->
        <div class="modal fade" id="modal_form">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style = "background-color: #0A1931; color: white">
                        <h4 class="modal-title">
                            <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 50px; height: 50px"
                                alt="">
                            Space Area Form
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" id = "block_form" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="text" style = "display: none" name="type" id = "type" value = "">
                            <div class="row">
                                <input type="hidden" name = "block_id" id = "block_id" value = "">
                                <div class="col-md-6">
                                    <label for="">Section Name <span style="color:red">*</span></label>
                                    <input type="text" style = "text-transform: uppercase" name="section_name"
                                        id="section_name" class="form-control form-control-border border-width-3"
                                        autocomplete = "off">
                                    <span class = "span_error" style ="color:red; font-size: 12px"
                                        id = "errmsg_sectionname"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Slot / Vacancy<span style="color:red">*</span></label>
                                    <input type="number" style = "text-transform: uppercase" name="slot"
                                        id="slot" class="form-control form-control-border border-width-3"
                                        autocomplete = "off">
                                    <span class = "span_error" style ="color:red; font-size: 12px"
                                        id = "errmsg_blocknumber"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Section Cost <span style="color:red">*</span></label>
                                    <input type="number"
                                        style = "font-size: 25px; text-transform: uppercase; text-align: right;"
                                        name="block_cost" id="block_cost"
                                        class="form-control form-control-border border-width-3" autocomplete = "off">
                                    <span class = "span_error" style ="color:red; font-size: 12px"
                                        id = "errmsg_blockcost"></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Validity</label>
                                    <input type="number"
                                        style = "font-size: 25px; text-transform: uppercase; text-align: right;"
                                        name="validity" id="validity"
                                        class="form-control form-control-border border-width-3" autocomplete = "off">
                                    <span class = "span_error" style ="color:red; font-size: 12px"
                                        id = "errmsg_validity"></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Image<span style="color:red"></span></label>
                                    <img style = "width: 200px; height: 200px; border: 1px solid;" src=""
                                        alt="preview_image" id = "preview_image">
                                    <span class = "span_error" style ="color:red; font-size: 12px"
                                        id = "errmsg_image"></span>
                                    <input type="file" value = "" name="image" id="image"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary btn-flat btn-block">Save changes</button>
                            <button type="button" class="btn btn-danger btn-flat btn-block" data-dismiss="modal">X
                                Close</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="slot_modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style = "background-color: #0A1931; color: white;">
                        <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 50px; height: 50px"
                            alt="">
                        <h6 class="modal-title" style = "font-weight: bold">
                            ADJUST SECTION SLOT</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" id = "slot_form" method="post">
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name = "_block_id" id = "_block_id" value = "">
                                <h5 style = "font-size: 12px; color: green">Note: <i> Just put a negative sign to
                                        decrease the slot</i></h5>
                                <div class="col-md-12">
                                    <label for="">ADJUST (<span
                                            style = "color: green; font-size: 15px;">+</span> <span
                                            style = "color: red; font-size: 15px;">-</span>)</label>
                                    <input type="number" value = "0"
                                        style = "font-size: 25px; text-transform: uppercase; text-align: right;"
                                        name="_slot" id="_slot"
                                        class="form-control form-control-border border-width-3" autocomplete = "off">
                                    <span style ="color:red; font-size: 12px" id = "errmsg_slot"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary btn-block btn-sm">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>


        <!-- Manage Deceased By Space Area -->
        <div class="modal fade" id="modal_form">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style = "background-color: #0A1931; color: white">
                        <h4 class="modal-title">
                            <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 50px; height: 50px"
                                alt="">
                            Space Area Form
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" id = "block_form" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="text" style = "display: none" name="type" id = "type"
                                value = "">
                            <div class="row">
                                <input type="hidden" name = "block_id" id = "block_id" value = "">
                                <div class="col-md-6">
                                    <label for="">Section Name <span style="color:red">*</span></label>
                                    <input type="text" style = "text-transform: uppercase" name="section_name"
                                        id="section_name" class="form-control form-control-border border-width-3"
                                        autocomplete = "off">
                                    <span class = "span_error" style ="color:red; font-size: 12px"
                                        id = "errmsg_sectionname"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Slot / Vacancy<span style="color:red">*</span></label>
                                    <input type="number" style = "text-transform: uppercase" name="slot"
                                        id="slot" class="form-control form-control-border border-width-3"
                                        autocomplete = "off">
                                    <span class = "span_error" style ="color:red; font-size: 12px"
                                        id = "errmsg_blocknumber"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Section Cost <span style="color:red">*</span></label>
                                    <input type="number"
                                        style = "font-size: 25px; text-transform: uppercase; text-align: right;"
                                        name="block_cost" id="block_cost"
                                        class="form-control form-control-border border-width-3" autocomplete = "off">
                                    <span class = "span_error" style ="color:red; font-size: 12px"
                                        id = "errmsg_blockcost"></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Validity<span style="color:red">*</span></label>
                                    <input type="number"
                                        style = "font-size: 25px; text-transform: uppercase; text-align: right;"
                                        name="validity" id="validity"
                                        class="form-control form-control-border border-width-3" autocomplete = "off">
                                    <span class = "span_error" style ="color:red; font-size: 12px"
                                        id = "errmsg_validity"></span>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Image<span style="color:red"></span></label>
                                    <img style = "width: 200px; height: 200px; border: 1px solid;" src=""
                                        alt="preview_image" id = "preview_image">
                                    <span class = "span_error" style ="color:red; font-size: 12px"
                                        id = "errmsg_image"></span>
                                    <input type="file" value = "" name="image" id="image"
                                        class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary btn-flat btn-block">Save changes</button>
                            <button type="button" class="btn btn-danger btn-flat btn-block" data-dismiss="modal">X
                                Close</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="managedeceased_modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style = "background-color: #0A1931; color: white;">
                        <img src="{{ asset('assets/img/logos/Lugait.png') }}" style = "width: 50px; height: 50px"
                            alt="">
                        <h6 id = "_md_modalTitle" class="modal-title" style = "font-weight: bold">
                            Manage Deceased In this Block</h6> <br>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <ul id = "error_messages" style = "color: red">

                    </ul>
                    <form action="" method = "post" id = "m_form">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="hidden" value = "" id = "_blockID">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Service Here</label>
                                        <div class="select2-danger">
                                            <select id = "s_services" class="select2 s_services"
                                                data-placeholder="Select a service here" data-
                                                dropdown-css-class="select2-danger" style="width: 100%;">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Search Deceased Here</label>
                                        <div>
                                            <input type="text" class = "form-control" id = "_searchD">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label for="mCheckAll" class = "col-sm-4">Check All Deceaseds</label>
                                        <div class="col-sm-6">
                                            <input type="checkbox" name="mCheckAll" id="mCheckAll">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class = "btn btn-primary btn-flat" type="submit"
                                        id = "btn_submitDeceased"><i class = "fas fa fa-save"></i>&nbsp; Submit
                                    </button>
                                </div>
                                <div class="col-md-12">
                                    <table id = "_deceaseds" class = "table table-hovered table-stripped">
                                        <thead class = "table table-primary">
                                            <tr>
                                                <th>Name</th>
                                                <th class = "text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">

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
    <script>
        $(function() {
            $(".select2").select2();
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        });
    </script>
    <script>
        document.getElementById('img_rip2').addEventListener('click', function() {
  // Toggle zoom class
  this.classList.toggle('zoom2');
});

    </script>
<script>
    // Variable to store the currently zoomed image
    var currentZoomedImg = null;

    // Function to handle zooming when the image is clicked
    function zoomImage(img) {
        // Check if this image is already zoomed
        if (img.classList.contains("zoomed")) {
            // If already zoomed, remove the "zoomed" class
            img.classList.remove("zoomed");
            // Set the currentZoomedImg variable to null
            currentZoomedImg = null;
        } else {
            // Remove the "zoomed" class from the previously zoomed image (if any)
            if (currentZoomedImg) {
                currentZoomedImg.classList.remove("zoomed");
            }
            // Add the "zoomed" class to the clicked image
            img.classList.add("zoomed");
            // Set the currentZoomedImg variable to the clicked image
            currentZoomedImg = img;
            // Ensure the zoomed image is visible within the viewport
            img.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // Add event listener for click events on the document
    document.addEventListener("click", function(event) {
        // Check if the clicked element is not an image or the currently zoomed image
        if (!event.target.classList.contains("zoomed") && event.target.tagName !== "IMG") {
            // Remove the "zoomed" class from the currently zoomed image (if any)
            if (currentZoomedImg) {
                currentZoomedImg.classList.remove("zoomed");
                currentZoomedImg = null;
            }
        }
    });

    // Variable to store the last scroll position
    var lastScrollTop = 0;

    // Add event listener for scroll events on the window
    window.addEventListener("scroll", function() {
        // Get the current scroll position
        var currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Check if the scroll direction is upwards or downwards
        if (currentScrollTop > lastScrollTop || currentScrollTop < lastScrollTop) {
            // Remove the "zoomed" class from the currently zoomed image (if any)
            if (currentZoomedImg) {
                currentZoomedImg.classList.remove("zoomed");
                currentZoomedImg = null;
            }
        }

        // Update the last scroll position
        lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
    });
</script>

<style>
    .zoomed_image {
        max-width: 150px; /* Limit the maximum width of the image */
        max-height: 150px; /* Limit the maximum height of the image */
    }

    .zoomed {
        border: 2px solid rgb(138, 2, 131);
        z-index: 999;
        cursor: zoom-out;
        display: block;
        max-width: 90vw; /* Limit the maximum width of the zoomed image */
        max-height: 90vh; /* Limit the maximum height of the zoomed image */
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        transition: transform 0.5s;
    }
</style>


    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });

            var isZoomed = {};
            var currentZoomedImage;

            $("#tbl_spaceAreas tbody").on('click', '.bimage', function(e) {
                e.preventDefault();


                if (this === currentZoomedImage) {
                    this.classList.remove("fullsize");
                    currentZoomedImage = null;
                } else {

                    if (currentZoomedImage) {
                        currentZoomedImage.classList.remove("fullsize");
                    }


                    toggleSize(this);
                    currentZoomedImage = this;

                    var imageId = $(this).data('id');
                    isZoomed[imageId] = true;
                }
            });

            document.addEventListener("wheel", function(event) {

                $(".bimage.fullsize").each(function(index, element) {
                    element.classList.remove("fullsize");
                });


                currentZoomedImage = null;
            });

            document.addEventListener("click", function(event) {
                if (currentZoomedImage && !$(event.target).hasClass("fullsize")) {

                    currentZoomedImage.classList.remove("fullsize");
                    currentZoomedImage = null;
                }
            });

            function toggleSize(element) {
                element.classList.toggle("fullsize");
            }
            document.title = "LUGAIT CEMETERY SPACE AREAS";
            show_datatable();
            //DUGAY KAAYO NI GIGANA ABTAN TAG PILA KA ORAS ANI HAHAHA
            function show_datatable() {
                $('#tbl_spaceAreas').DataTable({
                    ajax: {
                        type: 'get',
                        url: '{{ route('blocks.all_dataByDatatable') }}',
                        dataType: 'json',
                    },
                    serverSide: true,
                    processing: true,
                    columnDefs: [{
                        className: "text-center", // Add 'text-center' class to the targeted column
                        targets: [0, 2, 3, 4,
                            5
                        ] // Replace 'columnIndex' with the index of your targeted column (starting from 0)
                    }],
                    dom: 'lBfrtip',
                    buttons: [
                        'length',
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [1, 2, 3] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-primary',
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [1, 2, 3] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-danger',
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: [1, 2, 3] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-warning',
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [1, 2, 3] // Set columns 0, 2, and 3 for export
                            },
                            className: 'btn btn-success',
                        },
                    ],
                    initComplete: function() {
                        this.api().buttons().container().appendTo('#export_buttons');
                    },
                    columns: [{
                            data: "image",
                            name: "image"
                        },
                        {
                            data: 'block_name',
                            name: 'block_name'
                        },
                        {
                            data: 'slot',
                            name: 'slot'
                        },
                        {
                            data: 'cost',
                            name: 'cost'
                        },
                        {
                            data: 'validity',
                            name: 'validity'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
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

            function AutoReload() {
                RefreshTable('#tbl_spaceAreas', '{{ route('blocks.all_dataByDatatable') }}');
            }

            var _token = $('input[name="_token"]').val();
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#tbl_spaceAreas tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#_searchD").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#_deceaseds tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $("#s_spaceareas").addClass('active');
            $("#_slot").on('change', function() {
                $(this).number(true, 2);
            })
            $("#btn_reload").on('click', function() {
                AutoReload();
            })
            $("#m_form").on('submit', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure you want to proceed?',
        text: 'Note: Please check the data before submission as this action cannot be undone!',
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
            if ($("input.mCheck:checked").prop("checked") == true) {
                var checkedData = [];

                $("#_deceaseds input.mCheck:checked").each(function() {
                    var deceased_id = $(this).val();
                    checkedData.push(deceased_id);
                });

                var block_id = $("#_blockID").val();
                var service_id = $(".s_services").val();

                $.ajax({
                    type: 'post',
                    url: '{{ route('spaceareas.submitdeceased') }}',
                    data: {
                        deceaseds: checkedData,
                        service_id: service_id,
                        block_id: block_id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 1) {
                            $("#mCheckAll").prop('checked', false);
                            $("#_deceaseds input.mCheck:checkbox").prop('checked', false);
                            $(".s_services").val("").trigger('change');
                            AutoReload();
                            Swal.fire('Success', response.message, 'success');
                        } else if (response.status == 2) {
                            $("#error_messages").html();
                            $.each(response.message, function(key, value) {
                                $("#error_messages").append("<li>" + value + "</li>").fadeOut(5000);
                            });
                        } else {
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Responses',
                                autohide: true,
                                delay: 3000,
                                body: "Please check your data, transaction cannot process.",
                            });
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    }
                });
            } else {
                Swal.fire('Warning', 'Please select a deceased!', 'warning');
            }
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info');
        }
    })
})


            $("#mCheckAll").click(function() {
                if ($(this).prop('checked') == true) {
                    $(":checkbox").prop('checked', true);
                } else {
                    $(":checkbox").prop('checked', false);
                }
            });
            $("#tbl_spaceAreas tbody").on('click', '#btn_manage', function() {
                var id = $(this).data('id');
                $("#m_form")[0].reset();
                $(".s_services").html();
                $(".s_deceaseds").html();
                $("#_blockID").val(id);
                $("#error_messages").html();
                $.ajax({
                    type: 'get',
                    url: 'blocks/alldeceasedsbyblock/' + id,
                    dataType: 'json',
                    success: function(data) {
                        $("#_md_modalTitle").text("MANAGE DECEASED OF BLOCK " + data[
                            'blockinfo'].section_name);
                        // var option = "<option value = ''> -- Please select deceased here --</option>";
                        var html = "<tr>";
                        if (data['deceaseds'].length > 0) {

                            for (var i = 0; i < data['deceaseds'].length; i++) {
                                html += "<td >" + data['deceaseds'][i].firstname + " " + data[
                                        'deceaseds'][i].middlename + " " + data['deceaseds'][i]
                                    .lastname + "</td>";
                                html +=
                                    "<td class = 'text-center'><input  type = 'checkbox' value = " +
                                    data['deceaseds'][i].d_id + " class  = 'mCheck'></td>";
                            }
                        } else {
                            html += "<td colspan='2'>No deceased/s burried here.</td>";
                        }
                        html += "</tr>";
                        $("#_deceaseds tbody").html(html);
                        var option1 =
                            "<option value = ''> -- Please select deceased here --</option>";
                        for (var i = 0; i < data['services'].length; i++) {
                            if (data['services'][i].id > 1) {
                                option1 += "<option value = " + data['services'][i].id + ">" +
                                    data['services'][i].service_name + "<option>";
                            }
                        }
                        $(".s_services").html(option1);
                        $("#managedeceased_modal").modal({
                            backdrop: 'static',
                            keyboard: false,
                        })
                    },
                    error: function(error) {
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

            $("#btn_openform").on('click', function() {
                $("#slot").prop('readonly', false);
                $("#block_form")[0].reset();
                $("#block_id").val("");
                $("#preview_image").attr('src', '{{ asset('dist/img/coffin.jpg') }}');
                $(".span_error").html("");
                $("input").removeClass('is-invalid')
                $("#modal_form").modal({
                    'backdrop': 'static',
                    'keyboard': false
                });
            })
            $("#tbl_spaceAreas tbody").on('click', "#btn_slot", function() {
                var id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: '/spaceAreas/show/' + id,
                    dataType: 'json',
                    success: function(data) {
                        $("#slot_form").trigger('reset');
                        $("#slot_modal").modal({
                            'backdrop': 'static',
                            'keyboard': false,
                        });
                        $("#_block_id").val(data.id);
                        $("#slot_modal").find('.modal-title').text("ADJUST VACANCY FOR " + data
                            .section_name + "")
                    },
                    error: function(error) {
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

            
            // apply the currencyFormat behaviour to elements with 'currency' as their class

            $("#slot_form").on('submit', function(e) {
    e.preventDefault();

    if ($("#_slot").val() == 0) {
        Swal.fire('Warning', 'No adjustment.', 'warning');
    } else {
        Swal.fire({
            title: 'Are you sure you want to expand this section?',
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
                    type: 'put',
                    url: "{{ route('spaceareas.update', 'id') }}",
                    data: {
                        type: 'update_slot',
                        _slot: $("#_slot").val(),
                        _block_id: $("#_block_id").val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 1) {
                            AutoReload();
                            $("#slot_modal").modal('hide');
                            $("#slot_form").trigger('reset');
                            $("input").removeClass('is-invalid');
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'Responses',
                                autohide: true,
                                delay: 3000,
                                body: response.message,
                            });
                        } else if (response.status == 2) {
                            $("#slot_form").trigger('reset');
                            $("input").removeClass('is-invalid');
                            $.each(response.message, function(key, value) {
                                if (key == "_slot") {
                                    $("#errmsg_slot").text(value);
                                    $("input[name='slot']").addClass('is-invalid');
                                }
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Cannot process the request.', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info');
            }
        })
    }
})

            let block_image = null;

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#preview_image').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image").change(function(e) {
                block_image = e.target.files[0];
                readURL(this);
            });
            $("#block_form").on('submit', function(e) {
                e.preventDefault();
                var slot = $("input[name='slot']").val().toUpperCase();
                var section_name = $("input[name='section_name']").val().toUpperCase();
                var block_cost = $("input[name='block_cost']").val();
                var block_id = $("#block_id").val();

                if (block_id != "") {
                    var data = new FormData(this);
                    data.append('type', 'update_block');
                    $.ajax({
                        url: "/spaceareas/updatewithimage",
                        type: 'post',
                        data: data,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status == 1) {
                                AutoReload();
                                $("#modal_form").modal('hide');
                                $("#block_form").trigger('reset');
                                $("input[type='text']").removeClass('is-invalid');
                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Responses',
                                    autohide: true,
                                    delay: 3000,
                                    body: response.message,
                                })
                            } else if (response.status == 2) {
                                $("input[type='text']").removeClass('is-invalid');
                                $("input[type='number']").removeClass('is-invalid');
                                $("#errmsg_blockcost").html("");
                                $("#errmsg_blocknumber").html("");
                                $("#errmsg_sectionname").html("");
                                $.each(response.message, function(key, value) {

                                    if (key == "block_cost") {
                                        $("#errmsg_blockcost").text(value);
                                        $("input[name='block_cost']").addClass(
                                            'is-invalid');
                                    }
                                    if (key == "section_name") {
                                        $("#errmsg_sectionname").text(value);
                                        $("input[name='section_name']").addClass(
                                            'is-invalid');
                                    }
                                    if (key == "slot") {
                                        $("#errmsg_blocknumber").text(value);
                                        $("input[name='slot']").addClass('is-invalid');
                                    }
                                    if (key == "image") {
                                        $("#errmsg_image").text(value);
                                        $("input[name='image']").addClass('is-invalid');
                                    }
                                });
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(error) {
                            alert("Cannot process the request.");
                        }
                    })
                } else {
                    $.ajax({
                        type: 'post',
                        url: "{{ route('spaceareas.store') }}",
                        data: new FormData(this),
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            if (response.status == 1) {
                                AutoReload();
                                $("#modal_form").modal('hide');
                                $("#block_form").trigger('reset');
                                $("input[type='text']").removeClass('is-invalid');
                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Responses',
                                    autohide: true,
                                    delay: 3000,
                                    body: response.message,
                                })
                            } else if (response.status == 2) {
                                $("input[type='text']").removeClass('is-invalid');
                                $("input[type='number']").removeClass('is-invalid');
                                $("#errmsg_blockcost").html("");
                                $("#errmsg_blocknumber").html("");
                                $("#errmsg_sectionname").html("");
                                $.each(response.message, function(key, value) {

                                    if (key == "block_cost") {
                                        $("#errmsg_blockcost").text(value);
                                        $("input[name='block_cost']").addClass(
                                            'is-invalid');
                                    }
                                    if (key == "section_name") {
                                        $("#errmsg_sectionname").text(value);
                                        $("input[name='section_name']").addClass(
                                            'is-invalid');
                                    }
                                    if (key == "slot") {
                                        $("#errmsg_blocknumber").text(value);
                                        $("input[name='slot']").addClass('is-invalid');
                                    }
                                    if (key == "image") {
                                        $("#errmsg_image").text(value);
                                        $("input[name='image']").addClass('is-invalid');
                                    }
                                });
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(error) {
                            alert("Cannot process the request.");
                        }
                    })
                }
            })

            $("#tbl_spaceAreas tbody").on('click', '#btn_edit', function() {
                $("#slot").prop('readonly', true);
                var id = $(this).data('id');
                $("input[type='text']").removeClass('is-invalid');
                $("input[type='number']").removeClass('is-invalid');
                $("#errmsg_blockcost").html("");
                $("#errmsg_blocknumber").html("");
                $("#errmsg_sectionname").html("");
                $("#errmsg_image").html("");
                $("input[name='image']").removeClass('is-invalid');
                $.ajax({
                    type: 'get',
                    url: '/spaceAreas/show/' + id,
                    dataType: 'json',
                    success: function(data) {
                        $("#block_id").val(data.id);
                        $("#slot").val(data.slot.toUpperCase());
                        $("#section_name").val(data.section_name.toUpperCase());
                        $("#block_cost").val('₱' + data.block_cost);
                        $("#validity").val(data.validity);
                        if (data.image != "") {
                            $("#preview_image").attr('src', '/upload_images/' + data.image)
                        } else {
                            $("#preview_image").attr('src',
                                '{{ asset('dist/img/coffin.jpg') }}');
                        }
                        $("#modal_form").modal({
                            'backdrop': 'static',
                            'keyboard': false,
                        })
                    },
                    error: function(error) {
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

            $("#tbl_spaceAreas tbody").on('click', '#btn_remove', function() {
                var id = $(this).data('id');
                if (confirm("Are you sure you want to deactivate this section? \nCannot be undone.")) {
                    $.ajax({
                        type: 'get',
                        url: '/spaceAreas/delete/' + id,
                        dataType: 'json',
                        success: function(data) {
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'Responses',
                                autohide: true,
                                delay: 3000,
                                body: data.message,
                            })
                            AutoReload();
                            $("#block_form").trigger('reset');
                        },
                        error: function(error) {
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
