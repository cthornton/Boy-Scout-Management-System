            <h1>Create a Group</h1>

            <?php if($var['created']) { ?>
            <p>
                 <span style="font-weight:bold;color:#009900">Group was successfuly created</span>
            </p>
            <?php } ?>
            
            
            <form action="?page=admin&amp;page1=Groups&amp;page2=Create" method="post">
                <div class="iesucks">
                    <label for="name">Name</label>
                    <input type="text" name="name" size="40">
                </div>
                
                <div class="iesucks">
                    <label for="descript">Description</label>
                    <textarea rows="4" cols="80" name="descript"></textarea>
                </div>
                
                <div class="iesucks">
                    <label for="submit">&nbsp;</label>
                    <input type="submit" name="submit" value="Create">
                </div>
            </form>
            
            <p>
                <a href="?page=admin&amp;page1=Groups">Back</a>  
            </p>