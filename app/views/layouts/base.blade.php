<!-- app/views/layouts/base.blade.php -->

<!doctype html>
<html lang="es">

<head>
    @section('cabecera')
    <meta charset="UTF-8">
    <title>COPES</title>
    <link rel="icon" type="image/png" href="/img/copes.gif">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Latest compiled and minified JavaScript -->
    {{HTML::script('js/bootstrap.js');}} 
    {{HTML::style('css/simplex.css');}}
    <!-- Latest compiled and minified CSS -->
    {{HTML::style('css/docsupport/chosen.css');}}
    {{HTML::style('css/index.css');}} 
    <!-- jQuery -->
    {{HTML::script('js/jquery/1.8.2/jquery.min.js');}}

    
    @show
</head>

<body>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <p class="brand">
        <img style="width: 7%;"  src="/img/copes150x150.gif" alt="">  
        <b>&nbsp; COLEGIO DIOCESANO PADRE ELADIO SANCHO</b>
      </p>
    </div>


    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
        <ul class="nav navbar-nav navbar-right">
            @if(!Auth::check())
            <li>
                <button type="button" class="btn btn-success navbar-btn" id="bt_iniciar_sesion">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp; Iniciar Sesión
                </button>
            </li>
            @else
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-star"></span>&nbsp; {{Auth::User()->Nombre}} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a id="bt_cerrar_sesion"><span class="glyphicon glyphicon-remove"></span>&nbsp; Cerrar Sesión</a></li>
                </ul>
              </li>
            @endif
        </ul>
          @if(Auth::check())
            @if(isset($Permiso))
              @if(count($Permiso)>0) 
                @foreach($Permiso as $rol)
                  @if($rol->Descripcion == "Administrativo")
                   <ul class="nav navbar-nav  navbar-right">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-inbox"></span>&nbsp; Administrador <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="{{ route('AdminFamilias') }}"><span class="glyphicon glyphicon-home"></span>&nbsp; Familias</a></li>
                          <li class="divider"></li>
                          <li><a href="{{ route('usuarios') }}"><span class="glyphicon glyphicon-user"></span>&nbsp; Usuarios</a></li>
                          <li class="divider"></li>
                          <li><a href="{{ route('AdminProfesor') }}"><span class="glyphicon glyphicon-book"></span>&nbsp; Profesor</a></li>
                          <li class="divider"></li>
                          <li><a href="{{ route('AdminCitas') }}"><span class="glyphicon glyphicon-calendar"></span>&nbsp; Citas de Atención</a></li>
                          <li class="divider"></li>
                          <li><a href="{{ route('AdminAtencion') }}"><span class="glyphicon glyphicon-time"></span>&nbsp; Horas de Atención</a></li>
                        </ul>
                      </li>
                    </ul>
                  @endif
                  @if($rol->Descripcion == "Profesor")
                    <ul class="nav navbar-nav  navbar-right">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-book"></span>&nbsp; Profesor <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="{{ route('principalProfe') }}"><span class="glyphicon glyphicon-time"></span>&nbsp; Consulta de Citas</a></li>
                        </ul>
                      </li>
                    </ul>
                  @endif
                  @if($rol->Descripcion == "Contador")
                    <ul class="nav navbar-nav  navbar-right">
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-usd"></span>&nbsp; Contador <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                              <li><a href="{{ route('ContPagos') }}"><span class="glyphicon glyphicon-check"></span>&nbsp; Mantenimiento de Pagos</a></li>
                              <li class="divider"></li>
                              <li><a href="{{ route('ContReportes') }}"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Reportes</a></li>
                              <li class="divider"></li>
                              <li><a href="{{ route('calculateNotPaidAccount') }}"><span class="glyphicon glyphicon-transfer"></span>&nbsp; Cálculo de Cuentas Morosas</a></li>
                          </ul>
                      </li>
                    </ul>
                  @endif 
                  @if($rol->Descripcion == "Encargado")
                    <ul class="nav navbar-nav  navbar-right">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>&nbsp; Encargado <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="{{ route('saldos') }}"><span class="glyphicon glyphicon-search"></span>&nbsp; Consulta de Saldos</a></li>
                          <li class="divider"></li>
                          <li><a href="{{ route('citas') }}"><span class="glyphicon glyphicon-calendar"></span>&nbsp; Solicitud de Citas de Atención</a></li>
                          <li class="divider"></li>
                          <li><a href="{{ route('certificados') }}"><span class="glyphicon glyphicon-folder-close"></span>&nbsp; Solicitud de Certificaciones</a></li>
                          <li class="divider"></li>
                          <li><a href="{{ route('cancelaCitas') }}"><span class="glyphicon glyphicon-remove-circle"></span>&nbsp; Cancelar Citas</a></li>
                        </ul>
                      </li>
                    </ul>
                  @endif 
                @endforeach
              @endif
            @endif
          @endif
        </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</body>
    <div class="container">
        <!-- Sección de mensages de alerta -->
        {{ View::make('partials.messages') }} @section('cuerpo')
        <!-- Sección del Body -->
        @show
    </div>
    <!-- Sección del Footer -->
    <footer>
        <div class="content-wrapper">
            <div>
                <hr>
                <center> COPES - {{date('Y')}} ©</center>
            </div>
        </div>
    </footer>
    {{HTML::script('js/index.js');}} {{HTML::script('js/base/main.js')}}
    {{HTML::script('js/docsupport/chosen.jquery.js');}}
    {{HTML::script('js/docsupport/chosen.js');}}
    <script type="text/javascript">
        var url_usuarios = "<?= URL::route('storeUser') ?>";
        var url_login = "{{ route('login') }}";
        var url_register = "{{ route('signin') }}";
        var url_logout = "{{ route('logout') }}";
    </script>
    <script type="text/javascript">
        var config = {
          '.chosen-select'           : {},
          '.chosen-select-deselect'  : {allow_single_deselect:true},
          '.chosen-select-no-single' : {disable_search_threshold:10},
          '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
          '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }
    </script>
</body>

</html>