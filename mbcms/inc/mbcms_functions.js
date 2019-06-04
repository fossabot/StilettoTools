// DISPLAY NOTE FOR SELECTED ITEM
function note(content){
	document.getElementById("navnote").innerHTML = content;
}

// CONFIRM ACTION BEFORE SUBMITTING TO db_update PAGE
function confirmSubmit(conf){
	var agree=confirm(conf);
	if (agree){
		return true ;
	} else {
		return false ;
	}
}

// CHECK AND UNCHECK ALL CHECKBOXES
function uncheckAll() {
	document.form.reset();
}

function checkAll() { 
	with (document.form) {
	
	for (var i=0; i < elements.length; i++) {
		if (elements[i].type == 'checkbox' && elements[i].name == 'id[]')
			elements[i].checked = true;
		}
	}
}

// TOGGLE ADD CATEGORY BOX
function toggleBox(szDivID, iState) // 1 visible, 0 hidden
{
    if(document.layers)    //NN4+
    {
       document.layers[szDivID].visibility = iState ? "show" : "hide";
    }
    else if(document.getElementById)      //gecko(NN6) + IE 5+
    {
        var obj = document.getElementById(szDivID);
        obj.style.visibility = iState ? "visible" : "hidden";
    }
    else if(document.all)       // IE 4
    {
        document.all[szDivID].style.visibility = iState ? "visible" : "hidden";
    }
}


// new window popup used for opening up artwork and flash projects
function launchwin(uri,name,args)
{
	newwin = window.open(uri,name,args);
	newwin.focus();
}


// alert confirmation for delete button (red delete in list view)
function confirmDelete(uri,title)
{
	var msg = "Are you sure you want to permanently delete " + title + "?";
	var confirmation = confirm(msg);
	if (confirmation == true){
		window.location = uri;
	}
}