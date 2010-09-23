<?php
// Get an announcement or calendar evernt

require_once('sources/include.php');

if(!$is_logged)
    die('Go Away!');

$db = new db();

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Information</title>
    <link rel="stylesheet" type="text/css" href="ui/css/layout.css">
    <style type="text/css">
    <!--
    body { background-image: none; margin: 5px;}
    h1 { padding: 0px; margin: 0px; font-weight: bold;}
    -->
    </style>
</head>
<body onBlur="self.close()">
<?php
switch($_GET['mode'])
{
case 'calendar':
    
    // Load the recuring class!
    require_once(BASE_DIR . '/plugins/calendar/recuring.class.php');
    
    $db->query("SELECT * FROM calendar WHERE id=?", $_GET['id'], 'i');
    
    if($db->numRows() != 1)
    {
        echo '<h1>Error</h1><p>This announcement was not found!</p>';
    }
    else
    {
        $data = $db->easyArray();
        echo '
        <h1>', $data[4], ' - ', $data[1], '/', $data[2], '/', $data[3], '</h1>';

        if($data[6] == 1)
        {
            echo '
            <span style="font-size:10px;font-weight:bold;font-style:italics">This event is recuring</span>';
        }
        
        echo '
        <p>
            ', BBC($data[5]), '
        </p>';
        
        
        if($data[6] == 1)
        {
            $db->query("SELECT month, day, year FROM calendar_recuring WHERE id_cal=?", $_GET['id'], 'i');
            
            echo '
            <div id="footer-container">
                This event also occurs on ';
            
            $r = $db->numRows();
            $d = $db->easyMultiArray();
            
            for($i = 0; $i < $r; $i++)
            {
                echo $d[$i][0], '/', $d[$i][1], '/', substr($d[$i][2], 2);
                
                if($i != $r - 1)
                {
                    if($i == $r - 2)
                        echo ' and ';
                    else
                        echo ', ';
                }
                
            }
            echo '</div>';
        }
    }
    
break;
default:


$db->query("
            SELECT ID, title, content, time_posted, time_edited
            FROM `announcements`
            WHERE ID=? LIMIT 1", $_GET['id'], 'i');



if($db->numRows() != 1)
{
    echo '<h1>Error</h1><p>This announcement was not found!</p>';
}
else
{
    
    $data = $db->easyArray();
    
    echo '
    <h1>', $data[1], '</h1>
    <p>
        ', BBC($data[2]), '
    </p>
    <div id="footer-container">
        Created on ', date('n/j/y', $data[3]), '. Last edited on ', date('n/j/y', $data[4]), '
    </div>';
}

break;
} ?>

<p style="text-align:center;width:100%">
    <a href="#" onclick="window.close()" style="text-decoration:underline;">Close Window</a>
</p>

</body>
</html>