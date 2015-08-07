'use strict';
$(document).ready(function () {

    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    );

    //--------------------------------------------------------------------
    // Se asocia al evento “click” una función anónima que redirige a login
    //--------------------------------------------------------------------
    $('#bt_iniciar_sesion').click(
        function () {
            window.location.href = url_login;
        });
     //--------------------------------------------------------------------
    // Se asocia al evento “click” una función anónima que redirige a login
    //--------------------------------------------------------------------
    $('#bt_iniciar_sesion_profesor').click(
        function () {
            window.location.href = url_login_profesor;
        });
     //--------------------------------------------------------------------
    // Se asocia al evento “click” una función anónima que redirige a login
    //--------------------------------------------------------------------
    $('#bt_iniciar_sesion_admin').click(
        function () {
            window.location.href = url_login_admin;
        });
    //--------------------------------------------------------------------
    $('#bt_registrarse').click(
        function () {
            window.location.href = url_register;
        });
    //--------------------------------------------------------------------
    $('#bt_cerrar_sesion').click(
        function () {
            window.location.href = url_logout;
        });
    //--------------------------------------------------------------------
    $('#bt_registrarsar_usuario').click(
        function () {
            window.location.href = url_usuarios;
        });
});