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
      <form action="?page=MyGroup&page1=Add / Edit Pages&page2=<?php echo $var['action']; ?>" method="post">
        <div class="iesucks">
          <label for="stitle">Link Title</label>
              <?php
                if($_GET['page2'] == 'edit' && $_GET['pid'] == 'HOME')
                {
                  echo '
              <input type="text" name="stitle" size="10" value="Home" disabled="disabled">';
                }
                else
                echo '
            <input type="text" name="stitle" size="10" value="', $var['linktitle'], '">';?>
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
          <label for="submit">&nbsp;</label>
          <input type="submit" name="submit" value="<?php echo $var['button']; ?>">
          <?php
          if($_GET['page2'] == 'edit' && $_GET['pid'] != 'HOME')
            echo '<input type="submit" name="submit" value="Delete" onClick="return confirm(\'Are you sure you want to delete this page?\')">';
          ?>
        </div>
      </form>
      
      <a href="?page=MyGroup&page1=Add / Edit Pages" style="float:left;clear:left;">Back</a>