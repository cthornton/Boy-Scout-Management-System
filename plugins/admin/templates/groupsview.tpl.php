            <h1>Groups</h1>
            <p>
                Groups are seperated into two categories, <em>Special</em> and <em>Non-Special</em>. Special groups
                give others premissions to access certian features, such as administration. These groups cannot be
                created or deleted. In contrast, there are non-special groups which can be created or deleted. These
                groups are meant to let people know who has what position. In addition, the groups may be used to restrict
                visibility for file downloads and the calendar.
            </p>
            
            <table>
                    <?php
                    $special = 2;
                    
                    foreach($var['allgroups'] as $arr)
                    {
                        if($arr[3] != $special)
                        {
                            echo '
                        <tr>
                            <td colspan="2" class="header">';
                            
                            if($arr[3] == 1)
                                echo 'Special Groups';
                            else
                                echo 'Non-Special Groups';
                            
                            echo '
                            </td>
                        </tr>';
                        
                        $special--;
                        
                        }
                        echo '
                        <tr>
                            <td class="normalcell" style="width:450px">', $arr[1], '</a></td>
                            <td class="normalcell" style="width:100px"><a href="?page=admin&amp;page1=Groups&amp;page2=', $arr[0], '">Modify</a>
                        </tr>';
                    }
                    
                    echo '
                    </table>';
                    
                    ?>
            <p>
                - <a href="?page=admin&amp;page1=Groups&amp;page2=Create">Create a new Group</a>
                    