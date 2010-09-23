            <h1><?php echo $var['title']; ?></h1>
            
            <?php
            if($var['isError'])
            {
                echo '
            <div class="errbox">
                <p class="errtxt">There are errors in your submission. Please fix them and try again.</p>
                <ul>';
                foreach($var['errors'] as $arr)
                {
                    echo '
                    <li>', $arr, '</li>';
                }
                
                echo '
                </ul>
            </div>';
                
            }
            
            if($var['success'])
            {
                echo '<p style="font-weight:bold;color:#009933">'; if($var['editmode']) echo 'Category updated!'; else echo 'New Category Created!'; echo '</p>';
            }
            ?>

            
            <p>
                Enter the information below.
            </p>
            
            <form method="post" action="?page=downloads&page1=Edit Categories&amp;page2=<?php if($var['editmode']) echo '&amp;page2=', $var['eid']; else echo 'new'; ?>">
            
            <div class="iesucks">
                <label for="title">Title</label>
                <input type="text" name="title" value="<?php echo $var['eTitle']; ?>" style="width:40%;">
            </div>
            
            <div class="iesucks">
                <label for="desc">Description</label>
                <input type="text" name="desc" value="<?php echo $var['descript']; ?>" class="inputbox">
            </div>
            
            <div class="iesucks">
                <label for="submit">&nbsp;</label>
                <input type="submit" name="submit" value="<?php if($var['editmode']) echo 'Modify'; else echo 'Create'; ?>">
                <?php if($var['editmode']) { ?>
                    <input type="submit" name="submit" value="Delete"
                           onclick="return confirm('Are you sure you want to delete this category?')">
                <?php } ?>
            </div>
            
            <p>
                <a href="?page=downloads&amp;page1=Edit Categories">Back</a>
            </p>