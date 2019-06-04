<?	// MODULE: FORUM CATEGORIES
	// FOR MBCMS ALL 'CATEGORIES' USED THROUGHOUT THE FORUMS (BBS)

	echo '<div style="border:1px solid #ddd; background:#efefef; padding:15px;">';
	if($_GET['do'] == 'view'){
		echo "This CMS page allows you to view a listing of (by default) all categories and sub-categories, edit specific 
		  and add categories and sub-categories to refrence elsewhere on your site. 
		  Please select a category from the list below to view a listing of sub-categories, then edit particular categories";
	} else if($tables[$p]['blurb']){
		echo $tables[$p]['blurb'];
	}
	echo '</div>';
	
	if($_GET['do'] == 'edit'){
		// EDIT A SPECIFIC
		$q = mysql_query("SELECT * FROM `bb_categories` WHERE `id`='$id'");
		$qd = mysql_fetch_assoc($q);
		$form = new form;
		$form->start('POST','db_update.php','mixed');
		$form->hiddenfield('db',$pg);
		$form->hiddenfield('do','edit');
		for($i=0; $i<sizeof($tables[$p]['field']); $i++){
			formelement($form,$tables[$p]['lable'][$i], $tables[$p]['field'][$i], $qd[$tables[$p]['field'][$i]], $tables[$p]['type'][$i],$pg,$tables);
		}
		$form->end('Confirm','Are you sure you want to do this?');
		
	} else if($_GET['do'] == 'add') {
		// ADD A NEW
		$form = new form;
		$form->start('POST','db_update.php','mixed');
		$form->hiddenfield('db',$pg);
		$form->hiddenfield('do','add');
		for($i=0; $i<sizeof($tables[$p]['field']); $i++){
			formelement($form,$tables[$p]['lable'][$i], $tables[$p]['field'][$i], '', $tables[$p]['type'][$i],$pg,$tables);
		}
		$form->end('Confirm','Are you sure you want to do this?');
		
	} else {
		if(!isset($_GET['n'])) $n = 0; else $n = $_GET['n'];
		if(!isset($_GET['ob'])) $ob = 'id'; else $ob = $_GET['ob'];
		if(!isset($_GET['or'])) $or = 'ASC'; else $or = $_GET['or'];
		
		// VIEW LISTING OF ALL WITHIN SELECTED CATEGORY
		if($_GET['category']){ 
			$db = $_GET['pg'];
			$category = $_GET['category'];
			$cname = mysql_result(mysql_query("SELECT `type` FROM `bb_categories` WHERE `sub`='$category'"),0);
			echo "<p><b>".strtoupper($cname)." SUB CATEGORIES:</b></p>";
			$t = mysql_result(mysql_query("SELECT COUNT(id) FROM `bb_categories` WHERE `sub`='$category'"),0);
			$q = mysql_query("SELECT * FROM `bb_categories` WHERE `sub`='$category' ORDER BY `$ob` $or LIMIT $n, 15");
			if(mysql_num_rows($q) > 0){
				$listing = new listing;
				$listing->start($ob,$or,$n,mysql_num_rows($q),$t,$tables);
				while($qd = mysql_fetch_assoc($q)){
					$listing->listrow($qd,$tables,$db,'');
				}
				$listing->end();
				
			} else {
				echo "<p>$notice<i><b>There are no ".$cname." sub categories currently in the database.</b></i>";
			}
			
		// VIEW LISTING OF ALL CATEGORIES
		} else {
			$db = $_GET['pg'];
			echo "<p><b>MAIN CATEGORIES:</b></p>";
			$q = mysql_query("SELECT * FROM `bb_categories` WHERE `sub`='0' ORDER BY `$ob` $or LIMIT $n, 15");
			if(mysql_num_rows($q) > 0){
				$listing = new listing;
				$listing->start($ob,$or,$n,mysql_num_rows($q),$t,$tables);
				while($qd = mysql_fetch_assoc($q)){
					$listing->listrow($qd,$tables,$db,'category');
				}
				$listing->end();
				
			} else {
				echo "<p>$notice<i><b>There are no forum categories currently in the database.</b></i>";
			}
		}
		
	}
?>