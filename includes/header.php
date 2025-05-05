<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Panel</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="favicon.ico" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/weather-icons/css/weather-icons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/c3/c3.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/plugins/owl.carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/vendor/template/dist/css/theme.min.css">
    <script src="<?= BASE_URL ?>/assets/vendor/template/src/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div class="wrapper">
        <header class="header-top" header-theme="light">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <div class="top-menu d-flex align-items-center">
                        <button type="button" id="navbar-fullscreen" class="nav-link"><i
                                class="ik ik-maximize"></i></button>
                    </div>
                    <div class="top-menu d-flex align-items-center">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><img class="avatar" src="https://img.freepik.com/vector-premium/icono-perfil-usuario-estilo-plano-ilustracion-vector-avatar-miembro-sobre-fondo-aislado-concepto-negocio-signo-permiso-humano_157943-15752.jpg"
                                    alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.html"><i class="ik ik-user dropdown-icon"></i>
                                    <?php echo isset($username) ? htmlspecialchars($username) : "Usuario"; ?>
                                </a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/controllers/LogoutController.php"><i
                                        class="ik ik-power dropdown-icon"></i> Salir</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>

        <div class="page-wrap">
            <div class="app-sidebar colored">
                <div class="sidebar-header">
                    <a class="header-brand" href="">
                        <div class="logo-img">
                            <img src="<?= BASE_URL ?>/assets/img/Logo grande blanco.png" class="header-brand-img"
                                style="width: 110px; height: auto;margin-left: 50px;">
                        </div>
                        <!-- <span class="text">panel</span> -->
                    </a>

                </div>

                <div class="sidebar-content">
                    <div class="nav-container">
                        <nav id="main-menu-navigation" class="navigation-main">
                            <div class="nav-lavel">Navegación</div>

                            <!-- Visible para todos (Admin y Usuario) -->
                            <div class="nav-item">
                                <a href="<?= BASE_URL ?>/views/admin"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                            </div>

                            <div class="nav-item">
                                <a href="<?= BASE_URL ?>/views/admin/cliente.php"><i class="ik ik-user-check"></i><span>Clientes</span></a>
                            </div>
                            <div class="nav-item">
                                <a href="<?= BASE_URL ?>/views/admin/internamiento.php"><i class="ik ik-monitor"></i><span>Equipos ingresados</span></a>
                            </div>
                            <div class="nav-item">
                                <a href="<?= BASE_URL ?>/views/admin/user.php"><i class="ik ik-activity"></i><span>Estados de reparación</span></a>
                            </div>
                            <div class="nav-item">
                                <a href="<?= BASE_URL ?>/views/admin/user.php"><i class="ik ik-file-text"></i><span>Guía de ingreso/salida</span></a>
                            </div>
                            <div class="nav-item">
                                <a href="<?= BASE_URL ?>/views/admin/user.php"><i class="ik ik-globe"></i><span>Página pública de consulta</span></a>
                            </div>

                            <!-- Solo para rol Admin -->
                            <?php if ($_SESSION['usuario']['rol'] === 'Admin'): ?>
                                <div class="nav-item">
                                    <a href="<?= BASE_URL ?>/views/admin/usuario.php"><i class="ik ik-users"></i><span>Usuarios</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?= BASE_URL ?>/views/admin/user.php"><i class="ik ik-shield"></i><span>Roles / Permisos</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?= BASE_URL ?>/views/admin/user.php"><i class="ik ik-clock"></i><span>Historial de atención</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?= BASE_URL ?>/views/admin/user.php"><i class="ik ik-pie-chart"></i><span>Reportes</span></a>
                                </div>
                            <?php endif; ?>
                        </nav>
                    </div>

                </div>
            </div>


            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
            <script>
                window.jQuery || document.write('<script src="assets/vendor/template/src/js/vendor/jquery-3.3.1.min.js"><\/script>')
            </script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/popper.js/dist/umd/popper.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/screenfull/dist/screenfull.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/jvectormap/jquery-jvectormap.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/moment/moment.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/d3/dist/d3.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/plugins/c3/c3.min.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/js/tables.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/js/widgets.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/js/charts.js"></script>
            <script src="<?= BASE_URL ?>/assets/vendor/template/dist/js/theme.min.js"></script>
            <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
            <script>
                (function(b, o, i, l, e, r) {
                    b.GoogleAnalyticsObject = l;
                    b[l] || (b[l] =
                        function() {
                            (b[l].q = b[l].q || []).push(arguments)
                        });
                    b[l].l = +new Date;
                    e = o.createElement(i);
                    r = o.getElementsByTagName(i)[0];
                    e.src = 'https://www.google-analytics.com/analytics.js';
                    r.parentNode.insertBefore(e, r)
                }(window, document, 'script', 'ga'));
                ga('create', 'UA-XXXXX-X', 'auto');
                ga('send', 'pageview');
            </script>
</body>

</html>