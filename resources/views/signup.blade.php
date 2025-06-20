<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Sign Up | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />

      <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script>
    $( function() {
        $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        });
    } );
  </script>
</head>

<body>
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.html" class="d-inline-block auth-logo">
                                    <img src="assets/images/logo-light.png" alt="" height="20">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Silahkan Daftar Terlebih Dahulu</h5>
                                </div>
                                <div class="p-2 mt-4">
                                    <form class="needs-validation" novalidate action="{{ route('signup') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                                            <div class="invalid-feedback">
                                                Tolong masukan username anda
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Lengkap" required>
                                            <div class="invalid-feedback">
                                                Tolong masukan nama lengkap anda
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 password-input" name="password" onpaste="return false" placeholder="Enter password" id="password-input" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                <div class="invalid-feedback">
                                                    Password harus mengandung setidaknya 8 karakter, satu huruf besar, satu huruf kecil, dan satu angka.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                                            <div class="invalid-feedback">
                                                Tolong masukan email anda
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select class="form-select mb-3" id="jenis_kelamin" name="jenis_kelamin" aria-label="Default select example" required>
                                                <option selected>Pilih Jenis Kelamin</option>
                                                <option value="laki-laki">Laki-Laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Tolong masukan jenis kelamin anda
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Agama" class="form-label">Agama <span class="text-danger">*</span></label>
                                             <select class="form-select mb-3" id="agama" name="agama" aria-label="Default select example" required>
                                                <option selected>Pilih Agama</option>
                                                <option value="islam">Islam</option>
                                                <option value="budha">Budha</option>
                                                <option value="protesa">Protestan</option>    
                                                <option value="katolik">Katolik</option>
                                                <option value="hindu">Hindu</option>
                                                <option value="konghucu">Konghucu</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Silahkan pilih agama yg akan didaftarkan.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bo" class="form-label">Bo / Web<span class="text-danger">*</span></label>
                                          <select class="form-select mb-3" id="bo" name="bo" aria-label="Default select example" required>
                                                <option selected>Pilih BO</BOdy></option>
                                                <option value="lx">LxToto</option>
                                                <option value="dewidewi">DewidewiToto</option>
                                                <option value="maxis">MaxisToto</option>    
                                                <option value="waze">WazeToto</option>
                                                <option value="18">18Toto</option>
                                                <option value="s8">S8toto</option>
                                                <option value="sq">SqToto</option>
                                                <option value="sin">SinToto</option>
                                                <option value="maps">MapsToto</option>
                                                <option value="com">ComToto</option>
                                                <option value="hok">HokToto</option>
                                                <option value="ong">OngToto</option>    
                                                <option value="asus">AsusToto</option>
                                                <option value="net">NetToto</option>
                                                <option value="peta">PetaToto</option>
                                                <option value="isi">IsiToto</option>
                                                <option value="waze">WazeToto</option>
                                                <option value="mcd">McdToto</option>    
                                                <option value="pubg">PubgToto</option>
                                                <option value="toped">Totopedia</option>
                                                <option value="victory">VictoryToto</option>
                                                <option value="cuan">Cuantoto</option>
                                                <option value="acc">AccToto</option>
                                                <option value="ks">KsToto</option>
                                                <option value="hb">HbToto</option>
                                                <option value="megashio">MegaShio</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Silahkan pilih Bo yg akan didaftarkan.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                                <select class="form-select mb-3" id="jabatan" name="jabatan" aria-label="Default select example" required>
                                                    <option selected>Pilih Jabatan</option>
                                                    <option value="operator">Operator</option>
                                                    <option value="marketing">Marketing</option>
                                                    <option value="kapten">Kapten</option>
                                                    <option value="wakil kapten">Wakil Kapten</option>    
                                                    <option value="wakil kepala kapten">Wakil Kepala kapten</w>
                                                    <option value="kepala kapten">Kepala Kapten</option>
                                                    <option value="wakil kepala">Wakil Kepala</option>
                                                </select>
                                            <div class="invalid-feedback">
                                                Silahkan pilih jabatan yg akan didaftarkan.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_masuk_kerja" class="form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"  id="datepicker" name="tanggal_masuk_kerja" placeholder="Pilih Tanggal Bergabung" required>
                                        <div class="invalid-feedback">
                                                Tolong masukan tanggal bergabung anda
                                            </div>
                                        </div>
                                        <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                            <h5 class="fs-13">Password must contain:</h5>
                                            <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                            <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                            <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                            <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign Up</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account ? <a href="auth-signin-basic.html" class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>
    <!-- particles js -->
    <script src="assets/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="assets/js/pages/particles.app.js"></script>
    <!-- validation init -->
    <script src="assets/js/pages/form-validation.init.js"></script>
    <!-- password create init -->
    <script src="assets/js/pages/passowrd-create.init.js"></script>
</body>

</html>