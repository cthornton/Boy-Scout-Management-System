      <h1><?php echo $var['title']; ?></h1>
      <?php
      if(isset($var['POSTERR']))
      {
        echo '
        <div class="errbox">
          <p class="errtxt">
            You have some errors with your submission. Please review them and try again.
          </p>
          <ul>';
        foreach($var['POSTERR'] as $arr)
        {
          echo '<li>', $arr, '</li>';
        }
        
        echo '</ul>
        </div>';
      }
        echo $var['message'];
      ?>
      <noscript>
        <div class="errbox">
            <span class="errtxt">Javascript is required to view this page correctly.</span> You can still continue without
            Javascript if you wish; however, you need to know HTML to add content to this page.
        </div>
      </noscript>
      <script src="ui/js/editor.js" type="text/javascript"></script>
      <form action="?page=admin&amp;page1=<?php echo $var['action']; ?>" method="post">
        <div class="iesucks">
          <label for="stitle">Link Title</label>
            <input type="text" name="stitle" size="10" value="<?php echo $var['linktitle']; ?>">
        </div>
        <div class="iesucks">
          <label for="ltitle">Page Title</label>
              <input type="text" name="ltitle" class="inputbox" value="<?php echo $var['pagetitle']; ?>">
        </div>
       <div class="iesucks">
          <label for="content">Content</label>
            <textarea name="content" class="txtinput" id="tx" onclick="showEditor()"><?php echo $var['content']; ?></textarea>
        </div>
        <div class="iesucks">
          <label for="subpg">Subpage Of</label>
                <select name="subpg">
                        <option value="0" style="font-style: italic">None</option>
                        <?php
                        foreach($var['allLinks'] as $arr)
                        {
                            echo '
                        <option value="', $arr[2], '" ';
                          if($arr[2] == $var['subid'])
                            echo 'selected="selected"';
                            
                            echo '>', $arr[0], '</option>';
                        }
                        ?>
                
                    </select>
        </div>
        <div class="iesucks">
          <label for="hidden">Hidden</label>
            <input type="checkbox" name="hidden" value="1" <?php if($var['pghidden']) echo 'checked="checked"'; ?>>
        </div>
        <div class="iesucks">
          <label for="protected">Protected</label>
            <input type="checkbox" name="protected" value="1" <?php if($var['pgprotected']) echo 'checked="checked"'; ?>>
        </div>
        <div class="iesucks">
          <label for="submit">&nbsp;</label>
          <input type="submit" name="submit" value="<?php echo $var['button']; ?>">
        </div>
      </form>
      
      <?php
        if($_GET['page1'] == 'Edit Pages')
          echo '<a href="?page=admin&page1=Edit Pages" style="float:left;clear:left;">Back</a>';
      ?>