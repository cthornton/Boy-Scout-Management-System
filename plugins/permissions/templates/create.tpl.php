            <h1>Create a New Permission</h1>
            <p>
                This creates a new permission. <strong>Again, don't do anything with this page unless you know what you are doing!</strong>  
            </p>
            <?php
            if($var['success'])
                echo '
            <div class="infobox">
                A new premission has been created. See the list of permissions for it\'s ID.
            </div>';
            
            if($var['error'])
            {
                echo '
            <div class="errbox">
                Looks like you missed a field. Please try again!
            </div>';
            }
            
            ?>
            
            <form action="?page=permissions&amp;page1=Create New Permission" method="post">
                
                <div class="iesucks">
                    <label for="name">Name</label>
                    <input type="text" name="name" size="30" value="<?php echo htmlentities($_POST['name']); ?>">
                </div>
                
                <div class="iesucks">
                    <label for="name">Description</label>
                    <input type="text" name="descript" class="inputbox" value="<?php echo htmlentities($_POST['descript']); ?>">
                </div>
                
                <div class="iesucks">
                    <label for="submit">&nbsp;</label>
                    <input type="submit" name="submit" value="Create">
                </div>
            
            </form>