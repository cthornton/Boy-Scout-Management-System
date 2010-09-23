                <h1>Edit My Patrol</h1>
                <p>
                    If you can see this, you obviously have premission to edit this patrol. <strong>Be Careful</strong>, as
                    making any changes take effect immedately, including changing the patrol leader.
                </p>
                
                <?php
                if(count($var['errors']) > 0)
                {
                    echo '
                <div class="errbox">
                <p class="errtxt">
                    There were errors in your submission. Please fix them and try again.
                </p>
                
                <ul>';
                    foreach($var['errors'] as $arr)
                        echo '
                    <li>', $arr, '</li>';
                
                echo '
                </ul>
                </div>';
                }
                
                if($var['success'])
                    echo '
                    <p style="color:#009933;font-weight:bold">
                        The patrol information has been updated successfuly.
                    </p>';
                
                ?>
                <form method="post" action="?page=patrols&amp;page1=Edit Patrol">
                    
                    <div class="iesucks">
                        <label for="pname">Patrol Name</label>
                        <input type="text" name="pname" value="<?php if(!isset($_POST['submit'])) echo $var['pInfo'][1]; else echo htmlentities($_POST['pname']); ?>" size="40">
                    </div>
                    
                    <div class="iesucks">
                        <label for="desc">Description</label>
                        <textarea name="desc" rows="4" cols="80"><?php if(!isset($_POST['submit'])) echo $var['pInfo'][2]; else echo htmlentities($_POST['desc']); ?></textarea>
                    </div>
                    
                    <div class="iesucks">
                        <label for="pl">Patrol Leader</label>
                        <select name="pl">
                            <option value="0" style="font-style:italic">Nobody</option>
                        <?php
                        foreach($var['pUsers'] as $arr)
                        {
                            echo '
                            <option value="', $arr[0], '"';
                            
                            if($arr[0] == $var['pInfo'][0] && !isset($_POST['submit']) && $_POST['pl'] != $var['pInfo'][0])
                                echo ' selected="selected"';
                            else if($_POST['pl'] == $var['pInfo'][0])
                                echo ' selected="selected"';
                            
                            echo '>', $arr[1], ' ', $arr[2], '</option>';
                        }
                        ?>
                        </select>
                    </div>
                    
                    <div class="iesucks">
                        <label for="submit">&nbsp;</label>
                        <input type="submit" name="submit" value="Edit">
                        <?php if($var['canDelete']) { ?>
                        <input type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this patrol?!?')">
                        <?php } ?>
                    </div>
                    
                </form>