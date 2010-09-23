                <h1>Modify User</h1>
                <p>
                    You may modify the information below to make changes to the user. Any changes are immediate. Note that
                    only those with privledges (e.g. Webmaster) may change your group OR patrol.
                </p>
                
                <p>
                    You may also hover your mouse over some of the fields for more information.
                </p>
                
                <?php
                if(isset($var['errors']))
                {
                    echo '
                <div class="errbox">
                <p class="errtxt">
                   There were errors in your submission. Please try again.
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
                
                if($var['success'])
                    echo '
                <p>
                    <span style="font-weight:bold;color:#009900">Information Successfuly Updated</span>
                </p>';
                
                ?>
                
                
                <form method="post" action="?page=edituser<?php if(!empty($var['tUID'])) echo '&amp;uid='. $var['tUID']; ?>">
                    <div class="iesucks">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" size="40" title="Your first name" value="<?php echo $var['rfname']; ?>">
                    </div>
                    
                    <div class="iesucks">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" size="40" title="Your last name" value="<?php echo $var['rlname']; ?>">
                    </div>
                    
                    <div class="iesucks">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" size="40" title="Your phone number (in the format of '4445556666')" value="<?php echo $var['phone']; ?>">
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
                    
                     <?php if($var['privledged']) { ?>
                    <div class="iesucks">
                        <label for="patrol">Patrol</label>
                        <select name="patrol">
                            <option value="0" style="font-style:italic">No Patrol</option>
                            <optgroup label="Normal">
                                
                        <?php
                            $sp = false;
                            foreach($var['patrols'] as $arr)
                            {
                                if($arr[2] == 1 && !$sp)
                                {
                                    echo '
                            </optgroup>
                            <optgroup label="Special">';
                                    $sp = true;
                                }
                                echo '
                                    <option value="', $arr[0], '"';
                                
                                if($arr[0] == $var['pid'])
                                    echo ' selected="selected"';
                                
                                echo '>', $arr[1], '</option>'; 
                            }
                            
                            if($sp)
                                echo '
                            </optgroup>';
                        ?>
                            
                        </select>
                    </div>

                    <div class="iesucks">
                        <label>Groups</label>
                        <div class="chkcontain">
                        <?php
                            foreach($var['allgroups'] as $arr)
                            {
                                echo '
                                <div class="chk">
                                <input type="checkbox" name="g', $arr[0], '" value="1"';
                                if($arr[0] == 1 && !$var['is_admin'])
                                    echo ' disabled="disabled"';
                                
                                if(in_array($arr[0], $var['currgroups']))
                                    echo ' checked="checked"';
                                
                                echo '> <div class="chkbx">', $arr[1], '</div>
                                </div>';
                            }
                        ?>
                        
                        </div>
                    </div>
                    <?php } ?>

                    <div class="iesucks">
                        <strong>Leave these blank to keep the password the same.</strong>
                    </div>
                    
                    <div class="iesucks">
                        <label for="pass1">Password</label>
                        <input type="password" name="pass1" size="40" title="The password that you will use to login to the site with">
                    </div>
                    
                    <div class="iesucks">
                        <label for="pass2">Confirm</label>
                        <input type="password" name="pass2" size="40" title="A password conformation">
                    </div>
                    
                    
                    <div class="iesucks">
                        <label for="submit">&nbsp;</label>
                        <input type="submit" name="submit" value="Modify">
                        <?php if($var['canDelete']) { ?>
                        
                        <input type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure you wish to delete this user?')">
                        
                        <?php } ?>
                    </div>
                </form>
                
                <p>
                <a href="?page=roster&amp;page2=<?php echo $var['tUID']; ?>">Back</a>    
                </p>