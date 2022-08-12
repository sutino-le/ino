<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>RSP</title>

    <link href="<?= base_url() ?>/upload/logo.png" rel="icon">
    <link href="<?= base_url() ?>/upload/logo.png" rel="apple-touch-icon">
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?= base_url() ?>/templatecf/css/styles.css" rel="stylesheet" />



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Make the image fully responsive */
        .carousel-inner img {
            width: 100%;
            height: 100%;
        }

        h1 {
            display: table;
            background-color: #999;
            color: #fff;
            padding: 10px;
            font-size: 1em
        }
    </style>


</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">PT Rackindo Setara Perkasa</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#proses">Business Process</a></li>
                    <li class="nav-item"><a class="nav-link" href="#career">Career</a></li>
                    <li class="nav-item"><a class="nav-link" href="#signup">Contact</a></li>
                    <?php
                    if (session()->namauser) {
                    ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('profil/index/' . session()->iduser) ?>"><?= session()->namauser ?></a></li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item"><a class="nav-link" href="<?= site_url('login/index') ?>">Login</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 class="mx-auto my-0 text-uppercase">GREAT QUALITY AND INNOVATION DESIGN</h1>
                    <h4 class="text-white-50 mx-auto mt-2 mb">WITH REASONABLE PRICE</h4>
                    <a class="btn btn-primary" href="#about">Get Started</a>
                </div>
            </div>
        </div>
    </header>
    <!-- About-->
    <section class="about-section text-center" id="about">

        <div id="demo" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators">
            </ul>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= base_url() ?>/templatecf/assets/img/ipad.png" alt="Los Angeles" width="1100" height="400">
                    <div class=" carousel-caption">
                        <h3>COMPANY HISTORY</h3>
                        <br>
                        <p class="text" align="justify">
                            Founded in the late 1980, initially we started as a home industry furniture that used raw materials of solid wood in the production process. At that time, the main activity of our business were to receive various orders, cooperate with small tenders, and customized furnishing to houses. The applied marketing way was still conventional, named door-to-door marketing. Along with the development of industry, we acquired a company in 1992 and merged it into an entity called PT Rackindo Setara Perkasa. <br><br>

                            While running previous business, PT Rackindo Setara Perkasa started innovating to differentiate product as a new alternative for consumers. Our factory mass-produced knocked-down furnishings using Particle Board (PB), Medium Density Fibreboard (MDF) and laminated with paper or polyvinyl chloride (PVC). Our featured products were bedroom set (bed, nakkas, wardrobe, and dresser table), kitchen set, living room set (decorative cabinet), shoes rack, credenza, bookcase, coffee table and audio video rack. By the method of business-to-business (B2B), product marketing were done to furniture shops in Jakarta and Greater area (Jabodetabek). We also cooperated with outsourcing agents or distributors spread throughout the major cities in Indonesia. <br><br>

                            In 2001 PT Rackindo Setara Perkasa did another acquisition with a furniture company in which it remained to survive today. Three companies merged under the name of Rackindo Group then had different segmenting, targeting and positioning in market for each business. Still in the same core business, namely furniture, PT Rackindo Setara Perkasa (Rackindo) remained to focus on home furniture market, while PT Mitra Rackindo Perkasa Gemilang (Mitra) had a segment of high-end office furnitureand PT Surya Citra Indah Perkasa (Sucitra) was directed to the low-end office furniture.
                        </p>
                        <br><br><br><br><br><br>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Proses-->
    <section class="projects-section" id="proses">
        <div class="container px-4 px-lg-5">

            <!-- Featured Project Row-->
            <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
                <div class="col-xl-8 col-lg-7"><img class="img-fluid mb-0 mb-lg-0" src="<?= base_url() ?>/templatecf/assets/img/01-input.jpg" /></div>
                <div class="col-xl-4 col-lg-5">
                    <div class="featured-text text-lg-left">
                        <h4>INPUT</h4>
                        <p class="text-black-50 mb-0" align="justify">
                        <ul>
                            <li>Forecast of existing products</li>
                            <li>New product innovation</li>
                            <li>Tendering</li>
                            <li>Subcontracting</li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>

            <hr class="d-none d-lg-block mb-5 mt-2 ms-0" />

            <!-- Featured Project Row-->
            <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
                <div class="col-xl-8 col-lg-7"><img class="img-fluid mb-0 mb-lg-0" src="<?= base_url() ?>/templatecf/assets/img/02-rnd.jpg" alt="..." /></div>
                <div class="col-xl-4 col-lg-5">
                    <div class="featured-text text-lg-left">
                        <h4>R & D (RESEARCH AND DEVELOPMENT)</h4>
                        <p class="text-black-50 mb-0" align="justify">
                        <ul>
                            <li>Hand Sketch Drawing</li>
                            <li>Computerized Technical Drawing</li>
                            <li>3D Modelling</li>
                            <li>Material Rendering</li>
                            <li>Styling & Finishing</li>
                            <li>Mock-up</li>
                            <li>Prototype, engineering testing and final sample (for buyers or customers)</li>
                            <li>Approval for mass production</li>
                            <li>Photoshoot</li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>

            <hr class="d-none d-lg-block mb-5 mt-2 ms-0" />

            <!-- Featured Project Row-->
            <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
                <div class="col-xl-8 col-lg-7">

                    <div id="demo" class="carousel slide" data-ride="carousel">
                        <ul class="carousel-indicators">
                            <li data-target="#demo" data-slide-to="0" class="active"></li>
                            <li data-target="#demo" data-slide-to="1"></li>
                            <li data-target="#demo" data-slide-to="2"></li>
                            <li data-target="#demo" data-slide-to="3"></li>
                            <li data-target="#demo" data-slide-to="4"></li>
                            <li data-target="#demo" data-slide-to="5"></li>
                            <li data-target="#demo" data-slide-to="6"></li>
                        </ul>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?= base_url() ?>/templatecf/assets/img/proses-01-laminating.jpg" alt="STEEP 1 : LAMINATING" width="1100" height="500">
                                <div class=" carousel-caption">
                                    <span class="badge badge-info">
                                        <h3 class="text">STEEP 1 : LAMINATING</h3>
                                    </span>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url() ?>/templatecf/assets/img/proses-02-cutting.jpg" alt="STEEP 2 : CUTTING" width="1100" height="500">
                                <div class=" carousel-caption">

                                    <span class="badge badge-info">
                                        <h3 class="text">STEEP 2 : CUTTING</h3>
                                    </span>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url() ?>/templatecf/assets/img/proses-03-edge.jpg" alt="STEEP 3 : EDGE BANDING" width="1100" height="500">
                                <div class=" carousel-caption">

                                    <span class="badge badge-info">
                                        <h3 class="text">STEEP 3 : EDGE BANDING</h3>
                                    </span>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url() ?>/templatecf/assets/img/proses-04-drilling.jpg" alt="STEEP 4 : DRILLING" width="1100" height="500">
                                <div class=" carousel-caption">

                                    <span class="badge badge-info">
                                        <h3 class="text">STEEP 4 : DRILLING</h3>
                                    </span>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url() ?>/templatecf/assets/img/proses-05-CNC.jpg" alt="STEEP 5 : CNC PROCESS" width="1100" height="500">
                                <div class=" carousel-caption">

                                    <span class="badge badge-info">
                                        <h3 class="text">STEEP 5 : CNC PROCESS</h3>
                                    </span>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url() ?>/templatecf/assets/img/proses-06-finishing.jpg" alt="STEEP 6 : FINISHING" width="1100" height="500">
                                <div class=" carousel-caption">

                                    <span class="badge badge-info">
                                        <h3 class="text">STEEP 6 : FINISHING</h3>
                                    </span>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url() ?>/templatecf/assets/img/proses-07-packaging.jpg" alt="STEEP 7 : PACKING" width="1100" height="500">
                                <div class=" carousel-caption">

                                    <span class="badge badge-info">
                                        <h3 class="text">STEEP 7 : PACKING</h3>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#demo" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#demo" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>

                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="featured-text text-lg-left">
                        <h4>PRODUCTION</h4>
                        <p class="text-black-50 mb-0" align="justify">
                            Production process involves more than 500 professional workers with more than 20 years of experience. We only use high quality raw materials to produce the best furniture products.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Career-->
    <section class="projects-section" id="career">
        <div class="container px-4 px-lg-5">

            <?php foreach ($tampildata as $rowloker) :
                if ($rowloker['lowonganstatus'] == "Aktif") {
            ?>

                    <!-- Featured Project Row-->
                    <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
                        <div class="col-xl-4 col-lg-7"><img class="img-fluid mb-0 mb-lg-0" src="<?= base_url() ?>/templatecf/assets/img/pngwing.png" width="300" width="300" /></div>
                        <div class="col-xl-8 col-lg-5">
                            <div class="featured-text text-lg-left">
                                <h4><?= $rowloker['lowonganjob'] ?></h4>
                                <hr class="d-none d-lg-block mb-1 mt-1 ms-0" />
                                <h4>Job Description :</h4>
                                <p class="text-black-50 mb-0">
                                    <?= $rowloker['lowongandeskripsi'] ?>
                                </p>
                            </div>
                            <?php
                            if (session()->namauser) {
                            ?>
                                <a href="<?= site_url('psikotest/index') ?>" style="text-decoration: none"><button type="button" class="btn btn-info btn-block">Apply Now</button></a>
                            <?php
                            } else {
                            ?>
                                <a href="<?= site_url('login/index') ?>" style="text-decoration: none"><button type="button" class="btn btn-info btn-block">Apply Now</button></a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <hr class="d-none d-lg-block mb-5 mt-2 ms-0" />

                <?php
                } else {
                ?>


                    <!-- Featured Project Row-->
                    <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
                        <div class="col-xl-4 col-lg-7"><img class="img-fluid mb-0 mb-lg-0" src="<?= base_url() ?>/upload/pngwing (4).png" width="300" width="300" /></div>
                        <div class="col-xl-8 col-lg-5">
                            <div class="featured-text text-lg-left">
                                <h4>Sorry...!!!</h4>
                                <hr class="d-none d-lg-block mb-1 mt-1 ms-0" />
                                <h4>Vacancies are not yet available.</h4>
                            </div>
                        </div>

                        <hr class="d-none d-lg-block mb-5 mt-2 ms-0" />
                <?php
                }
            endforeach
                ?>

                    </div>
    </section>

    <!-- Signup-->
    <section class="signup-section" id="signup">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-10 col-lg-8 mx-auto text-center">
                    <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
                    <h6 class="text-white mb-3">Feel free to contact us and ask any question to our customer service team</h6>
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * SB Forms Contact Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- This form is pre-integrated with SB Forms.-->
                    <!-- To make this form functional, sign up at-->
                    <!-- https://startbootstrap.com/solution/contact-forms-->
                    <!-- to get an API token!-->
                    <form class="form-signup" id="contactForm" data-sb-form-api-token="API_TOKEN">
                        <!-- Email address input-->
                        <div class="row input-group-newsletter">
                            <div class="col">
                                <input class="form-control" id="emailAddress" type="email" placeholder="Enter email address..." aria-label="Enter email address..." data-sb-validations="required,email" />
                            </div>
                            <div class="col-auto"><button class="btn btn-primary disabled" id="submitButton" type="submit">Notify Me!</button></div>
                        </div>
                        <div class="invalid-feedback mt-2" data-sb-feedback="emailAddress:required">An email is required.</div>
                        <div class="invalid-feedback mt-2" data-sb-feedback="emailAddress:email">Email is not valid.</div>
                        <!-- Submit success message-->
                        <!---->
                        <!-- This is what your users will see when the form-->
                        <!-- has successfully submitted-->
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3 mt-2 text-white">
                                <div class="fw-bolder">Form submission successful!</div>
                                To activate this form, sign up at
                                <br />
                                <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                            </div>
                        </div>
                        <!-- Submit error message-->
                        <!---->
                        <!-- This is what your users will see when there is-->
                        <!-- an error submitting the form-->
                        <div class="d-none" id="submitErrorMessage">
                            <div class="text-center text-danger mb-3 mt-2">Error sending message!</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact-->
    <section class="contact-section bg-black">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Address</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50">Kompleks Pergudangan Kamal Indah, Jl. Kapuk Kamal Indah I Kav. 15 - 17, Jakarta Barat 11810, Indonesia</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Email</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50"><a href="#!">rackindohrd@gmail.com</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-mobile-alt text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Phone</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50">(021) 5595 1295 / 5595 1393 <br>(021) 5595 8524 / 5595 8527</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social d-flex justify-content-center">
                <a class="mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                <a class="mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                <a class="mx-2" href="#!"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="footer bg-black small text-center text-white-50">
        <div class="container px-4 px-lg-5">Copyright &copy; 2022 PT Rackindo Setara Perkasa</div>
    </footer>


    <div class="viewmodal" style="display: none;"></div>


    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="<?= base_url() ?>/templatecf/js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>





</body>

</html>