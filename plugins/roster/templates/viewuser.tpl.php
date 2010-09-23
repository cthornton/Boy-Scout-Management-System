            <?php
            function numToPhone($phone)
            {
                return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3)
                     . '-' . substr($phone, 6, 4);
                    
            }
            
            ?>    
                <h1>Viewing information for <?php echo $var['user'][1]; ?></h1>
                
                <table>
                    <?php
                    if($var['canEdit'] || $var['uid'] == $var['id_user']) { ?>
                    
                    <tr>
                        <td class="left">Username</td>
                        <td class="usercell"><?php echo $var['user'][8]; ?></td>
                    </tr>
                    
                    <?php } ?>
                    
                    <tr>
                        <td class="left">Name</td>
                        <td class="usercell"><?php echo $var['user'][1], ' ', $var['user'][2]; ?></td>
                    </tr>
                    
                    <tr>
                        <td class="left">Email</td>
                        <td class="usercell"><a href="mailto:<?php echo $var['user'][0]; ?>"><?php echo $var['user'][0]; ?></a></td>
                    </tr>
                    <tr>
                        <td class="left">Phone</td>
                        <td class="usercell"><?php echo numToPhone($var['user'][3]); ?></td>
                    </tr>
                    <tr>
                        <td class="left">Address</td>
                        <td class="usercell"><?php echo $var['user'][4]; ?>, <?php echo $var['user'][5]; ?></td>
                    </tr>
                    <tr>
                        <td class="left">Patrol</td>
                        <td class="usercell"><?php
                        if(!empty($var['user'][7]))
                            echo $var['user'][7];
                        else
                            echo '<em>Unassigned</em>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="left">Groups</td>
                        <td class="usercell"><?php
                        $num = count($var['groups']);
                        
                        if($num != 0)
                        {
                            for($i = 0; $i < $num; $i++)
                            {
                                echo '<acronym title="', $var['groups'][$i][1], '">', $var['groups'][$i][0], '</acronym>';
                                if($i + 1 != $num)
                                    echo ',';
                                
                                echo ' ';
                            }
                        } else {
                            echo '<em>None</em>';
                        }
                        
                        ?></td>
                    </tr>
                </table>
                
                <p>
                    - <a href="?page=<?php if($_GET['return'] == 'mygroup') echo 'MyGroup&amp;page1=Roster'; else echo 'roster'; ?>">Back</a>
                    <?php
                        if($var['canEdit'] || $var['uid'] == $var['id_user'])
                            echo ' - <a href="?page=edituser&amp;uid=', $var['id_user'], '">Edit</a>';
                    ?>
                </p>