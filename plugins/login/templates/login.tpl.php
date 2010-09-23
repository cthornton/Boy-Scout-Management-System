                <h1>Login</h1>
                <?php
                if(isset($var['logerr']))
                {
                    echo '
                <div class="errbox">
                <p>
                    <strong>Invalid username or password</strong>. Your IP has used ', $var['numlogs'] + 1, ' login
                    attempts. Once you have reached 5, your IP will be prevented from logging in for 15 minutes.
                </p>
                </div>';
                }
                
                if($var['ipblocked'])
                {
                    echo '
                <div class="errbox">
                <p>
                    Your IP is blocked from logging in for 15 minutes. This is to prevent
                    <acronym title="When someone keeps on guessing a password to gain access">brute force</acronym>
                    password guessing. If there are too many login attempts from too many IP addresses,
                    your account will be locked out.
                </p>
                </div>';
                } else {
                    ?>
                
                <form action="?page=login" method="post">
                    <div class="iesucks">
                        <label for="user">Username</label>
                        <input type="text" name="user" size="40">
                    </div>
                    
                    <div class="iesucks">
                        <label for="pass">Password</label>
                        <input type="password" name="pass" size="40">
                    </div>
                    
                    <div class="iesucks">
                        <label for="submit">&nbsp;</label>
                        <input type="submit" name="submit" value="Login">
                    </div>
                </form>
                
                    <?php
                }
                ?>