function putData() {
        // Make sure we update the text first
        WYSIWYG.updateTextArea('content');
	var data = document.frm.cnt.value;
	window.opener.document.getElementById('tx').value = data;
        window.close();
}

function getData()
{
    var data = window.opener.document.getElementById('tx').value;
    document.frm.cnt.value = data;
    //WYSIWYG.updateTextArea('content');
}
