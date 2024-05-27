<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="text-center my-5">
                    <img src="/proyectoTienda/views/layouts/img/las-compras-en-linea.png" alt="logo" width="100">
                </div>
                <div class="alert alert-danger shadow-sm invalid-feedback" role="alert" id="alert-login">
                    <button type="button" class="btn-close float-end"  aria-label="Close" onclick="addClassAlertLogin()"></button>
                    ¡Nombre de usuario o contraseña no es valido!

                </div>
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="fs-4 card-title fw-bold mb-4 text-center">Iniciar Sesión</h1>
                        <form method="POST" action="http://localhost/proyectoTienda/page/procesarIniciarSesion" class="needs-validation form" novalidate="" autocomplete="off">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="user">Nombre de Usuario</label>
                                <input id="user" type="text" class="form-control" name="user" value="" required
                                    autofocus>
                                <div class="invalid-feedback">
                                    ¡Nombre de usuario es requerido!
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="mb-2 w-100">
                                    <label class="text-muted" for="password">Contraseña</label>
                                    <!-- <a href="forgot.html" class="float-end">
                                            Forgot Password?
                                        </a> -->
                                </div>
                                <input id="password" type="password" class="form-control" name="password" required>
                                <div class="invalid-feedback">
                                    ¡Contraseña es requerida!
                                </div>
                            </div>

                            <div class="w-100">
                                <input type="submit" class="btn btn-primary w-100" id="buttonIniciarSesion" value="Iniciar Sesión">
                            </div>
                        </form>
                    </div>

                </div>
                <div class="text-center mt-5 text-muted">
                    Copyright &copy; 2024-2024 &mdash; Sistema Tienda
                </div>
            </div>
        </div>
    </div>
</section>