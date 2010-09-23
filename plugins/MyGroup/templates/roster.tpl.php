            <?php
            function numToPhone($phone)
            {
                return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3)
                     . '-' . substr($phone, 6, 4);
                    
            } ?>

            <h1>Group Roster</h1>
            <p>
                This is a list of everyone currently in this group. Click on their name for
                more information. If there is a checkmark next to a person's name, that means they are
                a leader of the group.
            </p>
            
            <?php
                if(count($var['allUsers']) > 0 && is_array($var['allUsers']))
                {
                    if($var['updated'])
                        echo '<div class="infobox">Group leaders updated.</div>';
                    
                    if($var['isLeader'])
                        echo '<form method="post" action="?page=MyGroup&amp;page1=Roster">';
                    
                    ?>
                    <table>
                        <tr>
                            <td colspan="4" class="header">&nbsp;</td>
                        </tr>
                    <?php
                    foreach($var['allUsers'] as $arr)
                    {
                        echo '
                        <tr>
                            <td class="normalcell"><a href="?page=roster&amp;page2=', $arr[0], '&amp;return=mygroup">', $arr[2], ', ', $arr[1], '</a></td>
                            <td class="normalcell"><a href="mailto:', $arr[3], '">', strlen($arr[3]) > 30 ? substr($arr[3], 0, 24) . '...' : $arr[3], '</a></td>
                            <td class="normalcell">', numToPhone($arr[4]), '</td>
                            <td class="normalcell" style="width:20px;"><input type="checkbox" name="l', $arr[0], '" value="1"';
                            if($arr[5] == 1 || ($var['isLeader'] && $_POST['l' . $arr[0]]))
                            {
                                if($_POST['l' . $arr[0]] != null || !isset($_POST['submit']))
                                    echo ' checked="checked" ';
                            }
                            if(!$var['isLeader'])
                                echo ' disabled="disabled"';
                        
                                echo '>
                        </tr>';
                    }
                    
                    echo '
                    </table>';
                    
                    if($var['isLeader'])
                    {
                        echo '
                            <p>
                                <input type="submit" name="submit" value="Modify">
                            </p>
                        </form>';
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
            
            ?>
            <div class="note">
                <a href="?page=MyGroup">Back to main</a>  
            </div>