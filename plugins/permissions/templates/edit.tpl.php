        <h1>Permissions</h1>
        <p>
            This is a list of available permissions available. <strong>Permissions may not be deleted, since
            you will probably break the website if you delete them</strong>. Secondly,
            <span style="text-decoration:underline; font-weight:bold">Do not create new permissions unless you
            are creating a new plugin for the site and you know what you are doing!</span> In other words,
            unless you are editing the source code, <strong>Leave this page alone!</strong>
        </p>
        <div class="errbox">
           <strong>Notice:</strong> leave this page alone, unless you know what you are doing! 
        </div>
        
        <table class="pgs">
            <tr class="header">
                <td style="width:20px;font-weight: bold;">ID</td>
                <td style="width:200px;font-weight: bold;">Title</td>
                <td style="width:475px;font-weight: bold;">Description</td>
            </tr>
        <?php
        foreach($var['permissions'] as $arr)
        {
            echo '
            <tr>
                <td class="normalcell"><strong>', $arr[0], '</strong></td>
                <td class="normalcell"><a href="?action=edit&amp;id=', $arr[0], '">',  $arr[1], '</a></td>
                <td class="normalcell">', $arr[2], '</td>
            </tr>';
        
        }
        
        ?>
        </table>