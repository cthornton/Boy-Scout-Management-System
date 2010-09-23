            <?php
            function numToPhone($phone)
            {
                return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3)
                     . '-' . substr($phone, 6, 4);
                    
            }
            
            if(!$var['viewingpatrol']) { ?>
            <h1>Troop Roster</h1>
            <p>
                This is a list of everyone who has registered with this website. You may click on
                a person's name for more information, such as their address and any groups they might
                be in. Everybody is sorted into patrols; you may select the patrol to just get a list of
                who is in that patrol.
            </p>
            <?php } else { ?>
            <h1>Patrol Roster</h1>
            <p>
                This is a list of everyone who is currently in the selected patrol. Select "Roster" to the left
                or select "View Troop Roster" below to view the troop roster.
            </p>
            <?php
            }
                if(count($var['allUsers']) > 0 && is_array($var['allUsers']))
                {
                    $idlast = -1;
                    
                    ?>
                    <table>
                    <?php
                    foreach($var['allUsers'] as $arr)
                    {
                        /**
                         * Take care of the patrol headers
                         */
                        if($arr[5] != $idlast && !$curr)
                        {
                            echo '
                        <tr>
                            <td colspan="3" class="header">';
                            
                            if($arr[5] == 0)
                                echo '<a href="?page=roster&amp;pid=', $arr[5], '" class="plink">Unassigned</a>';
                            else
                                echo '<a href="?page=roster&amp;pid=', $arr[5], '" class="plink">', $arr[6], '</a>';
                            
                            echo '
                            </td>
                        </tr>';
                        
                        $idlast = $arr[5];
                        
                        }
                        echo '
                        <tr>
                            <td class="normalcell"><a href="?page=roster&amp;page2=', $arr[0], '"';
                            if($arr[8] == $arr[0])
                                echo ' style="font-weight:bold" title="Patrol Leader"';
                            
                            echo '>', $arr[2], ', ', $arr[1], '</a></td>
                            <td class="normalcell"><a href="mailto:', $arr[3], '">', strlen($arr[3]) > 30 ? substr($arr[3], 0, 24) . '...' : $arr[3] , '</a></td>
                            <td class="normalcell">', numToPhone($arr[4]), '</td>
                        </tr>';
                    }
                    
                    echo '
                    </table>';
                    ?>
                    <p style="font-size:10px;font-style:italic;">
                        Note: <strong>Bolded</strong> users are Patrol Leaders.
                    </p>
                    <?php
                    if($var['viewingpatrol'])
                    {
                        echo '<p>';
                        if($_GET['callback'] == 'patrol')
                            echo '- <a href="?page=patrols">Back</a>';
                        else
                            echo '- <a href="?page=roster">Back</a>';
                        echo '</p>';
                    }
                    
                    echo '
                    <p>
                        <strong>Copy and paste</strong> the email addresses below in your favorite Email client to send out
                        a mass email.
                    </p>
                    <textarea rows="2" cols="60">';
                    foreach($var['allUsers'] as $arr)
                        echo $arr[3], '; ';
                    echo '</textarea>';
                    
                } else {
                    echo '
                    <p>
                        We could not find any users.'; if($var['viewingpatrol']) echo ' Perhaps you somehow selected a patrol that does not exist?';
                    echo '
                    </p>';
                }
                
                if($var['viewingpatrol'])
                    echo '
                    <div class="note">
                        <a href="?page=roster">View Troop Roster</a> &bull;
                        <a href="?page=patrols">My Patrol\'s Page</a>
                    </div>';
                else
                    echo '
                    <div class="note">
                        <a href="?page=patrols&amp;page1=Roster">My Patrol\'s Roster</a>
                    </div>';
            
            ?>