                <h1><?php
                    if($var['pInfo'][2] == 0)
                        echo 'The ' . $var['pInfo'][3] . ' Patrol';
                    else
                        echo $var['pInfo'][3];
                ?></h1>
                <?php
                if($var['notOwnPatrol']) { ?>
                <div class="infobox">
                    <strong>Notice:</strong> you are currently viewing another patrol as if you were in
                    it yourself. You can also edit this patrol by clicking on a link to the left.
                    <a href="?page=patrols&amp;ownpatrol=1">Back to My Patrol</a>
                </div>
                <?php } ?>
                
                <p>
                    <?php echo BBC($var['pInfo'][4]); ?>  
                </p>
                
                <p>
                    - <a href="?page=announcements&page1=My Patrol">View My Patrol's Announcements</a>
                </p>