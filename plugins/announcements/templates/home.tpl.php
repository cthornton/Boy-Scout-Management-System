                        <?php
                        // Requirement!
                        $users = new users();
                        ?>
                        <h1><?php echo $var['ltitle']; ?></h1>
                        <p>
                            These are the last 20 announcements posted. You may view
                            other types of announcements by selecting a link from the
                            menu to the left.
                        </p>
                        
                        
                        
                        <?php
                        $num = count($var['announcements']);
                        $i = 0;
                        
                        if(count($var['announcements']) > 0)
                        {
                            
                            foreach($var['announcements'] as $arr) {?>
                        
                        <div class="annContainer">
                            <div class="tContainer"><a name="a-<?php echo $arr[0]; ?>"></a><?php echo $arr[2]; ?></div>  
                            <div class="pContainer">By <?php echo $users->getParsedNameByID($arr[1]); ?> on <?php echo date("n/j/Y", $arr[3]); ?>
                            
                            <?php if($var['hasPremission']) {?>[ <a href="?page=announcements&amp;action=edit&amp;id=<?php echo $arr[0]; ?>">Edit</a> ] <?php } ?></div>
                            <div class="cContainer">
                                <?php echo BBC($arr[4]); ?>
                            </div>
                        </div>
                        <?php
                        $i++;
                        //if($num != $i) echo '<div class="hr"></div>'; ?>
                        
                        
                        <?php
                            }
                        } else { ?>
                        <p>
                            <em>No announcements were found :(</em>
                        </p>
                        <?php  }
                        if($var['hasPremission'])
                        {
                            echo'
                        <p>
                            - <a href="?page=admin&amp;page1=Announcements">Create Announcement</a>
                        </p>';
                        }
                        
                        if($var['isPatrol']) {?>
                            <div class="note">
                                <a href="?page=patrols">My Patrol Home</a> &bull; <a href="?page=announcements">Troop Announcements</a>
                            </div>
                        
                        <?php } ?>
                        

                        