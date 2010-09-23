            <?php
                $numWeeks = ceil($var['daysInMonth'] / 7);
                $firstDay = $var['firstDay'];
                
                //die(var_dump($var['events']));
            
            
                function getEvents($day, $var)
                {
                    $tmp = array();
                    
                    for($i = 0; $i < count($var['events']); $i++)
                    {
                        //var_dump($var['events'][$i]);
                        if($var['events'][$i][1] == $day)
                            $tmp[] = $var['events'][$i];
                    }
                    
                    for($i = 0; $i < count($var['revents']); $i++)
                    {
                        if($var['revents'][$i][1] == $day)
                            $tmp[] = $var['revents'][$i];
                    }
                    
                    return $tmp;
                }
            ?>
            <h1><?php echo $var['monthstr'], ' ', $var['year']; ?></h1>
            <br>
            <table id="calendar">
                <tr class="header">
                    <td>Sun</td>
                    <td>Mon</td>
                    <td>Tues</td>
                    <td>Wed</td>
                    <td>Thurs</td>
                    <td>Fri</td>
                    <td>Sat</td>
                </tr>
            
            <?php
            
            $currDay = 1 - $firstDay;
            
            // Rows
            for($i = 0; $i < $numWeeks; $i++)
            {
                echo '
                <tr class="days">';
                
                // Days
                for($j = 0; $j < 7; $j++)
                {
                    echo '
                    <td';
                    
                    if($currDay >= 1 && $currDay <= $var['daysInMonth'])
                    {
                        if($currDay == date('j') && $var['month'] == date('n'))
                            echo ' class="today" title="Today">';
                        else
                            echo ' class="d">';
                        echo '<div class="n">', $currDay, '</div>';
                        
                        /**
                         * Get the data!
                         */
                        $events = getEvents($currDay, $var);
                        
                        //var_dump($events);
                        
                        if( count($events) != 0)
                        {
                            
                            //var_dump($events);
                            echo '
                            <div>
                                <ul>';
                            foreach($events as $arr)
                            {
                                $div = !empty($arr[4]) ? ('r' . $arr[4]) : ('e'. $arr[0]); 
                                echo '
                                    <li>
                                        <a href="#" onmouseover="show(\'', $div, '\')" onmouseout="hide(\'', $div, '\')" onclick="return false" class="l">', $arr[2], '</a>
                                        <div id="', $div, '" class="info">', BBC($arr[3]), '</div>';
                                        
                                        if($var['canEdit'])
                                            echo '
                                            <a href="?page=calendar&amp;page1=Add Event&amp;page2=', $arr[0], '" class="editlink" title="Edit this Event">*</a>';
                                    
                                    echo '</li>';
                            }
                            
                            echo '
                                </ul>
                            </div>';
                        }
                        
                    }
                    else
                        echo '>';
                    
                    echo '
                    </td>';
                    
                    $currDay++;
                }
                
                echo '
                </tr>';
            }
            
            ?>
            </table>
            
            <div id="calfooter">
                <div class="calfootside">
                    <?php
                    if($var['month'] > 1)
                        echo '<a href="?page=calendar&amp;month=', ($var['month'] - 1) , '&amp;year=', $var['year'], '">&lt; Previous Month</a>';
                    else
                        echo '&nbsp;';
                    ?>
                </div>
                
                <div class="calfootmid" style="text-align:center">
                    <form method="get">
                        <input type="hidden" name="page" value="calendar">
                        
                        <select name="month">
                            <?php
                            for($i = 1; $i <= 12; $i++)
                            {
                                echo '
                            <option value="', $i, '"';
                                if($i == $var['month'])
                                    echo ' selected="selected"';
                                echo '>', date('F', mktime(0, 0, 0, $i, 1, $var['year'])), '</option>';
                            }
                            ?>
                        </select>
                            
                        <select name="year">
                            <?php
                            $yr = $var['year'] - 3;
                            
                            for($i = 0; $i < 7; $i++)
                            {
                                echo '
                            <option value="', $yr + $i, '"';
                                if($yr + $i == $var['year'])
                                    echo ' selected="selected"';
                                    
                                echo '>', $yr + $i, '</option>';
                            }
                            ?>
                        
                        </select>
                        
                        <input type="submit" name="submit" value="Go">
                        
                    </form>
                    
                    <a href="?page=calendar&amp;month=<?php echo date('n'); ?>&amp;year=<?php echo date('Y'); ?>">Today</a>
                    
                    
                </div>
                
                <div class="calfootside" style="text-align: right">
                    <?php
                    if($var['month'] < 12)
                        echo '<a href="?page=calendar&amp;month=', ($var['month'] + 1) , '&amp;year=', $var['year'], '">Next Month &gt;</a>';
                    else
                        echo '&nbsp;'
                    ?>
                </div>
            </div>