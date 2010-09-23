            <h1>Edit Categories</h1>
            <p>
                Select a category to edit or delete it.
            </p>
            
            <?php
            if(is_array($var['categories']))
            {
                echo '
            <ul>';
                foreach($var['categories'] as $arr)
                {
                    echo
                '<li><a href="?page=downloads&amp;page1=Edit Categories&amp;page2=', $arr[0], '" title="', $arr[3], '">', $arr[2], '</a></li>';
                }
                
                echo '
            </ul>';
            }
            else
            {
                echo '
                <p><em>No categories found!</em></p>';
            }
            ?>
            
            <p>
                - <a href="?page=downloads&amp;page1=Edit Categories&amp;page2=new">New Category</a>
            </p>