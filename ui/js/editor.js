var myWindow = "";

function showEditor()
{
    url = 'popup.php';
    
    // Make sure the window isn't already open
    if(!myWindow.closed && myWindow.location)
    {
        myWindow.location.href = url;
    } else {
        myWindow = window.open(url, 'editor', "scrollbars,resizable,width=900,height=800");
        if (!myWindow.opener)
            myWindow.opener = self;
    }

    if(window.focus)
        myWindow.focus();
    
        return false;
}