<!--
/**
 * inc/js_functions.js
 *
 * Code and Markup Copyright (c) Montana Banana
 */

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
	var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array;
	for(i=0;i<(a.length-2);i+=3){if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x;
	if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}}
}


function showLayer(layerName){
	if (document.getElementById){
		var targetElement = document.getElementById(layerName);
		targetElement.style.visibility = 'visible';
		targetElement.style.height = 'auto';
	}
}

function hideLayer(layerName){
	if (document.getElementById) {
		var targetElement = document.getElementById(layerName);
		targetElement.style.visibility = 'hidden';
		targetElement.style.height = '0px';
	}
}


// POPUP MENU
function show(id) {
	document.getElementById(id).style.visibility = "visible";
	for(var i=1; i<8; i++){
		layerID = "topnav_" + i;
		if(document.getElementById(layerID)){
			if(layerID != id && document.getElementById(layerID).style.visibility == "visible"){
				document.getElementById(layerID).style.visibility = "hidden";
			}
		}
	}
}
function hide(id) {
	for(var i=1; i<8; i++){
		layerID = "topnav_" + i;
		if(document.getElementById(layerID)){
			if(layerID != id && document.getElementById(layerID).style.visibility == "visible"){
				document.getElementById(layerID).style.visibility = "hidden";
			}
		}
	}
}


// HREF VIA JAVASCRIPT EVENT
function redirect(url) {
	window.location = url;
}


// new window popup used for opening up artwork and flash projects
function launchwin(uri,name,args){
	//args += ",resizable=no";
	var newwin = window.open(uri,name,args);
	newwin.focus();
}


// WEB BASED 'BACK' BUTTON
function go_back(){
	history.back();
}


// FOR USE IN CMS... CONFIRM ACTION BEFORE SUBMITTING TO db_update PAGE
function confirmSubmit(conf){
	var agree=confirm(conf);
	if (agree){
		return true ;
	} else {
		return false ;
	}
}


// stilettotools.com functions:

function setShippingMethod(shippingMethod, shippingPrice){
	document.getElementById("method").value = shippingMethod;
	document.getElementById("price").value = shippingPrice;
	document.getElementById("continueButton").style.visibility = "visible";
}

function chooseProductOption(productId, productOptionsId){
	document.getElementById("option"+productOptionsId).checked = true;
	document.getElementById("continueButton").style.visibility = "visible";
	document.getElementById("productId").value = productId;
	document.getElementById("productOptionsId").value = productOptionsId;
	
	window.location.hash="cb";
}

function agreeToTerms(){
	document.getElementById("agreeCheckbox").checked = true;
	document.getElementById("continueButton").style.visibility = "visible";
	document.getElementById("agree").value = "true";
}

function updateLocationsPics(locationId){
	for(i=1; i<15; i++){
		if(document.getElementById("location"+i)){
			document.getElementById("location"+i).className = "";
		}
	}
	
	document.getElementById("location"+locationId).className = "sel";

	if(document.getElementById("locationSample1_"+locationId)){
		document.getElementById("locationSample1").src = document.getElementById("locationSample1_"+locationId).src;
		document.getElementById("locationSample1").style.borderColor = "#ffffff";
	} else {
		document.getElementById("locationSample1").src = "images/spacer.gif";
		document.getElementById("locationSample1").style.borderColor = "#cccdc9";
	}

	if(document.getElementById("locationSample2_"+locationId)){
		document.getElementById("locationSample2").src = document.getElementById("locationSample2_"+locationId).src;
		document.getElementById("locationSample2").style.borderColor = "#ffffff";
	} else {
		document.getElementById("locationSample2").src = "images/spacer.gif";
		document.getElementById("locationSample2").style.borderColor = "#cccdc9";
	}
	
	document.getElementById("locationId").value = locationId;
}


//-->