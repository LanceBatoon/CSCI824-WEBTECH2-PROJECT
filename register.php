<?php
    session_start();
    if(!isset($_SESSION["invalidR"]))
    {
        $_SESSION["invalidR"] = null;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="./style.css">
        <title>
            LaLa Grocery Store | Register Now
        </title>
    </head>
    <body>
        <div class="regpage">
            <div class="regcontainer" id="regcontainer">
                <form name="fReg" action = "./registerauth.php" onsubmit = "return validation()" method = "POST"> 
                    <h1>Register</h1><br>
                    <div class="invalid">
                        <?php if ($_SESSION["invalidR"]): ?>
                            <em>User already exists</em>
                        <?php endif; ?>
                    </div>
                    <div class="inputfield">
                        <label>Enter Username: </label>
                        <input type = "text" id ="user" name  = "user" /> 
                        
                    </div>  
                    <div class="inputfield">
                        <label>Enter Password: </label>  
                        <input type = "password" id ="pass" name  = "pass" /> 
                        
                    </div>
                    <div class="inputfield">
                        <label>Confirm Password: </label>  
                        <input type = "password" id ="passC" name  = "passC" /> 
                        
                    </div> 
                    <div class="terms">
                        <input type="checkbox" id="terms">
                        <p>Terms & Conditions</p>
                        
                    </div>
                    <div class="submitButton">
                        <input type =  "submit" id = "btn" value = "Sign Up" />  
                    </div>
                </form> 
            </div>
        </div>
        <script>  
            function validation()  
            {  
                var id=document.fReg.user.value;  
                var ps=document.fReg.pass.value; 
                var psC=document.fReg.passC.value; 
                var cb=document.fReg.terms.checked;
                if(id.length=="" && ps.length=="" && psC.length=="") {  
                    alert("User Name and Password fields are empty");  
                    return false;  
                }  
                else  
                {  
                    if(id.length=="") {  
                        alert("User Name is empty");  
                        return false;  
                    }   
                    if(ps.length=="") {  
                        alert("Password field is empty");  
                        return false;  
                    } 
                    if(psC.length=="") {
                        alert("Confirm Password field is empty");
                        return false;
                    }
                    else if(ps != psC)
                    {
                        alert("Please enter the same password");
                        return false;
                    }
                    if(!cb)
                    {
                        alert("Please accept the terms & conditions");
                        return false;
                    }          
                }      
            }  
        </script>  
    </body>
</html>