            <h1>Edit a Group</h1>
            <?php if($var['created']) { ?>
            <p>
                 <span style="font-weight:bold;color:#009900">Group was successfuly updated</span>
            </p>
            <?php } ?>
            
            
            
            <form action="?page=admin&amp;page1=Groups&amp;page2=<?php echo $var['gid']; ?>" method="post">
                <div class="iesucks">
                    <label for="name">Name</label>
                    <input type="text" name="name" size="40" value="<?php echo $var['gName']; ?>">
                </div>
                
                <div class="iesucks">
                    <label for="descript">Description</label>
                    <textarea rows="4" cols="80" name="descript"><?php echo $var['description']; ?></textarea>
                </div>
                
                <?php if($var['canEditGroups']) { ?>
                <div class="iesucks">
                    <label for="scrollmenu">Permissions</label>
                    <div class="scrollmenu">
                         <ul>
                         <?php
                              foreach($var['permissions'] as $arr)
                              {
                                   echo '
                              <li title="', $arr[2], '"><input type="checkbox" name="p', $arr[0], '" style="float:none;"';
                                   
                                   if(in_array($arr[0], $var['gpermissions']) || $var['gid'] == 1 || $_POST['p' . $arr[0]] == 1)
                                        echo ' checked="checked"';
                                   
                                   if($var['gid'] == 1)
                                        echo ' disabled="disabled"';
                                   
                                   echo ' value="1"> ', $arr[1], '</li>';
                                   
                              }
                         ?>
                         
                         </ul>
                    </div>
               </div>
               <div class="iesucks"> 
                <hr style="width: 400px;margin-left: 120px;">
               </div>
               <div class="iesucks">
                    <label for="interactive">Interactive</label>
                    <input type="checkbox" name="interactive" value="1"<?php if($var['isInteractive']) echo ' checked="checked"'; ?> >
               </div>
                
               <?php } ?>
                    
                <div class="iesucks">
                    <label for="submit">&nbsp;</label>
                    <input type="submit" name="submit" value="Modify">
                    <?php if($var['isSpecial'] == 0) {?>
                    <input type="submit" name="submit" value="Delete" onclick="javascript:return confirm('Are you sure you want to delete this group?')">
                    <?php } ?>
                </div>
            </form>
            
            <p>
                <a href="?page=admin&amp;page1=Groups">Back</a>
            </p>