<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: #F44336;
    background: -webkit-linear-gradient(to right, #742768, #EF5350);
    background: linear-gradient(to right, #080808, #CF0000)
  }

  .login-card-body .input-group .form-control:focus~.input-group-append .input-group-text,
  .login-card-body .input-group .form-control:focus~.input-group-prepend .input-group-text,
  .register-card-body .input-group .form-control:focus~.input-group-append .input-group-text,
  .register-card-body .input-group .form-control:focus~.input-group-prepend .input-group-text {
    border-color: #F44336;
  }
</style>

<body style="background-color: #F44336;">

  <div class="login-box">
    <div class="d-flex justify-content-center d-flex align-items-center py-2">
      <img src="./vistas/imagenes/cervantino_sin_fondo.png" class="pr-2" alt="" width="80px">

      <a href="" style="color: #FFFFFF; font-size: 1.7rem;" class="fs-4"> <b> COLEGIO CERVANTINO </b></a>
    </div>
    <!-- /.login-logo -->

    <div class="card">
      <div class="card-body login-card-body">
        <span class="fas fa-school" style="color: #F71108;"></span>

        <p class="login-box-msg">INICIAR SESION</p>
        <form method="post">
          <div class="input-group mb-3">

            <input type="text" class="form-control" name="ingUsuario" placeholder="Usuario">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-key" style="color: #F71108;"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="ingPassword" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock" style="color: #F71108;"></span>
              </div>
            </div>
          </div>

          <div class="col-4">
            <button type="submit" style="background: #F71108; color: white;" class="btn btn-block">Ingresar</button>
          </div>
          <?php



          $login = new UsuarioControlador();
          $login->ctrIngresoUsuario();

          ?>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
    <!-- /.login-box -->
  </div>

</body>