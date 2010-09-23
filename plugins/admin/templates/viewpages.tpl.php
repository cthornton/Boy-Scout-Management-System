            <h1>Modify or Delete a Page</h1>
            <p>
                Select a page from below to edit it. You can also press the "delete" button
                to delete the page. Note that you cannot undo a delete. Any subpages that are associated
                with a page will also be deleted.
            </p>
            <table class="pgs">
                <tr class="header">
                    <td class="cell1" colspan="2">Name</td>
                </tr>
                <tr>
                    <td class="invisible1"></td>
                    <td class="invisible2"></td>
                </tr>
            <?php
            if(is_array($var['allLinks']))
            {
                foreach($var['allLinks'] as $arr)
                {
                    echo '
                <tr>
                    <td class="normalcell">';
                    if($arr[2] != 0)
                        echo '<ul><li>';
                    
                    echo '<a href="?page=admin&amp;page1=Edit Pages&amp;page2=', $arr[3], '">', $arr[0], '</a>';
                    if($arr[2] != 0)
                        echo '</li></ul>';
                    
                    echo '</td>
                    <td class="normalcell"><a href="?page=admin&amp;page1=Edit Pages&amp;page2=', $arr[3], '&amp;action=delete"
                        onclick="return confirm(\'Are you sure you want to delete this page permanetly?\')">Delete</a></td>
                </tr>';
                }
            }
            ?>
            </table>