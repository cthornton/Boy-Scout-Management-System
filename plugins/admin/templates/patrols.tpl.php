                <h1>Patrols</h1>
                <p>
                    Select a patrol to view its information. You will see information like
                    patrol announcements, patrol roster etc. that others cannot normally see unless
                    they are in the patrol themselves. You will also be given the ability to edit the
                    patrol and post announcements once you click on the link. If you want, you may also
                    <a href="?page=admin&amp;page1=Patrols&amp;page2=createpatrol" title="Create a New Patrol">
                        Create a Patrol
                    </a>
                </p>
                
                <?php
                    if(count($var['patrols']) > 0)
                    {
                        $tmp = false;
                        $special = false;
                        
                        echo '
                <ul>';
                
                        foreach($var['patrols'] as $arr)
                        {
                            if($arr[2] == 0 && !$tmp)
                            {
                                echo '
                <strong>Normal Patrols</strong><br>';
                                $tmp = true;
                            }
                            
                            if($arr[2] == 1 && !$special)
                            {
                                echo '
                <strong>Special Patrols</strong><br>';
                                
                                $special = true;
                            }
                        
                            echo '
                    <li><a href="?page=patrols&amp;pid=', $arr[0], '">', $arr[1], '</a></li>';
                
                        }
                        
                        
                        echo '
                </ul>';
                
                    } else {
                        echo '
                <p>
                    <em>Sorry, we did not find any patrols in the database. You might consider
                    <a href="?page=admin&amp;page1=Patrols&amp;page2=createpatrol" title="Create a New Patrol">creating one</a>.</em>
                </p>';
                    }