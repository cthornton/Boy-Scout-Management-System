<?php
header('HTTP/1.x 500 Internal Server Error');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="ui/css/error.css">
    <title>Website Error :&lt;</title>
</head>
<body>
<div id="center">
    <h1>Website Error</h1>
    <p>
        The website has encountered a serious error. It is safe to blame the Administrator for this error (not the webmaster).  
    </p>
    <p>
        If you would be so kind, would you email the <strong>administrator</strong> the following:
    </p>
    <pre><?php echo $e; ?>
    </pre>
</div>
</body>
</html>