            <h1>Categories</h1>
            <p>
                Select a category to view more downloads
            </p>

            <table class="pgs">
                <tr class="header">
                    <td class="cell1" style="width:150px;">Category</td>
                    <td class="cell1" style="width:300px;">Description</td>
                    <td class="cell1" style="width:80px;">Files</td>
                    <td class="cell1" style="width:150px;">Latest File</td>
                </tr>
                <tr>
                    <td class="normalcell"><a href="?page=downloads&amp;viewcat=NONE">Uncategorized</a></td>
                    <td class="normalcell">Anything that has not been given a categoty</td>
                    <td class="normalcell"><?php echo count($var['nocat']); ?></td>
                    <td class="normalcell"><a href="?page=downloads&amp;download=<?php echo $var['nocat'][0][0]; ?>" title="<?php echo $var['nocat'][0][1]; ?>"><?php echo shorten_word($var['nocat'][0][1], 23); ?></td>
                </tr>
                    
                <?php
                for($i = 0; $i < count($var['categories']); $i++)
                {
                    echo '
                <tr>
                    <td class="normalcell"><a href="?page=downloads&amp;viewcat=', $var['categories'][$i][0], '">', $var['categories'][$i][2], '</a></td>
                    <td class="normalcell">', $var['categories'][$i][3], '</td>
                    <td class="normalcell">', count($var['cinfo'][$i]), '</td>
                    <td class="normalcell"><a href="?page=downloads&amp;download=', $var['cinfo'][$i][0][0], '" title="', $var['cinfo'][$i][0][1], '">', shorten_word($var['cinfo'][$i][0][1], 23), '</td>
                </tr>';
                }
                
                ?>
                
            </table>
            
            <?php
            /*
            $currcat = -1;
            $catnum  = -1;
            foreach($var['downloads'] as $arr)
            {
                /**
                 * Take care of the categories!
                 *
                if($arr[1] != $currcat)
                {
                    $currcat = $arr[1];
                    $catnum++;
                    
                    echo '<div class="dlcat" title="';
                    
                    if($currcat == 0)
                        echo 'Uncategorized Downloads">Uncategorized';
                    else
                        echo ' title="', $var['categories'][$catnum][3], '">', $var['categories'][$catnum][2];
                    
                    echo '</div>';
                }
                
                echo '
                <li><a href="?page=downloads&amp;download=', $arr[0], '" title="', $arr[6], '">', $arr[5], '</a>';
                
                if($var['canEdit'])
                    echo ' (<a href="?page=downloads&amp;page1=New Download&amp;page2=', $arr[0], '">edit</a>)';
                
                echo '</li>';
            } */
            ?>