<?	// MODULE: CATEGORIZED ARTICLES (categorized by 'category'... associated with the 'category' table)
	// FOR MBCMS ALL 'CATEGORIZED ARTICLE' - LIKE PAGES (this includes things like categories, etc... things that are primarily categorized)

	echo '<div style="border:1px solid #ddd; background:#efefef; padding:15px;">';
	if($_GET['do'] == 'view'){
		echo "This CMS page allows you to view a listing of (by default), edit specific and add ".ucwords(str_replace("_"," ",$pg))." to your site. 
		  Please select a category from the list below to view a listing of, then edit particular ".ucwords(str_replace("_"," ",$pg)).".";
	} else if($tables[$p]['blurb']){
		echo $tables[$p]['blurb'];
	}
	echo '</div>';
	
	if($_GET['do'] == 'edit'){
		// EDIT A SPECIFIC
		
		$q = mysql_query("SELECT * FROM `$pg` WHERE `id`='$id'");
		$qd = mysql_fetch_assoc($q);
		
		$altTemplate = 'modules/module_'.$pg.'.php';
		if(file_exists($altTemplate)){
			include($altTemplate);
		}
		
		$form = new form;
		$form->start('POST','db_update.php','mixed');
		$form->hiddenfield('db',$pg);
		$form->hiddenfield('do','edit');
		for($i=0; $i<sizeof($tables[$p]['field']); $i++){
			formelement($form,$tables[$p]['lable'][$i], $tables[$p]['field'][$i], $qd[$tables[$p]['field'][$i]], $tables[$p]['type'][$i],$pg,$tables, $tables[$p]['note'][$i]);
		}
		$form->end('Confirm','Are you sure you want to do this?');
		
	} else if($_GET['do'] == 'add') {
		// ADD A NEW
		$form = new form;
		$form->start('POST','db_update.php','mixed');
		$form->hiddenfield('db',$pg);
		$form->hiddenfield('do','add');
		for($i=0; $i<sizeof($tables[$p]['field']); $i++){
			formelement($form,$tables[$p]['lable'][$i], $tables[$p]['field'][$i], '', $tables[$p]['type'][$i],$pg,$tables, $tables[$p]['note'][$i]);
		}
		$form->end('Confirm','Are you sure you want to do this?');
		
	} else {
		if(!isset($_GET['n'])) $n = 0; else $n = $_GET['n'];
		if(!isset($_GET['ob'])) $ob = ($_GET['pg']=='orders' ? 'date':'id'); else $ob = $_GET['ob'];
		if(!isset($_GET['or'])) $or = ($_GET['pg']=='orders' ? 'DESC':'ASC'); else $or = $_GET['or'];
		
		if(!isset($_GET['category']) && !isset($_GET['searchquery'])){
		// VIEW LISTING OF ALL CATEGORIES
			$db = $_GET['pg'];
			echo "<p><b>".strtoupper($tables[$p]['name'])." CATEGORIES:</b></p>";
			$t = mysql_result(mysql_query("SELECT COUNT(id) FROM `category` WHERE `type`='$db' AND `parent`='0'"),0);
			$q = mysql_query("SELECT * FROM `category` WHERE `type`='$db' AND `parent`='0' ORDER BY `$ob` $or LIMIT $n, 15");
			if(mysql_num_rows($q) > 0){
				$listing = new listing;
				$listing->start($ob,$or,$n,mysql_num_rows($q),$t,$tables);
				while($qd = mysql_fetch_assoc($q)){
					$listing->listrow($qd,$tables,$db,'category');
				}
			$listing->end($n,mysql_num_rows($q),$t,$tables);
				
			} else {
				echo "<p>$notice<i><b>There are no ".ucfirst($_GET['pg'])." categories currently in the database.</b></i>";
			}
		
		} else { 
		// VIEW LISTING OF ALL WITHIN SELECTED CATEGORY
			$db = $_GET['pg'];
			if(isset($_GET['category'])){
				$category = $_GET['category'];
				$cname = mysql_result(mysql_query("SELECT `title` FROM `category` WHERE `id`='$category'"),0);
				echo "<p><b>".strtoupper($cname)." / ".strtoupper($tables[$p]['name']).":</b></p>";
			} else if(isset($_GET['searchquery'])) {
				echo "<p><b>Search Results for <i>".$_GET['searchquery']."</i></b></p>";
			}
			
			# FIND OUT WHAT TO LIST AS THE TITLE FIELD.. EVEN IF IT'S AN ARRAY
			$key = getKey($tables, $_GET['pg']);
			$listme = $tables[$key]['listme'];
			if(is_array($listme)) $title_listme = $listme[0];
			else $title_listme = $listme;
			
			# SEARCH QUERY
			if(isset($_GET['searchquery']) && $_GET['searchquery'] != ""){
				if(eregi("%20",$_GET['searchquery'])) $queryWords = expode("%20",$_GET['searchquery']);
				else $queryWords = array($_GET['searchquery']);
				foreach($queryWords AS $key => $val){
					$search .= "`".$_GET['searchfield']."` LIKE '%".$val."%' OR ";
				}
				$searchquery = "WHERE (".substr($search,0,(strlen($search)-4)).")";
				if(isset($_GET['category'])) $searchquery .= " AND `category`='$category'";
			} else if(isset($_GET['category'])){
				$searchquery = "WHERE `category`='$category'";
			}
			
			$t = mysql_result(mysql_query("SELECT COUNT(id) FROM `$db` ".($searchquery == "()" ? "" : $searchquery).""),0);
			$q = mysql_query("SELECT * FROM `$db` ".($searchquery == "()" ? "" : $searchquery)." ORDER BY `$ob` $or LIMIT $n, 15");
			
			
			//$t = mysql_result(mysql_query("SELECT COUNT(id) FROM `$db` WHERE `category`='$category'"),0);
			//$q = mysql_query("SELECT * FROM `$db` WHERE `category`='$category' ORDER BY `$ob` $or");
			if(mysql_num_rows($q) > 0){
				$listing = new listing;
				$listing->start($ob,$or,$n,mysql_num_rows($q),$t,$tables);
				while($qd = mysql_fetch_assoc($q)){
					$listing->listrow($qd,$tables,$db,'');
				}
				$listing->end($n,mysql_num_rows($q),$t,$tables);
				
			} else {
				echo "<p>$notice<i><b>There are no ".$cname." ".ucfirst($_GET['pg'])." currently in the database.</b></i>";
			}
			
		}
		
	}

?>