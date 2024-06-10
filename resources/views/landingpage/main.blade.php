<!doctype html>
<html lang="en">

<head>
    <title>LCIMS: Lugait Electronic Information Management System</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Mobland - Mobile App Landing Page Template">
    <meta name="keywords" content="HTML5, bootstrap, mobile, app, landing, ios, android, responsive">

    <!-- Font -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('mobapp-master/css/bootstrap.min.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="{{ asset('mobapp-master/css/themify-icons.css') }}">
    <!-- Owl carousel -->
    <link rel="stylesheet" href="{{ asset('mobapp-master/css/owl.carousel.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <!-- Main css -->
    <link href="{{ asset('mobapp-master/css/style.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zooming/1.6.3/zooming.min.js"></script>

    <style>
        #home {
            background: url("/dist/img/lugait-map.png") no-repeat center fixed;
            background-size: cover;

            height: 600px;
        }

        #search {
            width: 50%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid orange;
            border-radius: 20px;
        }

        #search:focus {
            border: 5px solid orange;
        }
    </style>
  

</head>

<body data-spy="scroll" data-target="#navbar" data-offset="20">
    <div class="nav-menu fixed-top bg-gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="{{ route('system.logout') }}"><img src="{{ asset('assets/img/logos/Lugait.png') }}"
                                style = "width: 100px:; height: 100px;" class="img-fluid" alt="logo"></a> <button
                            class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
                            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation"> <span
                                class="navbar-toggler-icon"></span> </button>
                        <div class="collapse navbar-collapse" id="navbar">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item"> <a class="nav-link active " href="#home">HOME <span
                                            class="sr-only">(current)</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#gallery">SPACE AREAS</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#LOCATION">LOCATION</a> </li>
                                <!-- <li class="nav-item"> <a class="nav-link" href="#results">GALLERY</a> </li> -->
                                <!-- <li class="nav-item"> <a class="nav-link" href="#features">SERVICES</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#gallery">GALLERY</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#pricing">PRICING</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="#contact">CONTACT</a> </li> -->
                                <li class="nav-item"><a href="{{ route('admin.login') }}"
                                        class="btn btn-outline-light my-3 my-sm-0 ml-lg-3">Admin Login</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <header class="bg-gradient mt-10" id="home">
        <div class="container mt-5">
            <h1>Welcome to Lugait Electronic Cemetery Information System (Customer Page)</h1>
            <p class="tagline">"This page enables users to search for deceased individuals and contains information on
                memorial drives for the deceased."</p>
        </div>
        <div class="img-holder mt-5">
            <input type="text" name=""
                oninput="return $('#results').hide(), $('#deceased_info').hide(), $(this).css('border', '')"
                id="search"
                placeholder="Search Deceased Info Here By Firstname / Middlename / Lastname / Address ...">
            <button class = "btn btn-light btn-primary" id = "btn_search" style = "border-radius: 20px"><span><i
                        class = "fa fa-search"></i>&nbsp; Find Deceased</span></button>
        </div>
    </header>

    <div class="section light-bg" id = "results" style = "display: none">
        <div class="container">

            <div class="section-title">
                <small>HIGHLIGHTS</small>
                <h3>Deceased Results</h3>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table" style="width: 100%">
                                <table style="width: 100%" id = "tbl_results"
                                    class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>View Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['data'] as $d)
                                            <tr>
                                                @if ($d->suffix != 'N')
                                                    <td>{{ $d->firstname . ' ' . $d->middlename . ' ' . $d->lastname . ', ' . $d->suffix }}
                                                    </td>
                                                    <td>{{ $d->barangay . ', ' . $d->city . ', ' . $d->province }}</td>
                                                    <td align = "center">
                                                        <a type = "button" data-id = "{{ $d->deceased_id }}"
                                                            id = "btn_view" class = "btn btn-sm btn-primary"><i
                                                                class = "fas fa fa-eye"></i> View Info</a>
                                                    </td>
                                                @endif
                                                @if ($d->suffix == 'N')
                                                    <td>{{ $d->firstname . ' ' . $d->middlename . ' ' . $d->lastname }}
                                                    </td>
                                                    <td>{{ $d->barangay . ', ' . $d->city . ', ' . $d->province }}</td>
                                                    <td align = "center">
                                                        <a type = "button" data-id = "{{ $d->deceased_id }}"
                                                            id = "btn_view" class = "btn btn-sm btn-primary"><i
                                                                class = "fas fa fa-eye"></i> View Info</a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="section light-bg" id = "deceased_info" style = "display: none">
        <div class="section-title">
            <small>Individual Deceased</small>
            <h3>Deceased Details</h3>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                    <ul class="list-unstyled ui-steps">
                        <li class="media">
                            <div class="circle-icon mr-4"><i class = "fas fa fa-user"></i></div>
                            <div class="media-body">
                                <h5>Name Of Deceased</h5>
                                <p id = "name"></p>
                            </div>
                        </li>
                        <li class="media my-4">
                            <div class="circle-icon mr-4"><i class = "fas fa fa-calendar-times"></i></div>
                            <div class="media-body">
                                <h5>Date Died</h5>
                                <p id = "date_died"></p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="circle-icon mr-4"><i class = "fas fa fa-calendar-times"></i></div>
                            <div class="media-body">
                                <h5>Burial Date</h5>
                                <p id = "dateof_burial"></p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="circle-icon mr-4"><i class = "fas fa fa-ring"></i></div>
                            <div class="media-body">
                                <h5>Civil Status</h5>
                                <p id = "civilstatus"></p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="circle-icon mr-4"><i class = "fas fa fa-transgender"></i></div>
                            <div class="media-body">
                                <h5>Sex</h5>
                                <p id = "sex"> </p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="circle-icon mr-4"><i class = "fas fa fa-skull-crossbones"></i></div>
                            <div class="media-body">
                                <h5>Cause of Death</h5>
                                <p id = "causeofdeath"> </p>


                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div style="text-align: center;">

                        <h5>Space Area</h5>
                        <div
                            style="padding: 0px; border-radius: 5px; margin-top: 10px; width: 100%; font-size: 16px;">
                            <p id="section_name"></p>
                        </div>

                    </div>
                    <style>
                        .fullsize {
                            border: 2px solid rgb(138, 2, 131);
                            z-index: 999;
                            cursor: zoom-out;
                            display: block;
                            width: 800px;
                            max-width: 800px;
                            height: 750px;
                            position: fixed;
                            left: 50%;
                            top: 50%;
                            transform: translate(-50%, -50%);
                            transition: transform 0.5s;
                            /* pang smooth */
                        }

                        .original-size {
                            max-width: 120%;
                            /* orig size */
                            max-height: 200%;
                        }
                        
                    </style>
                    <div class="zoom-container">
                        <img id="img_rip" src="{{ asset('dist/img/coffin.jpg') }}" alt="deceased-image"
                            class="zoomable original-size" style="max-width: 120%; max-height: 200%;"
                            onclick="toggleSize(this)">
                    </div>
                </div>

                <script>
                    function toggleSize(element) {
                        element.classList.toggle("fullsize"); /* kini kini */
                    }

                    // mubalik pag e scroll
                    window.addEventListener("scroll", function() {
                        const img = document.getElementById("img_rip");
                        if (img.classList.contains("fullsize")) {
                            img.classList.remove("fullsize");
                        }
                    });
                </script>



            </div>




        </div>

    </div>

    </div>
    <!-- // end .section -->
    <div class="section light-bg" id = "gallery">
        <div class="container">
            <div class="section-title">
                <small>Space areas</small>
                <h3>Space Areas of Lugait Cemetery</h3>
            </div>

            <div class="img-gallery owl-carousel owl-theme">
                @foreach ($data['blocks'] as $b)
                    <div class="container">
                        <img src="{{ asset('/upload_images/' . $b->image) }}" alt="image">
                        <div class="text-block" style="text-align: center;">
                            <h4>{{ $b->section_name }}</h4>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
    <div class="section pt-0" id="LOCATION">
        <div class="container">
            <div class="section-title">
                <small>Location</small>
                <h3>Lugait Cemetery Location</h3>
            </div>
        </div>
    </div>

    <div style="position: relative; width: 70%; margin: -100px auto 0 auto; text-align: center;">
        <iframe width="100%" height="800"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345.67890123456!2d124.2572324!3d8.3366962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f35!3m3!1m2!1s0x32557193c036f527%3A0x3dbfec42026b8dac!2sLugait+Public+Cemetery!5e0!3m2!1sen!2s!4v1640509312891&t=k"
            frameborder="0" style="border: 0px solid #3f034b;" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <!-- <div class="section light-bg" id="Entrance">
        <div class="container">
            <div class="section-title2">
                <small>Entrance</small>
                <h3>Lugait Cemetery Entrance</h3>
            </div>
        </div>
    </div>
    <div class="slider">
        <div class="list">
            <div class="slider-slide">
                <div class="zoom-container2">
                    <img src="{{ asset('dist/img/E4.jpg') }}" alt="Satellite View" class="img-fluid zoomable2">
                </div>
              
            </div>
            <div class="slider-slide">
                <div class="zoom-container2">
                    <img src="{{ asset('dist/img/entrance3.jpg') }}" alt="Street View" class="img-fluid zoomable2">
                </div>
           
            </div>
        </div>
        <div class="buttons">
            <button id="prev">&#9664;</button>
            <button id="next">&#9654;</button>
        </div>
        <ul class="dots">
            <li class="active"></li>
            <li></li>
        </ul>
    </div> -->
    </div>


    <style>
        .section-title2 {
            margin-bottom: -100px;
            text-align: center;
        }

        .slider {
            width: 1300px;
            max-width: 100vw;
            height: 700px;
            margin: auto;
            position: relative;
            overflow: hidden;
        }

        .slider .list {
            position: absolute;
            width: max-content;
            height: 100%;
            left: 0;
            top: 0;
            display: flex;
            transition: 2s;
        }

        .slider .list img {
            width: 1300px;
            max-width: 1300px;
            height: 100%;
            object-fit: cover;
        }

        .slider .buttons {
            position: absolute;
            top: 45%;
            left: 5%;
            width: 90%;
            display: flex;
            justify-content: space-between;
        }

        .slider .buttons button {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #fff5;
            color: #fff;
            border: none;
            font-family: monospace;
            font-weight: bold;
        }

        .slider .dots {
            position: absolute;
            bottom: 10px;
            left: 0;
            color: #fff;
            width: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;    
        }

        .slider .dots li {
            list-style: none;
            width: 10px;
            height: 10px;
            background-color: #fff;
            margin: 10px;
            border-radius: 20px;
            transition: 0.5s;
        }

        .slider .dots li.active {
            width: 30px;
        }

        @media screen and (max-width: 768px) {
            .slider {
                height: 400px;
            }
        }
    </style>
    <script>
        let slider = document.querySelector('.slider .list');
        let items = document.querySelectorAll('.slider .list .slider-slide');
        let next = document.getElementById('next');
        let prev = document.getElementById('prev');
        let dots = document.querySelectorAll('.slider .dots li');

        let lengthItems = items.length - 1;
        let active = 0;

        next.onclick = function() {
            active = active + 1 <= lengthItems ? active + 1 : 0;
            reloadSlider();
        };

        prev.onclick = function() {
            active = active - 1 >= 0 ? active - 1 : lengthItems;
            reloadSlider();
        };

        let refreshInterval = setInterval(() => {
            next.click();
        }, 9000);

        function reloadSlider() {
            slider.style.left = -items[active].offsetLeft + 'px';

            let lastActiveDot = document.querySelector('.slider .dots li.active');
            lastActiveDot.classList.remove('active');
            dots[active].classList.add('active');

            clearInterval(refreshInterval);
            refreshInterval = setInterval(() => {
                next.click();
            }, 9000);
        }

        dots.forEach((li, key) => {
            li.addEventListener('click', () => {
                active = key;
                reloadSlider();
            });
        });

        window.onresize = function(event) {
            reloadSlider();
        };
    </script>
    <hr>

    <div class="section pt-0">
        <div class="container">
            <div class="section-title">
                <small>FAQ</small>
                <h3>Frequently Asked Questions</h3>
            </div>
            <div class="row pt-4">
                <div class="col-md-6">
                    <h4 class="mb-3">What is Lugait?</h4>
                    <p class="mb-5 text-justify">Lugait, officially the Municipality of Lugait (Cebuano: Lungsod sa
                        Lugait; Tagalog: Bayan ng Lugait), is a 2nd class municipality in the province of Misamis
                        Oriental, Philippines. According to the 2020 census, it has a population of 20,559 people</p>
                    <h4 class="mb-3">What are the barangays of Lugait?</h4>
                    <p class="mb-3 text-justify">
                        Lugait is politically subdivided into 8 barangays. Each barangay consists of puroks while some
                        have sitios.

                    <ul class="mb-5">
                        <li>Aya-aya</li>
                        <li>Betahon</li>
                        <li>Biga</li>
                        <li>Calangahan</li>
                        <li>Kaluknayan</li>
                        <li>Talacogon (Lower Talacogon)</li>
                        <li>Poblacion</li>
                        <li>Upper Talacogon</li>
                    </ul>
                    </p>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">Lugait Population?</h4>
                    <p class="mb-5 text-justify">Population (2020 census)[3]
                        • Total 20,559
                        • Density 750/km2 (1,900/sq mi)
                        • Households 5,062
                    </p>
                    <h4 class="mb-3">What are the services of the cemetery Lugait?</h4>

                    <ul class="mb-5">
                        <li>Burial</li>
                        <li>Common Bone Depository</li>
                        <li>Exhume of Bone/Aadaver</li>
                        <li>Niches for Cremated Remains</li>
                        <li>Transfer of Bone/Cadaver</li>
                    </ul>
                    <h4 class="mb-3">Geographical of Lugait?</h4>
                    <p class="mb-5 text-justify">Lugait is bounded on the west by Iligan Bay; north by the municipality
                        of Manticao, Misamis Oriental; and south by Iligan City. As the westernmost municipality of
                        Misamis Oriental, it lies approximately 80 kilometres (50 mi) from the regional capital of
                        Northern Mindanao, Cagayan de Oro. It is also approximately 17 kilometres (11 mi) north of
                        Iligan City.

                        It has a total land area of 27.45 square kilometres (10.60 sq mi). The coasts of Lugait are
                        suitable for anchorage and navigation. A private wharf, in fact, is located at Salimbal Point.

                        Lugait's weather patterns follow the wet and dry seasons prevalent throughout the country.
                        However, it enjoys a typhoon-free topography.</p>
                </div>
                <div class="col-md-12">
                    <h4 class="mb-3">Lugait History</h4>
                    <p class="text-justify">Lugait was once one of the barrios of Initao, Misamis Oriental until 1948.
                        When the town of Manticao became a separate municipality from Initao, Lugait became its biggest
                        barrio with the biggest population and revenue contribution.

                        March 16, 1961, marked the autonomy of Lugait from its mother municipality when then President
                        Carlos P. Garcia signed and announced Executive Order No. 425 that created the Municipality of
                        Lugait in the province of Misamis Oriental.

                        As early as its creation, Lugait opened its doors to industrialization. It availed itself of the
                        opportunities then prevailing at the time and soon the world came to know Lugait by the flow of
                        its cement and G.I. roofing products in the market. These commodities became the community's
                        by-word.</p>
                </div>
            </div>
        </div>
    </div>



    <!-- // end .section -->

    <div class="light-bg py-5" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <p class="mb-2"> <span class="ti-location-pin mr-2"></span> <a
                            href="https://www.google.com/maps/place/Lugait+Public+Cemetery/@8.3368239,124.2547914,17z/data=!3m1!4b1!4m6!3m5!1s0x32557193c036f527:0x3dbfec42026b8dac!8m2!3d8.3368239!4d124.2573663!16s%2Fg%2F11c5wzkd0z?entry=ttu">Lugait
                            Public Cemetery</a></p>
                    <div class=" d-block d-sm-inline-block">
                        <p class="mb-2">
                            <span class="ti-email mr-2"></span> <a target="_blank" class="mr-4"
                                href="mailto:drpatricioparami@gmail.com">drpatricioparami@gmail.com</a>
                        </p>
                    </div>
                    <div class="d-block d-sm-inline-block">
                        <p class="mb-0">
                            <span class="ti-headphone-alt mr-2"></span> <a target="_blank"
                                href="tel:639878976331">639878976331</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="social-icons">
                        <a target="_blank" href="https://www.facebook.com/profile.php?id=100009214937969"><span
                                class="ti-facebook"></span></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- // end .section -->
    <footer class="my-5 text-center">
        <!-- Copyright removal is not prohibited! -->
        <p class="mb-2"><small>COPYRIGHT © {{ date('Y') }}. ALL RIGHTS RESERVED. DESIGNED AND PROGRAMMED BY <a
                    target="_blank" href="https://www.facebook.com/jeromeporcado14">JEROME, JOHN PAUL &
                    JHANREY</a></small></p>
        <small>
            <a href="#home" class="m-2">HOME</a>
            <a href="#gallery" class="m-2">SPACE AREAS</a>
            <a href="#LOCATION" class="m-2">LOCATION</a>
        </small>
    </footer>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Plugins JS -->
    <script src="{{ asset('mobapp-master/js/owl.carousel.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('mobapp-master/js/script.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>


    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <!-- BS-Stepper -->
    <script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <!-- dropzonejs -->
    <script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>

    <!-- Number Format -->
    <script src="{{ asset('numberformat/jquery.number.js') }}"></script>
    <!-- Ekko Lightbox -->
    <script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <!-- Filterizr-->
    <script src="{{ asset('plugins/filterizr/jquery.filterizr.min.js') }}"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/main.js') }}"></script>

    <script>
        $(function() {
            $(window).on('load', function() {
                $("body").hide().fadeIn(3000);
            })
            // $('#tbl_results').DataTable({
            //     "paging": true,
            //     "lengthChange": true,
            //     "searching": false,
            //     "ordering": true,
            //     "info": true,
            //     "autoWidth": true,
            //     "responsive": true,
            // });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#btn_search").on("click", function() {
                var value = $("#search").val().toLowerCase();
                if (value != "") {
                    $("#btn_search span").html(
                        '<i class="fas fa fa-refresh fa-lg fa-spin" style="color: #ffffff;"></i> Fetching ...'
                    ).delay(3000).fadeOut('slow', function() {
                        $("#btn_search span").html(
                            '<i class = "fa fa-search"></i>&nbsp; Find Deceased').fadeIn();
                        $("#results").fadeIn(3000);
                        $('html, body').animate({
                            scrollTop: $("#results").offset().top
                        }, 1000);
                        $("#tbl_results tbody tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                } else {
                    $("#search").css({
                        'border': '5px solid red',
                    });
                }
            });
            $("#tbl_results").on('click', '#btn_view', function(e) {
                e.preventDefault();
                $("#deceased_info").fadeIn(3000);
                var id = $(this).data('id');
                $('html, body').animate({
                    scrollTop: $("#deceased_info").offset().top
                }, 1000);
                $("#img_rip").attr('src', '{{ asset('dist/img/coffin.jpg') }}');
                $.ajax({
                    type: 'get',
                    url: "/landingpage/deceaseds/show/" + id,
                    dataType: 'json',
                    success: function(data) {
                        $("#name").text(data[0][0].firstname + " " + data[0][0].middlename +
                            " " + data[0][0].lastname);
                        $("#lastname").val()
                        $("#middlename").val(data[0][0].middlename)
                        $("#firstname").val(data[0][0].firstname)
                        $("#suffix").val(data[0][0].suffix)
                        $("#date_died").text(data[0][0].dateof_death)
                        $("#dateofbirth").val(data[0][0].dateofbirth)

                        if (data[0][0].civilstatus == "W") {
                            $("#civilstatus").text("WIDOWED");
                        }
                        if (data[0][0].civilstatus == "D") {
                            $("#civilstatus").text("DIVORCED");
                        }
                        if (data[0][0].civilstatus == "S") {
                            $("#civilstatus").text("SINGLE");
                        }
                        if (data[0][0].civilstatus == "M") {
                            $("#civilstatus").text("MARRIED");
                        }
                        $("#dateof_burial").text(data[0][0].dateof_burial)
                        $("#burial_time").val(data[0][0].burial_time)
                        if (data[0][0].sex == "M") {
                            $("#sex").text("MALE");
                        }
                        if (data[0][0].sex == "F") {
                            $("#sex").text("FEMALE");
                        }
                        if (data[0][0].causeofdeath == "A") {
                            $("#causeofdeath").text("ACCIDENT");
                        }
                        if (data[0][0].causeofdeath == "H") {
                            $("#causeofdeath").text("HOMICIDE");
                        }
                        if (data[0][0].causeofdeath == "N") {
                            $("#causeofdeath").text("NATURAL");
                        }
                        if (data[0][0].causeofdeath == "O") {
                            $("#causeofdeath").text("OTHERS");
                        }
                        if (data[0][0].causeofdeath == "U") {
                            $("#causeofdeath").text("UNDETERMINED");
                        }
                        //PINAHIRAPAN MO AKO
                        if (data[1] != "") {
                            $("#section_name").text(data[1][0].section_name);
                            if (data[1][0].image == "") {
                                $("#img_rip").attr('src',
                                    '{{ asset('dist/img/coffin.jpg') }}');
                            } else {
                                $("#img_rip").attr('src', '/upload_images/' + data[1][0].image +
                                    '');
                            }
                        } else {
                            $("#section_name").text("NO SPACE AREA ASSIGNED");
                            $("#img_rip").attr('src', '{{ asset('dist/img/coffin.jpg') }}');
                        }

                    },
                    error: function() {
                        alert("System cannot process request.")
                    }
                })
            })
        })
    </script>

</body>

</html>
