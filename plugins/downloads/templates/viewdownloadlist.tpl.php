            <h1>Downloads - <?php echo $var['cName']; ?></h1>
            <p>
                Click on a file to download it. Hover over its name to see the file name.
            </p>
            
            <?php if(count($var['downloads']) > 0) { ?>

            <table class="pgs">
                <tr class="header">
                    <td class="cell1" style="width:200px;">Name</td>
                    <td class="cell1" style="width:400px;">Description</td>
                    <td class="cell1" style="width:80px;">Size</td>
                </tr>
                <?php
                foreach($var['downloads'] as $arr)
                {
                    echo '
                <tr>
                    <td class="normalcell"><a href="?page=downloads&amp;download=', $arr[0], '" title="', $arr[2], '">', $arr[5], '</a>';
                        if($var['canEdit']) echo '<span style="font-size:11px;"> [ <a href="?page=downloads&page1=New Download&page2=', $arr[0], '">edit</a> ]</span>'; echo '</td>
                    <td class="normalcell">', $arr[6], '</td>
                    <td class="normalcell">';
                    
                    $kb = round($arr[4] / 1024, 2);
                    if($kb > 1024)
                        echo '', round($kb / 1024, 2), ' mb';
                    else
                        echo $kb, ' kb';
                    
                    echo '</td>
                </tr>';
                }
                
                ?>
                
            </table>
            <?php } else { ?>
            <p>
                <em>Currently, there are not any downloads in this category :(</em>
            </p>
            <?php } ?>
            
            <p>
                <a href="?page=downloads">Back</a>
            </p>