            <h1>Add &amp; Edit Pages</h1>
            
            <ul>
                <li><a href="?page=MyGroup&amp;page1=Add / Edit Pages&amp;page2=edit&amp;pid=HOME">Home</a></li>
            <?php
            foreach($var['mpages'] as $arr)
            {
                echo '<li><a href="?page=MyGroup&amp;page1=Add / Edit Pages&amp;page2=edit&amp;pid=', $arr[0], '">', $arr[1], '</a>';
            }
            ?>
            </ul>
            
            <a href="?page=MyGroup&amp;page1=Add / Edit Pages&amp;page2=new">New Page</a>

            <div class="note">
                <a href="?page=MyGroup">Back to main</a>  
            </div>