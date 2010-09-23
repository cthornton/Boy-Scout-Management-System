            <h1>Edit Announcement</h1>
            <?php if($var['created']) { ?>
            <p>
                 <span style="font-weight:bold;color:#009900">Group was successfuly updated</span>
            </p>
            <?php } ?>
            
            
            <form action="?page=announcements&amp;action=edit&amp;id=<?php echo $var['aid']; ?>" method="post">
                <div class="iesucks">
                    <label for="name">Name</label>
                    <input type="text" name="name" size="40" value="<?php echo $var['aName']; ?>">
                </div>
                
                <div class="iesucks">
                    <label for="descript">Body</label>
                    <textarea rows="4" cols="80" name="descript"><?php echo $var['description']; ?></textarea>
                </div>
                
                <div class="iesucks">
                    <label for="submit">&nbsp;</label>
                    <input type="submit" name="submit" value="Modify">
                    <input type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this announcement?')">
                </div>
            </form>
            
            <p>
                <a href="?page=announcements">Back</a>  
            </p>