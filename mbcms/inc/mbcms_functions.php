<? // mbcms_functions.php

# GET CURRENT SEASON, SO AS TO SERVE ASSOCIATED COLORED LOGO IN MBCMS
	
# GET SINGLE FIELD FROM QUERY BASED ON TABLE NAME AND FIELD NAME, ID
# USAGE: getField($id,'products', 'title') RETURNS 'Title'
function getField($id, $table, $field){
	$q = mysql_query("SELECT `$field` FROM `$table` WHERE `id`='$id'");
	$qd = mysql_fetch_assoc($q);
	return stripslashes($qd[$field]);
}

# FORMAT TEXT FOR DISPLAY ON THE SITE... ALL TEXT GO TO THROUGH THIS, EVEN IF IT DOES NOTHING AT THE MOMENT
# USAGE: f($qd['description']);
function f($t){
	$specialChars = array(	'(r)'	=> '&reg;',
							'(R)'	=> '&reg;',
							'(c)'	=> '&copy;',
							'(C)'	=> '&copy;',
							'(tm)'	=> '&trade;',
							'(TM)'	=> '&trade;',
							'(&gt;)'	=> '&rsaquo;',
							'(&gt;&gt;)'	=> '&raquo;');
	foreach($specialChars AS $key => $val) $t = str_replace($key,$val,stripslashes($t));
	return $t;
}


# BUILD NAVIGATION
class navigation {
	function start() {
		//echo '<p align="center" class="navhd">NAVIGATION</p>';
		//echo '<img src="images/mbcms_hdr_navigation.gif"><br>';
		echo '<img src="images/spacer.gif" width="145" height="5" style="background:#7b9aaf;">';
	}
	
	function navlink($t, $l, $d) {
		if($t == "Bulk Mailer"){
			echo "<a href=\"index.html?pg=mailer&do=view\" onmouseover=\"note('<b>NOTE:</b><br>$d');\"
						  								   onmouseout=\"note('');\" class=\"navlink\">&nbsp; BULK MAILER</a>";
		} else {
			echo "<a href=\"".$l."\"  onmouseover=\"note('<b>NOTE:</b><br>$d');\"
						  			  onmouseout=\"note('');\" class=\"sideNav_lnk\">&nbsp; ".strtoupper($t)."</a>";
		}
	}
	
	function end() {
		//echo '<img src="images/mbcms_ftr_navigation.gif">';
		echo '<p><center>
			  <div id="navnote"></div>';
		echo '<p>
			  <table width="140" style="border:2px solid #EEE;">
			  <tr><td><b>KEY:</b></td></tr>
			  <tr><td style="background:#E1E1E1; padding:1px;" align="left">&nbsp&nbsp;&raquo; Active: On Site&nbsp&nbsp;</td></tr>
			  <tr><td style="background:#F3DA88; padding:1px;" align="left">&nbsp&nbsp;&raquo; Inactive: Not Live&nbsp&nbsp;</td></tr>
			  <tr><td style="background:#E1E1E1; padding:1px;" align="left">&nbsp<img src="images/button_drop.gif">&nbsp; Delete&nbsp&nbsp;<br>
															   &nbsp<img src="images/button_edit.gif">&nbsp; Edit&nbsp&nbsp;<br>
															   &nbsp<img src="images/img_folder.gif">&nbsp; Category<br>
															   &nbsp<img src="images/img_file.gif">&nbsp; Editible Field<br>
															   &nbsp<img src="images/img_flag.gif">&nbsp; Needs Attention<br></td></tr>
			  </table>';
		echo '</center>';
	}
}

# CREATE A FORM
class form {
	function start($m,$a,$f=0) {
		echo "<form";
		if($f == 'mixed') echo " enctype=\"multipart/form-data\"";
		echo " method=\"$m\" action=\"$a\" onsubmit=\"return submitForm();\">";
		echo '<table width="100%" border=0 cellspacing="5">
			  <tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
		echo "\n";
	}
	
	function hiddenfield($name,$value) {
		echo "<input type=\"hidden\" name=\"$name\" value='".stripslashes(str_replace("'","&#39;",str_replace('"','&quot;',$value)))."'>\n";
	}
	
	function checkbox($lable,$name,$value) {
		echo "<tr><td valign=\"top\"><b>$lable:</b></td>";
		echo "<td valign=\"top\"><input type=\"checkbox\" name=\"$name\" value='".stripslashes(str_replace("'","&#39;",$value))."'> ".stripslashes($lable)."\n";
		echo "</td></tr>\n";
	}
	
	function filefield($lable,$name,$value,$db,$id,$type,$note=0) {
		if($value != '') $f = '../uploads/files/'.$value;
		else $f = "../uploads/".$db."/".$db."_".$id."_".$name.".jpg";
		echo "<tr><td valign=\"top\"><b>$lable:</b></td><td>
				<table cellspacing=\"0\" cellpadding=\"0\"><tr>
				<td valign=\"top\" style=\"padding-right:15px;\"><input type=\"file\" name=\"$name\" class=\"inputfield\">";
		if($note) echo "<br><small>".stripslashes($note)."</small>";
		if(file_exists($f)) echo "<br><img src=\"images/image_arrow.gif\">";
		echo "</td>";
		if(file_exists($f)) {
			echo "<td>";
			if(eregi(".jpg",$f)) echo '<img src="'.$f.'" width="100" /><br>';
			echo "<small><a href=\"db_delete.php?db=".$db."&field=".$name."&id=".$id."&type=".$type."&filename=".$value."\">DELETE</a> ".$value."</small>";
			echo '</td>';
		}
		echo "</tr></table></td></tr>\n";
	}
	
	function radiobuttonlist($lable,$name,$nmvals,$sel) {
		echo "<tr><td valign=\"top\"><b>$lable:</b></td><td>";
		$nmvalsary = explode('|',$nmvals);
		for($i=0; $i<sizeof($nmvalsary); $i++){
			$ary = explode(',',$nmvalsary[$i]);
			echo "<input type=\"RADIO\" name=\"$name\" value=\"".$ary[0]."\"";
			if($sel==$ary[0]) echo " checked";
			echo "> ".$ary[1]."<br>\n";
		}
		echo "</td></tr>\n";
	}
	
	function selectbox($label,$name,$nmvals,$sel)
	{
		echo "<tr><td><b>$label:</b></td><td>
			  <select name=\"".stripslashes(str_replace("'","`",$name))."\"><option value=\"\">Please Select One</option>\n";
		$nmvalsary = explode('|',$nmvals);
		for($i=0; $i<(sizeof($nmvalsary)-1); $i++){
			$ary = explode(',',$nmvalsary[$i]);
			echo "<option value=\"".$ary[0]."\"";
			$selary = explode(',',$sel);
			for($n=0; $n<sizeof($selary); $n++) if($selary[$n]==$ary[0]) echo " selected";
			echo ">".stripslashes(str_replace("'","&#39;",$ary[1]))."</option><br>\n";
		}
		echo "</select></td></tr>\n";
	}
	
	function selectmult($label,$name,$nmvals,$sel)
	{
		echo "<tr><td valign=\"top\"><b>$label:</b></td><td>
			  <select name=\"".stripslashes(str_replace("'","`",$name))."[]\" multiple size=\"6\" style=\"width:210px;\">
				<option value=\"\">None</option>\n";
		$nmvalsary = explode('|',$nmvals);
		for($i=0; $i<(sizeof($nmvalsary)-1); $i++){
			$ary = explode(',',$nmvalsary[$i]);
			echo "<option value=\"".$ary[0]."\"";
			$selary = explode(',',$sel);
			for($n=0; $n<sizeof($selary); $n++) if($selary[$n]==$ary[0]) echo " selected";
			echo ">".stripslashes(str_replace("'","&#39;",$ary[1]))."</option><br>\n";
		}
		echo "</select><br><small>Ctrl or Cmd click to select multiple.</small></td></tr>\n";
	}
	
	function textarea($lable,$name,$dbcontent,$height,$note) {
		# RTE VERSION
		if($name == 'description'){
			echo "<tr><td valign=\"top\" colspan=\"2\"><b>$lable:</b><p>";
			echo '<script language="JavaScript" type="text/javascript">
			 <!--
			 //Usage: initRTE(imagesPath, includesPath, cssFile)
			 initRTE("images/", "", "");
			 //Usage: writeRichText(fieldname, html, width, height, buttons, readOnly)
			 writeRichText(\''.$name.'\', \''.str_replace("'","\'",str_replace("\r", '', str_replace("\n", '', stripslashes($dbcontent)))).'\', 490, 200, true, false);
			 //-->
			 </script><br>
			 &nbsp;';
		} else {
			echo "<tr><td valign=\"top\"><b>$lable:</b></td>";
			echo "<td valign=\"top\">";
			echo "<textarea  ";
			echo "name=\"".$name."\" style=\"width:400px; height:".$height."px;\">";
			echo stripslashes(str_replace("<br />","",$dbcontent));
			echo "</textarea>";
		}
		if($note) echo '<br><small>'.stripslashes($note).'</small>';
		echo "</td></tr>\n";
	}
	
	function textfield($lable,$name,$value,$opt=0) {
		echo "<tr><td><b>$lable:</b></td>";
		echo "<td><input type=\"text\"style=\"width:250px;\" name=\"$name\"";
		if($opt) echo shownote($opt);
		if($value) echo " value='".stripslashes(str_replace("'","&#39;",$value))."'";
		echo ">";
		if($opt) echo " <small>($opt)</small>";

		echo "</td>\n";
	}
	
	function errorfield($lable,$name,$value) {
		echo "<tr><td valign=\"top\"><b>$lable:</b></td>";
		echo "<td valign=\"top\" class=\"errortxt\">".stripslashes($value)."</td>\n";
	}
	
	function textlist($lable,$name,$query) {
		echo "<tr><td valign=\"top\"><b>$lable:</b></td>";
		echo "<td valign=\"top\">";
		$q = mysql_query($query);
		while($qd = mysql_fetch_assoc($q)){
			echo "<b>&middot;</b> ";
			foreach($qd AS $k => $v) echo stripslashes($v);
			echo "<br>";
		}
		echo "</td>\n";
	}
	
	function text($lable,$name,$val) {
		echo "<tr><td valign=\"top\"><b>$lable:</b></td>";
		echo "<td valign=\"top\">";
		if($val != "") echo stripslashes(nl2br($val));
		else echo "n/a";
		echo "</td>\n";
	}
	
	function end($lable=0,$confirm=0) {
		echo "<tr><td>&nbsp;</td><td>&nbsp;<p><input type=\"reset\" name=\"Reset\"> &nbsp; <input type=\"submit\" name=\"Submit\"";
		if($lable) echo " value=\"$lable\"";
		if($confirm) echo " onClick=\"return confirmSubmit('$confirm')\"";
		echo '></form>';
		echo "</td></tr></table>\n";
	}
}

# DETERMINE WHICH FORM ELEMENT TO USE BASED ON CONFIG FILE
function formelement($form,$lable,$name,$value,$type,$cattype=0,$tables=0,$opt=0,$mult=0){
	switch ($type){
		case 'hidden':
			$form->hiddenfield($name,$value);
		break;
		case 'image':
			for($i=0; $i<sizeof($tables); $i++){
				if($tables[$i]['table'] == $cattype) $n = $i;
			}
			if(isset($tables[$n]['imageproperties'])){
				$form->hiddenfield("imageproperties[$name][width]",$tables[$n]['imageproperties']["$name"]['width']);
				$form->hiddenfield("imageproperties[$name][height]",$tables[$n]['imageproperties']["$name"]['height']);
				$form->hiddenfield("imageproperties[$name][frame]",$tables[$n]['imageproperties']["$name"]['frame']);
				$note = "Image will be cropped and resized to ".$tables[$n]['imageproperties']["$name"]['width']." x ".$tables[$n]['imageproperties']["$name"]['height']."";
			}
			$form->hiddenfield('filelocation',$cattype);
			$imagename = $_GET['pg']."_".$_GET['id']."_lg.jpg";
			$form->filefield($lable,$name,'',$_GET['pg'],$_GET['id'],'image',$note);
			break;
		case 'file':
			for($i=0; $i<sizeof($tables); $i++){
				if($tables[$i]['table'] == $cattype) $n = $i;
			}
			if($opt && trim($opt) != '') $note = $opt;
			else $note = "Upload .jpg, .pdf or .doc (Word document) file";
			$form->hiddenfield('filelocation',$cattype);
			$form->filefield($lable,$name,$value,$_GET['pg'],$_GET['id'],'file',$note);
			break;
		case 'textfield':
			$form->textfield($lable,$name,$value,$opt);
		break;
		case 'textarea':
			$n = getKey($tables, $cattype);
			for($i=0; $i<sizeof($tables[$n]['field']); $i++){
				if($tables[$n]['field'][$i] == $name) $x = $i;
			}
			if($tables[$n]['note'][$x] && $tables[$n]['note'][$x]!="") $note = $tables[$n]['note'][$x];
			else $note = 0;
			if($name == 'description') $s = '250'; else $s = '60';
			$form->textarea($lable,$name,$value,$s,$note);
		break;
		case 'selectbox':
			// **************************************************************
			// NOTE FOR JK: TRY TO MAKE THIS CONDITIONAL DATA WITHIN THE CONFIG FILE
			// **************************************************************
			if($name == 'category'){
				// GET ALL CATEGORIES FOR THIS PARTICULAR TYPE
				$x = mysql_query("SELECT * FROM `category` WHERE `type`='$cattype' AND `parent`='0'");
				while($xd = mysql_fetch_assoc($x)){
					$nmvals .= $xd['id'].','.$xd['title'].'|';
					$xdid = $xd['id'];
					$sx = mysql_query("SELECT * FROM `category` WHERE `type`='$cattype' AND `parent`='$xdid'");
					if(mysql_num_rows($sx) > 0){
						while($sxd = mysql_fetch_assoc($sx)) $nmvals .= $sxd['id'].',&nbsp;&middot;'.$sxd['title'].'|';
					}
				}
			} else if($name == 'sub'){
				if($_GET['pg'] == 'bb_categories'){
					// GET ALL FORUM CATEGORIES
					$x = mysql_query("SELECT * FROM `bb_categories` WHERE `sub`='0'");
					while($xd = mysql_fetch_assoc($x)) $nmvals .= $xd['id'].','.$xd['title'].'|';
				} else {
					// GET ALL TOP LEVEL CATEGORIES
					$x = mysql_query("SELECT * FROM `category` WHERE `sub`=''");
					while($xd = mysql_fetch_assoc($x)) $nmvals .= $xd['id'].','.$xd['title'].'|';
				}
			} else if($name == 'products'){
				// GET ALL CATEGORIES FOR THIS PARTICULAR TYPE
				$x = mysql_query("SELECT * FROM `category` WHERE `type`='products' AND `subof`='0'");
				while($xd = mysql_fetch_assoc($x)){
					$nmvals .= $xd['id'].','.$xd['title'].'|';
					$xdid = $xd['id'];
					$sx = mysql_query("SELECT * FROM `products` WHERE `category`='$xdid' AND `active`='0' ORDER BY `title` ASC");
					if(mysql_num_rows($sx) > 0){
						while($sxd = mysql_fetch_assoc($sx)) $nmvals .= $sxd['id'].',&nbsp;&middot;'.$sxd['title'].'|';
					}
				}
			} else if($name == 'options'){
				$x = mysql_query("SELECT * FROM `options` WHERE `active`='0' ORDER BY `title` ASC");
				while($xd = mysql_fetch_assoc($x)) $nmvals .= $xd['id'].','.$xd['title'].'|';
				
			} else if(TableExists($name, $default_dbname)){
				// IF THERE'S A DATABASE BY IT'S NAME, LIST ALL
				$x = mysql_query("SELECT * FROM `$name` ORDER BY `title`");
				if(mysql_num_rows($x) > 0){
					while($xd = mysql_fetch_assoc($x)) $nmvals .= $xd['id'].','.$xd['title'].'|';
				}
			
			} else {
				// **************************************************************
				// NOTE FOR JK: FOR THE MOST PART, THIS IS ALL THE CONDITIONAL YOU NEED
				// (FOR EVERYTHING OTHER THAN TYPE... as long as names are kept consistent)
				// **************************************************************
				$n = getKey($tables, $cattype);
				if( $tables[$n]['select']["$name"] && eregi("\|",$tables[$n]['select']["$name"]) ){
					$nmvals = $tables[$n]['select']["$name"];
				} else if($tables[$n]['select']["$name"]) {
					$db = $tables[$n]['select']["$name"];
					$key = getKey($tables, $name);
					$listme = $tables[$key]['listme'];
					$x = mysql_query("SELECT * FROM `$db`");
					while($xd = mysql_fetch_assoc($x)){
						if(!is_array($listme) && $xd["$listme"]){
								$title = stripslashes($qd["$listme"]);
						} else {
							foreach($listme AS $k => $v){
								if($xd[$v]) $title .= $xd[$v];
								else $title .= $v;
							}
						}
						$nmvals .= $xd['id'].','.$title.'|';
						unset($title);
					}
				}
			
			}
			if(!isset($nmvals)) $form->errorfield($lable,$name,"".strtoupper($name)." NEED TO BE ADDED");
			else $form->selectbox($lable,$name,$nmvals,$value,$mult);
		break;
		case 'selectmult':
			if(TableExists($name, $default_dbname)){
				// IF THERE'S A DATABASE BY IT'S NAME, LIST ALL
				$x = mysql_query("SELECT * FROM `$name` ORDER BY `title`");
				while($xd = mysql_fetch_assoc($x)) $nmvals .= $xd['id'].','.$xd['title'].'|';
			} else {
				// **************************************************************
				// NOTE FOR JK: FOR THE MOST PART, THIS IS ALL THE CONDITIONAL YOU NEED
				// (FOR EVERYTHING OTHER THAN TYPE... as long as names are kept consistent)
				// **************************************************************
				$n = getKey($tables, $cattype);
				if( $tables[$n]['select']["$name"] && eregi("\|",$tables[$n]['select']["$name"]) ){
					$nmvals = $tables[$n]['select']["$name"];
				} else if($tables[$n]['select']["$name"]) {
					$db = $tables[$n]['select']["$name"];
					$key = getKey($tables, $name);
					$listme = $tables[$key]['listme'];
					$x = mysql_query("SELECT * FROM `$db`");
					while($xd = mysql_fetch_assoc($x)){
						if(!is_array($listme) && $xd["$listme"]){
								$title = stripslashes($qd["$listme"]);
						} else {
							foreach($listme AS $k => $v){
								if($xd[$v]) $title .= $xd[$v];
								else $title .= $v;
							}
						}
						$nmvals .= $xd['id'].','.$title.'|';
						unset($title);
					}
				}
			}
			
			if(!isset($nmvals)) $form->errorfield($lable,$name,"".strtoupper($name)." NEED TO BE ADDED (mult)");
			else $form->selectmult($lable,$name,$nmvals,$value);
		break;
		case 'radiobuttonlist':
			// **************************************************************
			// NOTE FOR JK: TRY TO MAKE THIS CONDITIONAL DATA WITHIN THE CONFIG FILE
			// **************************************************************
			if($name == 'active'){
				$nmvals = '0,Yes|1,No';
				if($value == "") $value = '1';
			} else if($name == 'featured' && $nmvals == ""){
				$nmvals = '0,Featured|1,Not featured';
				if($value == "") $value = '1';
			}
			$form->radiobuttonlist($lable,$name,$nmvals,$value);
		break;
		case 'checkbox':
			$form->checkbox($lable,$name,$value);
		break;
		case 'textlist':
			$form->textlist($lable,$name,$value);
		break;
		case 'text':
			$form->text($lable,$name,$value);
		break;
	}
}

# TABBED NAVIGATION
class tabs {
	function start($pgs,$sel,$t){
	    $pgs_a = explode('|',$pgs);
	    $lnk = array(); $lbl = array();
	    for($i=0; $i<sizeof($pgs_a); $i++){
	        $pgs_b = explode(',',$pgs_a[$i]);
	        # LINK AS IT IS DISPLAYED
	        $lnk[$i] = $pgs_b[1]; 
	        # URL ASSOCIATED WITH LINK     
	        $lbl[$i] = $pgs_b[0];   
	    }
	
	    echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">
	        <tr><td colspan="'.(sizeof($pgs_a)+5).'" class="tabs_a" style="width:100%;"><span class="headtxt">&raquo; '.$t.'</span></td></tr>
	        <tr><td class="tabs_b">
	        <img src="images/spacer.gif" width="4" height="20" border="0"></td>';
	    for($n=0;$n<sizeof($pgs_a);$n++){
	        if($sel == strtolower(str_replace(" ","",$lbl[$n])) ){
	            $s = "sel";
	        }
	        else $s = "lnk";
	        echo '<td class="tabs_'.$s.'">';
	        
	        if($lnk[$n]!="" && $sel != strtolower(str_replace(" ","",$lbl[$n]))) echo '<a href="'.$lnk[$n].'" class="tablink">';
	        echo $lbl[$n];
	        if($lnk[$n]!="" && $sel != strtolower(str_replace(" ","",$lbl[$n]))) echo '</a>';
	        echo '</td><td class="tabs_c">
	        <img src="images/spacer.gif" width="4" height="20" border="0"></td>';
	    }
	    echo '<td class="tabs_c">
	          <img src="images/spacer.gif" width="200" height="20" border="0"></td>
	    	  </tr><tr><td colspan="'.(sizeof($pgs_a)+5).'" class="tabs_content">&nbsp;<p>';
	}
	
	function end(){
		echo '<p>&nbsp;</td></tr></table>';
	}

}

# LISTING OF CONTENT IN COLOR CHANGING ROWS
class listing {
	function start($s,$o,$n,$g,$t,$tables){
		echo '<p>';
		$qstring = $_GET;
		foreach($qstring AS $k => $v){
			if($k != 'ob' && $k != 'or') $qstringa .= $k."=".$v."&";
		}
		$qs = substr($qstringa,0,(strlen($qstringa)-1));
	
		# FIND OUT WHAT TO LIST AS THE TITLE FIELD.. EVEN IF IT'S AN ARRAY
		$key = getKey($tables, $_GET['pg']);
		$listme = $tables[$key]['listme'];
		if(is_array($listme)) $title_listme = $listme[0];
		else $title_listme = $listme;
		
		echo '<b>'.$t.' total rows</b> ';
		if($n > 1) echo '<a href="index.html?do=view&pg='.$_GET['pg'].'&n='.($n-15).''.(isset($_GET['ob']) ? "&ob=".$_GET['ob'] : "").''.(isset($_GET['searchquery']) ? "&searchquery=".$_GET['searchquery'] : "").'">&laquo; prev</a> ';
		echo ' | ';
		if(($n+$g) < $t) echo ' <a href="index.html?do=view&pg='.$_GET['pg'].'&n='.($n+$g).''.(isset($_GET['ob']) ? "&ob=".$_GET['ob'] : "").''.(isset($_GET['searchquery']) ? "&searchquery=".$_GET['searchquery'] : "").'">next &raquo;</a>';
		echo '<p><table width="100%" cellspacing="0" cellpadding="1" border="0">
			  	 <tr class="list_head"><td width="5">&nbsp;</td>';
		if($s == 'id' && $o == 'DESC') echo '<td width="30"><a href="index.html?'.$qs.'&ob=id&or=ASC" class="whitelink"><b>ID</b><img src="images/mbcms_selcolup.gif" border=0></a></td>';
		else if($s == 'id') echo '<td width="30"><a href="index.html?'.$qs.'&ob=id&or=DESC" class="whitelink"><b>ID</b><img src="images/mbcms_selcoldn.gif" border=0></a></td>';
		else echo '<td width="30"><b><a href="index.html?'.$qs.'&ob=id" class="whitelink">ID</a></b></td>';
		
		echo '<td width="15">&nbsp;</td>';
		
		if($s == $title_listme && $o == 'DESC') echo '<td><a href="index.html?'.$qs.'&ob='.$title_listme.'&or=ASC" class="whitelink"><b>'.strtoupper(str_replace("_"," ",$title_listme)).'</b><img src="images/mbcms_selcolup.gif" border=0></a></td>';
		else if($s == $title_listme) echo '<td><a href="index.html?'.$qs.'&ob='.$title_listme.'&or=DESC" class="whitelink"><b>'.strtoupper(str_replace("_"," ",$title_listme)).'</b><img src="images/mbcms_selcoldn.gif" border=0></a></td>';
		else echo '<td><b><a href="index.html?'.$qs.'&ob='.$title_listme.'" class="whitelink">'.strtoupper(str_replace("_"," ",$title_listme)).'</a></b></td>';
		
		
		if($s == 'date' && $o == 'DESC') echo '<td width="60"><a href="index.html?'.$qs.'&ob=date&or=ASC" class="whitelink"><b>DATE</b><img src="images/mbcms_selcolup.gif" border=0></a></td>';
		else if($s == 'date') echo '<td width="60"><a href="index.html?'.$qs.'&ob=date&or=DESC" class="whitelink"><b>DATE</b><img src="images/mbcms_selcoldn.gif" border=0></a></td>';
		else echo '<td width="60"><b><a href="index.html?'.$qs.'&ob=date" class="whitelink">DATE</a></b></td>';
	
		echo '<td width="15">&nbsp;</td>';
		echo '<td width="15">&nbsp;</td>';
		
		echo '</tr>';	
	}
	
	function listrow($qd,$tables,$table,$cat=0){
		if(!isset($qd['active']) || $qd['active'] == '0') $c = '#E1E1E1';
		else $c = '#F3DA88';
		
		// **************************************************************
		// NOTE FOR JK: MAKE THIS A FUNCTION... HAVE USED THIS A FEW TIMES (LOW)
		// **************************************************************
		$key = getKey($tables, $table);
		$listme = $tables[$key]['listme'];
		if($qd["$listme"] && $cat != 'category'){
			$title = stripslashes($qd["$listme"]);
		} else if($cat != 'category'){
			foreach($tables[$key]['listme'] AS $k => $v){
				if($qd[$v]) $title .= $qd[$v];
				else $title .= $v;
			}
		} else {
			$title = $qd['title'];
		}
		
		# HARD CODED WORKAROUND TO SHOW PRODUCTS IN PRODUCTS_PRICE LISTING
		if($table == 'products_price'){
			$a = explode(' ~ ',$title);
			$productTitle = mysql_result(mysql_query("SELECT `title` FROM `products` WHERE `id`='".trim($a[0])."'"),0);
			$optionTitle = mysql_result(mysql_query("SELECT `title` FROM `options` WHERE `id`='".trim($a[1])."'"),0);
			$title = stripslashes($productTitle)." - ".stripslashes($optionTitle);
		}
		
		echo '<tr bgcolor="'.$c.'" 
			onmouseover="this.style.background=\'#F1E4BA\'; note(\'<b>NOTE:</b><br>Click to edit:<br><i>'.ucfirst(str_replace("'","",str_replace('"','',strip_tags($title)))).'</i>\');"
			onmouseout="this.style.background=\''.$c.'\'; note(\'\');">';
		echo '<td class="tdlist">';
		echo '<img src="images/spacer.gif" width="1" height="18">';
		echo '</td>';
			echo '<td class="tdlist">'.$qd['id'].'</td>';
		if($cat == 'category'){
			echo '<td class="tdlist"><img src="images/img_folder.gif" border="0"></td>';
			echo '<td class="tdlist">';
			echo '<a href="index.html?pg='.$_GET['pg'].'&do=view&category='.$qd['id'].'" class="list"><b>';
			if($title) echo $title;
			echo '</b></a></td>';
			echo '<td class="tdlist">'.$qd['date'].'</td>';
			echo '<td class="tdlist">';
			//echo '<a href="index.html?pg='.$_GET['pg'].'&do=edit&category='.$_GET['category'].'&id='.$qd['id'].'"><img src="images/button_edit.gif" border="0" alt="Edit" title="Edit"></a>';
			echo '&nbsp;</td>';
			echo '<td class="tdlist"><a href="db_update.php?do=delete&db='.$_GET['pg'].'&category='.$_GET['category'].'&id='.$qd['id'].'"><img src="images/button_drop.gif" border="0" alt="Delete" title="Delete"></a></td>';
		} else {
			echo '<td class="tdlist"><img src="images/img_'.($cat == 'flag' ? 'flag' : 'file').'.gif" border="0"></td>';
			echo '<td class="tdlist">';
			echo '<a href="index.html?pg='.$_GET['pg'].'&do=edit&id='.$qd['id'].'" class="list"><b>';
			$showtitle = ucfirst(str_replace("'","",str_replace('"','',strip_tags($title))));
			if(strlen($showtitle) > 60) echo substr($showtitle,0,60)."...";
			else echo $showtitle;
			echo '</b></a></td>';
			echo '<td class="tdlist">'.$qd['date'].'</td>';
			if($table == 'pagecontent') echo '<td class="tdlist"><img src="images/spacer.gif" width="12" height="12" border="0" alt="" /></td>';
			else echo '<td class="tdlist"><a href="javascript:confirmDelete(\'db_update.php?do=delete&db='.$_GET['pg'].'&id='.$qd['id'].'\',\''.$showtitle.'\');"><img src="images/button_drop.gif" border="0" alt="Delete" title="Delete"></a></td>';
			echo '<td class="tdlist"><a href="index.html?pg='.$_GET['pg'].'&do=edit&id='.$qd['id'].'"><img src="images/button_edit.gif" border="0" alt="Edit" title="Edit"></a></td>';
		}
		echo '</tr>';
	}
	
	function end($n,$g,$t,$tables){
		# FIND OUT WHAT TO LIST AS THE TITLE FIELD.. EVEN IF IT'S AN ARRAY
		$key = getKey($tables, $_GET['pg']);
		$listme = $tables[$key]['listme'];
		if(is_array($listme)) $title_listme = $listme[0];
		else $title_listme = $listme;
		
		echo '<tr><td colspan="7" style="text-align:right; padding:10px; background:#EEE;">
				<form action="index.html" method="GET">
				<input type="hidden" name="do" value="view">
				<input type="hidden" name="pg" value="'.$_GET['pg'].'">
				<input type="hidden" name="searchfield" value="'.$title_listme.'">';
		if(isset($_GET['category'])) echo '<input type="hidden" name="category" value="'.$_GET['category'].'">';
		echo '<b>Quick Search:</b>
				<input type="text" name="searchquery">
				<input type="submit" value="Search">
				<p style="margin-top:3px;"><small>(Performs a simple search of '.$title_listme.' within '.$_GET['pg'].')</small>
			  </form></td></tr>';
		echo '</table>';
	}
}

# MISCELLANEOUS FUNCTIONS

// RETURN THE CONFIG KEY FOR A CERTAIN TABLE
function getKey($tables, $tablename){
	for($i=0; $i<sizeof($tables); $i++){
		if($tables[$i]['table'] == $tablename){
			$n = $i;
		}
	}
	return $n;
}

// SHOW NOTE ON FOCUS
function shownote($note){
	return "onfocus=\"note('<b>NOTE:</b><br>$note');\"
			onblur=\"note('');\"";
}

$notice = "<span class=\"notice\">!</span> ";

/* 
* This function prints an icon, depending on the file extension, and the file name.
* It is required that there is an directory ( $pathToRes ) which provides the image resources with the right naming. 
* Therefore I created a convention: NameOfTheExtension.gif 
* For example: an icon for a php-file should be called: " php.gif " 
* 
* parameter: $file = filename 
*/ 

function showFile($file){ 
	$pathToRes = "images/";					// directory to parse for image-resources���� 
	$splitedFile = split('[.]',$file);		// divides the file into extension and filename 

	if ($dh = opendir($pathToRes)) {		// opens directory with image-resources 
		while (false !== ($files = readdir($dh))){ 
			if ($files != ".." && $files != ".") { 
				$parts = split('[.]',$files); 
				// the next step will compare all filenames from the images-resources with the extension of the passed file 
				if ($parts[0] == $splitedFile[1]){
					echo '<img src='.$pathToRes."/".$files.' > '.$splitedFile[0].'<br>'; 
				} 
			} 
		} 
	����closedir($dh); 
	} 
}


function format($x, $t){
	if($t == 'creditcard'){
		//substr_replace($var, 'bob', 0);
		$x1 = substr($x, 0, 4);
		$x2 = substr($x, 4, 4);
		$x3 = substr($x, 8, 4);
		$x4 = substr($x, 12, 4);
		$formatted_string = $x1.' '.$x2.' '.$x3.' '.$x4;
	}
	return $formatted_string;
}

# FORMAT PHONE NUMBER
# USAGE echo formatphone($phone);
function formatphone($phone) {
	$phone = str_replace(".","",str_replace(")","",str_replace("(","",str_replace("-","",str_replace(" ","",$phone)))));
	if (empty($phone)) return "";
	if (strlen($phone) == 7){
		sscanf($phone, "%3s%4s", $prefix, $exchange);
	} else if (strlen($phone) == 10) {
		sscanf($phone, "%3s%3s%4s", $area, $prefix, $exchange);
	} else if (strlen($phone) > 10) {
		sscanf($phone, "%3s%3s%4s%s", $area, $prefix, $exchange, $extension);
	} else {
		return "unknown phone format: $phone";
	}
	$out = "";
	$out .= isset($area) ? '(' . $area . ') ' : "";
	$out .= $prefix . '-' . $exchange;
	$out .= isset($extension) ? ' x' . $extension : "";
	return $out;
}

# FORMAT DATE FROM DATABASE (from 2004-01-01 to whatever format specified)
# USAGE echo formatdate($db_date, 'Y-m-d');
function formatdate($d,$t){
	if(isset($d) && $d != ''){
    	list($yyyy, $mm, $dd) = explode('-',$d);
    	$date = date("$t", mktime(0,0,0,$mm,$dd,$yyyy));
    	return $date;
	}
}

# DOES TABLE EXIST
function TableExists($tablename) {
	// Get a list of tables contained within the database.
	$result = mysql_list_tables(DBNAME);
	$rcount = mysql_num_rows($result);

	// Check each in list for a match.
	for ($i=0;$i<$rcount;$i++) {
		if (mysql_tablename($result, $i)==$tablename) return true;
	}
	return false;
}

?>