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
                echo '<p style="font-weight:bold;color:#009933">'; if($var['editmode']) echo 'Event updated!'; else echo 'New Event Created!'; echo '</p>';
            }
            ?>

            <script type="text/javascript">
            <!--
            var cal2 = new CalendarPopup();
            cal2.showYearNavigation();
            // -->
            </script>

            
            <p>
                Enter the information below to ammend the calendar.
            </p>
            
            <form method="post" action="?page=calendar&amp;page1=Add Event<?php if($var['editmode']) echo '&amp;page2=', $var['eid']; ?>">
            <div class="iesucks">
                <label for="month">Date</label>
                <input type="text" name="date" value="<?php echo $var['date']; ?>" onclick="cal2.select(document.forms[0].date, 'anchor', 'MM/dd/yyyy');">
                <a name="anchor" id="anchor"></a>

            </div>
            
            <div class="iesucks">
                <label for="title">Title</label>
                <input type="text" name="title" value="<?php echo $var['eTitle']; ?>" style="width:125px;" maxlength="20">
            </div>
            
            <div class="iesucks">
                <label for="desc">Description</label>
                <textarea name="desc" class="txtinput"><?php echo $var['descript']; ?></textarea>
            </div>
            
            <div class="iesucks">
                <label for="repeats">Repeats</label>
                <input type="checkbox" name="repeats"<?php if($var['repeats']) echo ' checked="checked"'; ?> title="Set whether this event repeats or not"  value="1">
                
                <!-- Repeat Type -->
                <select name="repeattype" style="margin-left:8px;margin-right:5px;">
                    <option value="1"<?php if($var['rtype'] == 1) echo ' selected="selected"'; ?> title="Have the event occur every day">Daily</option>
                    <option value="2"<?php if($var['rtype'] == 2) echo ' selected="selected"'; ?> title="Have the event occur once a week">Weekly</option>
                    <option value="3"<?php if($var['rtype'] == 3) echo ' selected="selected"'; ?> disabled="disabled" title="Disabled due to technical issues">Monthly</option>
                </select>
                
                <!-- Repeat Length -->
                <div style="float: left; margin-left: 3px; margin-right: 5px;">for</div>
                <select name="repeatlen" style="margin-right:4px;" title="Set the length for how long this event repeats">
                <?php
                    for($i = 1; $i < 13; $i++)
                    {
                        echo '
                    <option value="', $i, '"';
                        if($i == $var['repeatlen'])
                            echo ' selected="selected"';
                        
                        echo '>', $i, '</option>';
                    }
                ?>
                </select>
                
                <div style="float: left; margin-left: 3px; margin-right: 5px;">time(s)</div>
                
            </div>
            
            <div class="iesucks">
                <label for="submit">&nbsp;</label>
                <input type="submit" name="submit" value="<?php if($var['editmode']) echo 'Modify'; else echo 'Create'; ?>">
                <?php if($var['editmode']) { ?>
                    <input type="submit" name="submit" value="Delete"
                           onclick="return confirm('Are you sure you want to delete this event?')">
                <?php } ?>
            </div>
            