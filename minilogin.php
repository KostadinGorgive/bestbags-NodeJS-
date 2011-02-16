
<link rel="stylesheet" type="text/css" href="./styles/main.css" />
<div id="cards">
    <div class="spacer-50"></div>
    <div class="section_content">
       
       <p></p> 
       <p></p> 
       <p></p> 
    </a>
    
        <form class="styled-form" name="login" method="post" action="./login.php">
        <h2>LOGIN</h2>

            <?php
                switch ($loginError) {
                    case 1:
                        echo '<label class="error">This username doesn\'t exist.</label>';
                        break;
                    case 2:
                        echo '<label class="error">Wrong password.</label>';
                        break;
                    case 3:
                        echo '<label class="error">You don\'t have permission to log in to this page.</label>';
                        break;
                    case 4:
                        echo '<label class="error">Sorry, you have provided an invalid security code.</label>';
                        break;
                }
            ?>
            

            <label>
            Username:
            <input name="txtUser" type="text" class="formstyle" id="txtUser" placeholder="Enter username" required>
            </label>

            <label>
            Password:
            <input name="txtPass" type="password" class="formstyle" id="txtPass" placeholder="Enter password" required>
            </label>

            <label class="captcha">
            <img src="./captcha.php?width=100&height=40&characters=5" width="100px" height="40px" />
            <input name="security_code" type="text" class="captcha" id="security_code" maxlength="5" autocomplete="off" placeholder="Captcha" required>
            </label>

            <input style="width: 100%;" name="btnLogin" type="submit" class="btn btn-normal" id="btnLogin" value="Login" />
            <label class="rmbrme">
                <label>
                    <input name="remember" type="checkbox" class="checkbox" id="remember" <?php if ($remember) echo "checked ";?>/>
                    Remember Me 
                </label>

                <span style="margin: 5px 0px;"><a href="register.php" style="color: #0ba5ff;" class="sm-href">Don't have an account?</a></span>
                
            </label>
			<p></p>
			<h5><strong style="color:white;text-align: inherit;">Current Registration Status:<p style="color:green;">Open</p>Current Registration Fees:<p style="color:green;">FREE</p></h5>

            
        </form>

    
</div>

<div class="sm-info-crd" >
    <p class="para" style="margin: 0px;">Please contact us in <a href="https://t.me/majorshop77" style="color: #0ba5ff">Telegram</a> if you lost your account access</p>
</div>
       <p></p> 
       <p></p> 
       <p></p> 