<?php
/**
 * Popup menu using FCKeditor.
 */
require_once('config.php');

$instance = 'cnt';
?>
<html>
<head>

</script>

    <title>Page Editor</title>
    <script type="text/javascript" src="ui/fckeditor/fckeditor.js"></script>
    <script type="text/javascript">
    <!--
    var oFCKeditor;
    var oEditor;
    
    window.onload = function()
    {
        // We need to set the form value first!
        document.getElementById('<?php echo $instance; ?>').value = window.opener.document.getElementById('tx').value;
        
        // Now set the text editor!
        oFCKeditor = new FCKeditor( '<?php echo $instance; ?>' ) ;
        oFCKeditor.Config["CustomConfigurationsPath"] = "../../../fckconfig.js.php"  ;
        oFCKeditor.Height = 700;
        oFCKeditor.BasePath = "ui/fckeditor/" ;
        oFCKeditor.ReplaceTextarea() ;
    }
    
    function putData() {
            oEditor = FCKeditorAPI.GetInstance('<?php echo $instance; ?>') ;
            window.opener.document.getElementById('tx').value = oEditor.GetHTML();
            window.close();
    }
    // -->
    </script>
    
    <style type="text/css">
    body
    {
        margin: 0px;
    }
    
    #<?php echo $instance; ?>
    {
        width: 100%;
    }
    </style>

</head>
<body>
<form name="frm" id="frm" style="text-align: center">
    <textarea id="<?php echo $instance; ?>" name="<?php echo $instance; ?>"></textarea>
    <input type="button" name="submit" value="Done" onclick="putData()" align="center" style="margin-top:3px;">
</form>

</body>
</html>