<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Scorify</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<script src="https://kit.fontawesome.com/2ae0411939.js"></script>
<style type="text/css">
    @font-face {
        font-family: Poppins-Regular;
        src: url('fonts/poppins/Poppins-Regular.ttf'); 
    }

    @font-face {
        font-family: Poppins-Bold;
        src: url('fonts/poppins/Poppins-Bold.ttf'); 
    }

    @font-face {
        font-family: Poppins-Medium;
        src: url('fonts/poppins/Poppins-Medium.ttf'); 
    }

    @font-face {
        font-family: Montserrat-Bold;
        src: url('fonts/montserrat/Montserrat-Bold.ttf'); 
    }

    *{
        margin: 0px; 
        padding: 0px; 
        box-sizing: border-box;
    }

    body, html {
        height: 100%;
        font-family: Poppins-Regular, sans-serif;
    }

    p {
	    font-family: Poppins-Regular;
	    font-size: 14px;
	    line-height: 1.7;
	    color: #666666;
	    margin: 0px;
    }

    input:focus::-webkit-input-placeholder { color:transparent; }
    input:focus:-moz-placeholder { color:transparent; }
    input:focus::-moz-placeholder { color:transparent; }
    input:focus:-ms-input-placeholder { color:transparent; }

    textarea:focus::-webkit-input-placeholder { color:transparent; }
    textarea:focus:-moz-placeholder { color:transparent; }
    textarea:focus::-moz-placeholder { color:transparent; }
    textarea:focus:-ms-input-placeholder { color:transparent; }

    input::-webkit-input-placeholder { color: #999999; }
    input:-moz-placeholder { color: #999999; }
    input::-moz-placeholder { color: #999999; }
    input:-ms-input-placeholder { color: #999999; }

    textarea::-webkit-input-placeholder { color: #999999; }
    textarea:-moz-placeholder { color: #999999; }
    textarea::-moz-placeholder { color: #999999; }
    textarea:-ms-input-placeholder { color: #999999; }

    button {
        outline: none !important;
        border: none;
        background: transparent;
    }

    button:hover {
        cursor: pointer;
    }

    .container-login {
        width: 100%;  
        min-height: 100vh;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 15px;
        background: #9053c7;
        background: -webkit-linear-gradient(-135deg, #c850c0, #4158d0);
        background: -o-linear-gradient(-135deg, #c850c0, #4158d0);
        background: -moz-linear-gradient(-135deg, #c850c0, #4158d0);
        background: linear-gradient(-135deg, #c850c0, #4158d0);

        /* background-image:url("assets/images/background.jpg");
        background-repeat: no-repeat;
        background-size: auto; */
        
    }

    .wrap-login {
        width: 920px;
        /* background: #fff; */
        border-radius: 10px;
        overflow: hidden;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 177px 130px 33px 95px;

        background-color: rgba(0,0,0,0.6);
        box-shadow: 0 0 10px #000;
    }
    
    .text-center {
        font-family: Poppins-Bold;
        font-size: 24px;
        color: white;
        line-height: 1.2;
        text-align: center;
        width: 100%;
        display: block;
        padding-bottom: 54px;
    }

    .form-group {
        position: relative;
        width: 100%;
        z-index: 1;
        margin-bottom: 10px;
    }

    .form-control {
        font-family: Poppins-Medium;
        font-size: 15px;
        line-height: 1.5;
        color: #666666;
        display: block;
        width: 100%;
        background: #e6e6e6;
        height: 50px;
        border-radius: 25px;
        padding: 0 30px 0 68px;
    }

    .focus-form-control {
        display: block;
        position: absolute;
        border-radius: 25px;
        bottom: 0;
        left: 0;
        z-index: -1;
        width: 100%;
        height: 100%;
        box-shadow: 0px 0px 0px 0px;
        color: rgba(87,184,70, 0.8);
    }

    .form-control:focus + .focus-form-control {
        -webkit-animation: anim-shadow 0.5s ease-in-out forwards;
        animation: anim-shadow 0.5s ease-in-out forwards;
    }

    @-webkit-keyframes anim-shadow {
        to {
            box-shadow: 0px 0px 70px 25px;
            opacity: 0;
        }
    }

    @keyframes anim-shadow {
        to {
            box-shadow: 0px 0px 70px 25px;
            opacity: 0;
        }
    }

    .symbol {
        font-size: 15px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
        position: absolute;
        border-radius: 25px;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding-left: 35px;
        pointer-events: none;
        color: #666666;
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
    }

    .form-control:focus + .focus + .symbol{
        color: #57b846;
        padding-left: 28px;
    }

    .form-group-button {
        width: 100%;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding-top: 20px;
    }

    .btn {
        font-family: Montserrat-Bold;
        font-size: 15px;
        line-height: 1.5;
        color: #fff;
        text-transform: uppercase;
        width: 100%;
        height: 50px;
        border-radius: 25px;
        background: #57b846;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0 25px;
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        -moz-transition: all 0.4s;
        transition: all 0.4s;
    }

    .btn:hover {
        background: #333333;
    }
</style>
</head>
<body>
    <div class="login-form" style="width: 100%; margin: 0 auto">
        <div class="container-login">
            <div class="wrap-login">
                <div class="image" style="width: 375px" data-tilt>
                    <img src="assets/images/scorify.png" alt="IMG" style="max-width: 100%">
                </div>
        
                <form class="login-form" style="width: 290px" action="<?php echo base_url('do_login'); ?>" method="post">
                    <?php $errors_validation = session()->getFlashdata('scorify.errors_validation_login'); ?>
                    <h2 class="text-center" style="margin: 0px">SCORIFY</h2>       
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" required="required" name="email" style="outline: none; border: none">
                        <span class="focus"></span>
                        <span class="symbol">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                        <p>
                            <?php if ($errors_validation) {
                                echo '*'.$errors_validation['email'];
                            } ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" required="required" name="password" style="outline: none; border: none">
                        <span class="focus"></span>
                        <span class="symbol">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                        <p>
                            <?php if ($errors_validation) {
                                echo '*'.$errors_validation['password'];
                            } 
                            $errors_login = session()->getFlashdata('scorify.errors_login');
                            if($errors_login){
                                echo '*'.$errors_login;
                            }
                            ?>
                        </p>            
                    </div>
                    <div class="form-group-button">
                        <button type="submit" class="btn btn-primary btn-block">Log in</button>
                    </div> 
                    <div class="text-center p-t-12"></div>
                    <div class="text-center p-t-136"></div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>         