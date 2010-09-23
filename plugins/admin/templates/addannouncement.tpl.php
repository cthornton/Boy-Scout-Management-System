                <h1>New Announcement</h1>
                
                <?php
                if(isset($var['errors']))
                {
                    echo '
                <div class="errbox">
                <p class="errtext">
                    There '; if(count($var['errors']) > 1) echo 'were errors'; else echo 'was an error'; echo ' in your submission.
                </p>
                
                <ul>';
                    
                    foreach($var['errors'] as $arr)
                        echo '<li>', $arr, '</li>';
                
                    echo '
                </ul>
                </div>';
                }
                
                if($var['success'])
                    echo '
                    <p style="color:#009933;font-weight:bold">
                        You have successfully created a new announcement.
                    </p>';
                
                ?>
                                
                <form method="post" action="?page=admin&amp;page1=Announcements">
                    <div class="iesucks">
                        <label for="name">Title</label>
                        <input type="text" name="name" size="40" value="<?php echo $var['t']; ?>">
                    </div>
                    
                    <div class="iesucks">
                        <label for="body">Body</label>
                        <textarea cols="80" rows="3" name="body"><?php echo $var['body']; ?></textarea>
                    </div>
                    
                    <div class="iesucks">
                        <label for="submit">&nbsp;</label>
                        <input type="submit" name="submit" value="Create">
                    </div>
                    
                </form>