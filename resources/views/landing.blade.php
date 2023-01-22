<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>InspeX - ระบบตรวจรับบ้าน</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/one-page-wonder/assets/favicon.ico') }}" />
        {{-- <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script> --}}
        <!-- Font Awesome -->
        <link href="{{ asset('assets/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet">
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('assets/one-page-wonder/css/styles.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
            <div class="container px-5">
                <a class="navbar-brand" href="#page-top">InspeX</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item"><a class="nav-link" href="#!">
                                    <a href="{{ url('/home') }}" class="nav-link">Home</a>
                                </li>
                            @else
                                <li class="nav-item"><a class="nav-link" href="#!">
                                    <a href="{{ route('login') }}" class="nav-link">Log in</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item"><a class="nav-link" href="#!">
                                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                                    </li>
                                @endif
                            @endauth
                        @endif

                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="text-center text-white header-custom">
            <div class="masthead-content">
                <div class="container px-5">
                    <img src="{{ asset('image/inspex-logo.png') }}" class="img-custom">
                    <h1 class="masthead-heading mb-0">InspeX</h1>
                    <h2 class="masthead-subheading mb-0">ระบบตรวจรับบ้าน</h2>
                    <a class="btn btn-custom btn-xl rounded-pill mt-5" href="#scroll">Learn More</a>
                </div>
            </div>
            {{-- <div class="bg-circle-1 bg-circle"></div>
            <div class="bg-circle-2 bg-circle"></div>
            <div class="bg-circle-3 bg-circle"></div>
            <div class="bg-circle-4 bg-circle"></div> --}}
        </header>
        <!-- Content section 1-->
        <section id="scroll">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6 order-lg-2 fa-container">
                        <div class="p-5"><i class="fa fa-user-circle-o fa-custom" aria-hidden="true"></i></div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="p-5">
                            <h2 class="display-4">สำหรับวิศวกรมืออาชีพ</h2>
                            <p>ตรวจรับอาคารก่อนการโอนกรรมสิทธิ์ โดยสามารถให้คำปรึกษา แนะนำแนวทางการแก้ไขได้</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content section 2-->
        <section>
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6 fa-container">
                        <div class="p-5"><i class="fa fa-check-circle-o fa-custom" aria-hidden="true"></i></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <h2 class="display-4">ตรวจซ้ำได้ไม่จำกัดจำนวนครั้ง</h2>
                            <p>ตรวจสอบความเรียบร้อยของอาคาร ทำเครื่องหมายแสดงจุดที่ต้องแก้ไข พร้อมถ่ายภาพ แล้วรายงานผลการตรวจ หลังจากนั้นโครงการหรือผู้รับเหมาแก้ไขปัญหา ตามจุดที่รายงานระบุไว้แล้วเสร็จ แล้วทำการตรวจซ้ำ</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content section 3-->
        <section>
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6 order-lg-2 fa-container">
                        <div class="p-5"><i class="fa fa-file-text fa-custom" aria-hidden="true"></i></div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="p-5">
                            <h2 class="display-4">มีรายงานการตรวจสอบ</h2>
                            <p>หลังเข้าตรวจครั้งที่ 1 เจ้าหน้าที่จัดทำรายงานการตรวจเป็นไฟล์เอกสาร เพื่อให้ทางโครงการหรือผู้รับเหมาแก้ไข</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-black">
            <div class="container px-5"><p class="m-0 text-center text-white small">Copyright &copy; Atip Nomsiri {{ date('Y') }}</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('assets/one-page-wonder/js/scripts.js') }}"></script>
    </body>
</html>
