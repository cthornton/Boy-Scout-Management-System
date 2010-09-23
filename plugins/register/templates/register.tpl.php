                <h1>Create an Account</h1>
                <p>
                    Enter below the following information to create an account with this website.
                    <strong>Every field is required</strong>. Note that you also need a registration password to join this
                    website. This is to prevent random people from joining. If you do not know what this is,
                    please email the Webmaster or the Administrator.
                </p>
                
                <p>
                    You may also hover your mouse over some of the fields for more information.
                </p>
                
                <?php
                if(isset($var['errors']))
                {
                    echo '
                <div class="errbox">
                <p>
                    <span class="errtxt">There were errors in your submission. Please try again.</span>
                </p>
                <ul>';
                
                    foreach($var['errors'] as $arr)
                    {
                        echo '
                    <li>', $arr, '</li>';
                    }
                
                echo '
                </ul>
                </div>';
                }
                
                ?>
                
                
                <form method="post" action="?page=register">
                    <!-- Login Information -->
                    <div class="iesucks">
                        <h3>
                            <acronym title="Only you will be able to see this information.">
                                Login Information
                            </acronym>
                        </h3>
                    </div>
                    
                    <div class="iesucks">
                        <label for="login">Login</label>
                        <input type="text" name="login" size="40" title="Your unique 'username' that you will use to log in with" value="<?php echo $var['login']; ?>">
                    </div>
                    
                    <div class="iesucks">
                        <label for="pass1">Password</label>
                        <input type="password" name="pass1" size="40" title="The password that you will use to login to the site with">
                    </div>
                    
                    <div class="iesucks">
                        <label for="pass2">Confirm Password</label>
                        <input type="password" name="pass2" size="40" title="A password conformation">
                    </div>
                    
                    <!-- Personal Information -->
                    <div class="iesucks">
                        <h3>
                            <acronym title="This information will be visible to other users of the troop.">
                                Personal Information
                            </acronym>
                        </h3>
                    </div>
                    
                    <div class="iesucks">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" size="40" title="Your first name" value="<?php echo $var['fname']; ?>">
                    </div>
                    
                    <div class="iesucks">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" size="40" title="Your last name" value="<?php echo $var['lname']; ?>">
                    </div>
                    
                    <div class="iesucks">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" size="40" title="Your phone number (in the format of '4445556666')" value="<?php echo $var['phone']; ?>" maxlength="10">
                    </div>
    
                    <div class="iesucks">
                        <label for="address">Address</label>
                        <input type="text" name="address" size="40" title="Your address" value="<?php echo $var['address']; ?>">
                    </div>
    
                    <div class="iesucks">
                        <label for="city">City</label>
                        <input type="text" name="city" size="40" title="The city you live in" value="<?php echo $var['city']; ?>">
                    </div>
                    
                    <div class="iesucks">
                         <label for="email">Email</label>
                         <input type="text" name="email" size="40" title="It is okay if more than one person shares the same email address." value="<?php echo $var['email']; ?>">
                    </div>
                    
                    <!-- Registration Password -->
                    <div class="iesucks">
                        <h3>Registration Password</h3>
                    </div>
                    
                    <div class="iesucks">
                        <label for="regpass">&nbsp;</label>
                        <input type="password" name="regpass" size="40" title="The registration password">
                    </div>
                    
                    <div class="iesucks">
                        <label for="submit">&nbsp;</label>
                        <input type="submit" name="submit" value="Register" size="40" title="Create an account, assuming all of the fields you entered are valid.">
                    </div>
                </form>