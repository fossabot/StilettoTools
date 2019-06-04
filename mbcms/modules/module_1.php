<?	# MODULE: ARTICLES
	# FOR MBCMS ALL 'ARTICLE' - LIKE PAGES (this includes things like press, news, etc)
	
	echo '<div style="border:1px solid #ddd; background:#efefef; padding:15px;">';
	if($_GET['do'] == 'view'){
		echo "This CMS page allows you to view a listing of (by default), edit specific and add ".ucwords(str_replace("_"," ",$pg))." to your site. 
		  Please select from the list below to edit particular ".ucwords(str_replace("_"," ",$pg)).".";
	} else if($tables[$p]['blurb']){
		echo $tables[$p]['blurb'];
	}
	echo '</div>';
	
	if($_GET['do'] == 'edit'){
		# EDIT A SPECIFIC
		
		$altTemplate = 'modules/module_'.$pg.'_.php';
		if(file_exists($altTemplate)){
			include($altTemplate);
		}
		
		$q = mysql_query("SELECT * FROM `$pg` WHERE `id`='$id'");
		$qd = mysql_fetch_assoc($q);
		$form = new form;
		$form->start('POST','db_update.php','mixed');
		$form->hiddenfield('db',$pg);
		$form->hiddenfield('do','edit');
		for($i=0; $i<sizeof($tables[$p]['field']); $i++){
			if($tables[$p]['query'][$i] != ""){
				$query = str_replace('DBDATA', $qd[$tables[$p]['field'][$i]], $tables[$p]['query'][$i]);
				formelement($form,$tables[$p]['lable'][$i], $tables[$p]['field'][$i], $query, $tables[$p]['type'][$i],$pg,$tables, $tables[$p]['note'][$i]);
			} else {
				formelement($form,$tables[$p]['lable'][$i], $tables[$p]['field'][$i], $qd[$tables[$p]['field'][$i]], $tables[$p]['type'][$i],$pg,$tables, $tables[$p]['note'][$i]);
			}
		}
		
		$form->end('Confirm','Are you sure you want to do this?');
		
		if($_GET['pg'] == 'dg_designs'){
			# DISPLAY SWATCH 100x100px
			echo '<div style="position:absolute; z-index:3; top:323px; margin-top:0px; left:50%; margin-left:55px; width:100px;">
				  <img src="../uploads/'.$_GET["pg"].'/'.$_GET["pg"].'_'.$id.'.jpg">
				  <p><small>note: new upload will overwrite this image</small>
				  </div>';
		} else if($_GET['pg'] == 'applique_swatches'){
			# DISPLAY SWATCH 100x100px
			echo '<p><img src="../uploads/'.$_GET["pg"].'/'.$_GET["pg"].'_'.$id.'.jpg">
				  <p><small>This is the large version swatch the user sees in the Design Shop AND, if pattern, the popup description box.</small>';
		}
		
	} else if($_GET['do'] == 'add') {
		# ADD A NEW
		$form = new form;
		$form->start('POST','db_update.php','mixed');
		$form->hiddenfield('db',$pg);
		$form->hiddenfield('do','add');
		for($i=0; $i<sizeof($tables[$p]['field']); $i++){
			formelement($form,$tables[$p]['lable'][$i], $tables[$p]['field'][$i], '', $tables[$p]['type'][$i],$pg,$tables, $tables[$p]['note'][$i]);
		}
		$form->end('Confirm','Are you sure you want to do this?');
		
	} else {
		# VIEW LISTING OF ALL
		$db = $_GET['pg'];
		if(!isset($_GET['n'])) $n = 0; else $n = $_GET['n'];
		if(!isset($_GET['ob'])) $ob = 'id'; else $ob = $_GET['ob'];
		if(!isset($_GET['or'])) $or = 'ASC'; else $or = $_GET['or'];
		
		# SEARCH QUERY
		if(isset($_GET['searchquery']) && $_GET['searchquery'] != ""){
			if(eregi("%20",$_GET['searchquery'])) $queryWords = expode("%20",$_GET['searchquery']);
			else $queryWords = array($_GET['searchquery']);
			foreach($queryWords AS $key => $val){
				$search .= "`".$_GET['searchfield']."` LIKE '%".$val."%' OR ";
			}
			$searchquery = "WHERE (".substr($search,0,(strlen($search)-4)).")";
		}
		
		$t = mysql_result(mysql_query("SELECT COUNT(id) FROM `$db` ".($searchquery == "()" ? "" : $searchquery).""),0);
		
		$q = mysql_query("SELECT * FROM `$db` ".($searchquery == "()" ? "" : $searchquery)." ORDER BY `$ob` $or LIMIT $n, 15");
		if(mysql_num_rows($q) > 0){
			$listing = new listing;
			$listing->start($ob,$or,$n,mysql_num_rows($q),$t,$tables);
			while($qd = mysql_fetch_assoc($q)){
				$listing->listrow($qd,$tables,$db,'');
			}
			$listing->end($n,mysql_num_rows($q),$t,$tables);
			
		} else {
			echo "<p>$notice<i><b>There are no ".ucfirst($_GET['pg'])." currently in the database.</b></i>";
		}
		
	}

?>