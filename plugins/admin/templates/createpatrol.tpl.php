                <h1>Create a Patrol</h1>
                <p>
                    <em>Note:</em> You need to later select a patrol leader via the "Roster" page. Once someone has joined
                    that patrol, view their patrol and select them as a patrol leader.
                </p>
                
                <?php
                if(isset($var['errors']))
                {
                    echo '
                <div class="errbox">
                <p class="errtxt">
                    There '; if(count($var['errors']) > 1) echo 'were errors'; else echo 'was an error'; echo ' in your submission.
                </p>
                
                <ul>';
                    
                    foreach($var['errors'] as $arr)
                        echo '<li>', $arr, '</li>';
                
                    echo '
                </ul>
                </div>';
                }
                
                ?>
                                
                <form method="post" action="?page=admin&amp;page1=Patrols&amp;page2=createpatrol">
                    <div class="iesucks">
                        <label for="name">Name</label>
                        <input type="text" name="name" size="40" value="<?php echo htmlentities($_POST['name']); ?>">
                    </div>
                    
                    <div class="iesucks">
                        <label for="desc">Description</label>
                        <textarea cols="80" rows="3" name="desc"><?php echo htmlentities($_POST['desc']); ?></textarea>
                    </div>
                    
                    <div class="iesucks">
                        <label for="submit">&nbsp;</label>
                        <input type="submit" name="submit" value="Create">
                    </div>
                    
                </form>
                
                <p>
                    <a href="?page=admin&amp;page1=Patrols">Back</a>  
                </p>