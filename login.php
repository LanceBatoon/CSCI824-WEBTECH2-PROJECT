<?php
    session_start();
    if(!isset($_SESSION["invalid"]))
    {
        $_SESSION["invalid"] = null;
    }
    include('connect.php'); 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./style.css">
        <title>
            LaLa Grocery Store | Login
        </title>
    </head>
    <body>
        <div class="loginpage">
            <div class="logcontainer" id="logcontainer">
                <form name="fLog" action = "./auth.php" onsubmit = "return validation()" method = "POST"> 
                    <h1>Login</h1><br>
                    <div class="invalid">
                        <?php if ($_SESSION["invalid"]): ?>
                            <em>Invalid Username Or Password</em>
                        <?php endif; ?>
                    </div>
                    <div class="inputfield">
                        <label>Enter Username: </label>
                        <input type = "text" id ="user" name  = "user" />  
                    </div>  
                    <div class="inputfield">
                        <label>Enter Password: </label>  
                        <input type = "password" id ="pass" name  = "pass" />
                        <img src="./Images/loginpage/hide.png" id="showimg" onclick = "showpass()"/>
                    </div>
                    <div class="spass"> 
                    </div>
                    <div class="forgot">
                        <label for="remember">
                            <input type="checkbox" id="remember">
                            <p>Remember Me</p>
                        </label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <div class="submitButton">
                        <input type = "submit" id = "btn" value = "Login" />  
                    </div>
                    <div class="register">
                        <p>Don't have an account? <a href="./register.php">Register Now</a></p>
                    </div>
                </form> 
            </div>
        </div>
        <script>  
            function validation()  
            {  
                var id=document.fLog.user.value;  
                var ps=document.fLog.pass.value;  
                if(id.length=="" && ps.length=="") {  
                    alert("User Name and Password fields are empty");  
                    return false;  
                }  
                else  
                {  
                    if(id.length=="") {  
                        alert("User Name is empty");  
                        return false;  
                    }   
                    if (ps.length=="") {  
                    alert("Password field is empty");  
                    return false;  
                    }  
                }                             
            } 
            let showimage = true;
            function showpass()
            {   
                const image = document.getElementById("showimg");
                
                if(showimage)
                {
                    image.src = "./Images/loginpage/show.png";
                }
                else
                {
                    image.src = "./Images/loginpage/hide.png";
                }
                showimage = !showimage;

                var p = document.getElementById("pass")
                if(p.type === "password")
                {
                    p.type = "text";
                }
                else
                {
                    p.type = "password";
                }
            }
        </script>  
    </body>
</html>