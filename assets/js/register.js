$(document).ready(function() {
    
    $("#hideLogin").click(function() {
        $("#loginForm").hide();
        $("#registerForm").show();
        $(".hasAccountText").hide();
    });

    $("#hideRegister").click(function() {
        $("#loginForm").show();
        $("#registerForm").hide();
        $(".hasAccountText").show();
        $("#errorMessage").hide();
    });

});