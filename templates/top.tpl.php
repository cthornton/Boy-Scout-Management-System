<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <base href="<?php echo $const['url']; ?>">
    <title><?php echo $var['title']; ?> | <?php echo SITE_NAME; ?></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="ui/img/favicon.png">
    <link rel="stylesheet" type="text/css" href="ui/css/layout.css"><?php
    
    if($var['logged'])
        echo '
    <link rel="stylesheet" type="text/css" href="ui/css/loggedin.css">';
    
    if(is_array($var['customStylesheets']))
        foreach($var['customStylesheets'] as $arr)
            echo '
    <link rel="stylesheet" type="text/css" href="', $arr, '">';
?>

    <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="ui/css/IEFixes.css">
        <?php if($var['logged']) { ?>
        <link rel="stylesheet" type="text/css" href="ui/css/IELoggedinFixes.css">
        <?php } ?>
        
    <![endif]-->
    
    <script type="text/javascript" src="ui/js/functions.js"></script>
<?php
    if($var['loadCalendar'])
    {
        echo '
    <script type="text/javascript" src="ui/js/calendar.js"></script>
    <script type="text/javascript" src="ui/js/calpopup.js"></script>
    <script type="text/javascript" src="ui/js/ajax.js"></script>';
    }
?>
</head>
<body>

    
    <!-- Header -->

<div id="header">
    <div class="hcontain">
        <h1><?php echo SITE_NAME; ?></h1>
        
        <div id="usermenu-right"></div>
        
        <!-- Login Menu -->
        <div id="usermenu">
            <?php
            if($var['logged'])
            {
                echo 'Welcome, ', $var['fname'], '!';
                echo '
                     &bull; <a href="?page=login&amp;page1=Logout">Logout</a>';
            } else
                echo '
            <form method="post" action="?page=login">
                <div>
                    <label for="user">User:</label> <input type="text" name="user" id="user" class="loginfield">
                    <label for="pass">Pass:</label> <input type="password" name="pass" id="pass" class="loginfield">

                          <input type="submit" name="submit" value="Log In">
                </div>
            </form>';
                ?>
        
        </div>
        
    </div>
    
        <!-- Links -->
    <div id="linkbg">
    <div class="hcontain">
    <div id="links">
        
            <ul>
            <?php
                foreach($var['links'] as $arr)
                    echo '
                <li class="link"><a href="?page=', $arr[0] ,'" title="', $arr[1] ,'">', $arr[0] ,'</a></li>';
            
            if($var['logged'])
            {
                ?>
                    <li class="link"><a href="?page=calendar">Calendar</a></li>
                    <li class="link"><a href="?page=downloads">Downloads</a></li>
                    
                    <li class="link" >
                        <a href="#" onMouseOver="mopen('droplist');" onmouseout="mclosetime()">Information</a>
                        <div id="droplist" class="dropmenu" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
                            <ul>
                                <li><a href="?page=roster">Roster</a></li>
                                <li><a href="?page=patrols">My Patrol</a></li>
                                <li><a href="?page=announcements">Announcements</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <?php
                
                if(is_array($var['interGroups']) && count($var['interGroups']) > 0)
                {
                    ?>
                    <li class="link">
                        <a href="?page=MyGroups" onclick="return false" onmouseover="mopen('droplist2')" onmouseout="mclosetime()">My Groups</a>
                        <div id="droplist2" class="dropmenu" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
                            <ul>
                                
                                <?php
                                foreach($var['interGroups'] as $arr)
                                {
                                    echo '
                                <li><a href="?page=MyGroup&amp;id=', $arr[0], '">', $arr[1], '</a></li>';
                                }
                                ?>
                            
                            </ul>
                        </div>
                    </li>
                    <?php
                    
                }
                
                
            }
            else
                echo '<li class="link"><a href="?page=register">Register</a></li>';
            
            if($var['hasAdmin'])
                echo '<li class="link"><a href="?page=admin">Admin</a></li>';
            ?>
            </ul>
        </div>
    </div></div>
</div>
        
<div id="main">
    <div id="container">

        <div class="blank">&nbsp;</div>
        
        <!-- Middle -->
        <div id="middle">
            
            <!-- Left Content -->
            <div id="left-menu">
                <div class="link-header">
                    <?php
                    echo '
                    <a href="?page=', $var['parent'],'" title="Return to page home">Navigation</a>';
                    ?>
                
                </div>
                

                <?php
                    
                    if(count($var['subpages']) > 0)
                    {
                        echo '
                    <ul id="left-links">';
                
                        for($i = 0; $i < count($var['subpages']); $i++)
                        {
                            if($var['subbreaks'][$i])
                                echo '
                        <div class="sub-break"></div>';
                            
                            echo '
                        <li><a href="?page=', $var['subpages'][$i][0] ,'"';
                            if($var['subpages'][$i][1] == $_GET['page1'] || $var['subpages'][$i][1] == $_GET['page'])
                                echo 'class="current"';
                            
                            echo '>', $var['subpages'][$i][1] ,'</a>';
                        }
                    
                        echo '
                    </ul>';
                    
                    }
                    else
                    {
                        echo '<em>There are no subpages</em>';
                    }
                    ?>

                <?php if($var['logged'] && is_array($var['recent_announcements']))
                {            
                echo '
                <div class="link-header" style="margin-top:35px;">
                    <a href="?page=announcements" title="View Troop Announcements">Announcements</a>
                </div>';
                    
                    if(count($var['recent_announcements']) > 0)
                    {
                        echo '
                        <b>Note:</b> announcements are not real
                        <ul>';
                        foreach($var['recent_announcements'] as $arr)
                        {
                            echo '
                            <li><a href="?page=announcements', $arr[1] != 0 ? '&amp;page1=My Patrol' : '', '#a-', $arr[0], '"
                                   title="', $arr[2], ' (updated ', date('n/j/y', $arr[4]), ')" onClick="popit(\'getinfo.php?id=', $arr[0] ,'\')">',
                            strlen($arr[2]) > 20 ? substr($arr[2], 0, 20) . '...' : $arr[2], '</a></li>';
                        }
                        
                        echo '
                        </ul>';
                    }
                    else
                    {
                        echo 'There are no recent announcements';
                    }
                }
                
                if($var['logged'] && is_array($var['upcoming_events']))
                {            
                echo '
                <div class="link-header" style="margin-top:35px;">
                    <a href="?page=calendar" title="This month\'s events">Calendar</a>
                </div>';
                
                    if(count($var['upcoming_events']) > 0)
                    {
                        echo '
                        <b>Note:</b> events are not real
                        <ul>';
                        foreach($var['upcoming_events'] as $arr)
                        {
                            echo '
                            <li><a href="?page=calendar&amp;month=', $arr[1], '&amp;year=', $arr[3], '"
                                   title="', $arr[4], ' (', $arr[1], '/', $arr[2], '/', $arr[3], ')"
                                   onClick="popit(\'getinfo.php?mode=calendar&amp;id=', $arr[0], '\'); return false"';
                                   
                                   if($arr[1] == date('n') && $arr[2] == date('j') && $arr[3] == date('Y'))
                                    echo 'style="font-weight:bold;"';
                                   
                                   echo '>',
                                   shorten_word($arr[4], 20), '</a></li>';
                        }
                        
                        echo '
                        </ul>';
                    }
                    else
                    {
                        echo 'There are no upcoming events';
                    }
                }
                
                
                
                ?>
                
            
            </div>
            
            
            <!-- Page Content -->
            <div id="content">
