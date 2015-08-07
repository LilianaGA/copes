<!-- check for flash success message -->
@if(Session::has('flash_success'))
<div class="row" id="flash_success">
    <br>
    <br>
    <br>
    <div class="col-lg-6 col-md-6  col-md-offset-3">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon-ok"></i>
            <strong>¡Bien!</strong>
            <br/>{{ Session::get('flash_success') }}<br>
        </div>
    </div>
</div>
@endif
<!-- check for flash notification message -->
@if (Session::has('flash_info'))
<div class="row" id="flash_info">
    <br>
    <br>
    <br>
    <div class="col-lg-6 col-md-6  col-md-offset-3">
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon-ok"></i>
            <strong>¡Información!</strong>
            <br/>{{ Session::get('flash_info') }}<br>
        </div>
    </div>
</div>
@endif
<!-- check for flash warning message -->
@if (Session::has('flash_warning'))
<div class="row" id="flash_warning">
    <br>
    <br>
    <br>
    <div class="col-lg-6 col-md-6 col-md-offset-3">
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon-ok"></i>
            <strong>¡Advertencia!</strong>
            <br/>{{ Session::get('flash_warning') }}<br>
        </div>
    </div>
</div>
@endif

<!-- check for flash danger message -->
@if (Session::has('flash_danger'))
<div class="row" id="flash_danger">
    <br>
    <br>
    <br>
    <div class="col-lg-6 col-md-6 col-md-offset-3">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon-ok"></i>
            <strong>¡Error!</strong>
            <br/>{{ Session::get('flash_danger') }}<br>
        </div>
    </div>
</div>
@endif
<!-- check for flash error message -->
@if (Session::has('flash_error'))
<div class="row" id="flash_danger">
    <br>
    <br><br>
    <div class="col-lg-6 col-md-6 col-md-offset-3">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon-ok"></i>
            <strong>¡Error!</strong>
            <br/>{{ Session::get('flash_error') }}<br>
        </div>
    </div>
</div>
<br>
<br>@endif
<script type="text/javascript">
    function loadmessage() {
        setTimeout(function () {
            $('#flash_success').fadeOut('fast');
            $('#flash_info').fadeOut('fast');
            $('#flash_warning').fadeOut('fast');
            $('#flash_danger').fadeOut('fast');
        }, 4000);
    }
    loadmessage();
</script>
