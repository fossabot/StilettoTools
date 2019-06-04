<?
/* FIND HOW-TO NOTES AT THE BOTTOM OF THIS PAGE */
$tables = array(	  
		  
array( 'name'	=>	'Page Content', 
	   'table' 	=>	'pagecontent', 
	   'do' 	=>	'Edit current website page content for pre-determined editible locations.', 
	   'blurb'	=>	'Page Content are pre-defined blocks of text on your site. You can change the content of these blocks of text at any time. The changes made in the MB:CMS will appear on your site immediately.<br>See the <b>Note:</b> field for specific information on where this content resides on your site.',
	   'field'	=>	array('id','page','title','description', 'date'), 
	   'lable'	=>	array('ID','Page ID','Title','Description', 'Date'), 
	   'type'	=>	array('hidden','hidden','textfield','textarea','NULL'), 
	   'note'	=>	array('','do not modify unless adding','label shown in MB:CMS',''), 
	   'listme'	=>	'title',
	   'access' =>	array('0')
	  	  ),

array( 'name'	=>	'Gallery', 
	   'table' 	=>	'gallery', 
	   'do' 	=>	'Gallery Images', 
	   'blurb'	=>	'host may or may not have GD2 support. If it does not, this form should work for UPLOADS of properly sized images only. Will need to be revised if popups are needed.',
	   'field'	=>	array('id','title','image','precedence','active','date'), 
	   'lable'	=>	array('ID','Title','Image','Precedence','Active','Date'), 
	   'type'	=>	array('hidden','textfield','image','textfield','radiobuttonlist','NULL'), 
	   'imageproperties' =>	array('image' => array('width' => '223', 'height' => '168', 'frame' => NULL)),
	   'listme'	=>	'title', 
	   'access' =>	array('0')
	  	  ),

array( 'name'	=>	'Product Options', 
	   'table' 	=>	'product_options', 
	   'do' 	=>	'Gallery Images', 
	   'blurb'	=>	'',
	   'field'	=>	array('id','title','precedence','active','date'), 
	   'lable'	=>	array('ID','Title','Precedence','Active','Date'), 
	   'type'	=>	array('hidden','text','textfield','radiobuttonlist','NULL'), 
	   'listme'	=>	'title', 
	   'access' =>	array('x')
	  	  ),

array( 'name'	=>	'Orders', 
	   'table' 	=>	'orders', 
	   'do' 	=>	'Manage Personalization Orders', 
	   'blurb'	=>	'Note: When you change an order to "charged", the customer\'s credit card information will be removed from this page. There is no going back after this data is removed.',
	   'field'	=>	array('id','receipt','category','active','date'), 
	   'lable'	=>	array('ID','Receipt','Category','Active','Date'), 
	   'type'	=>	array('hidden','text','selectbox','NULL','NULL'), 
	   'listme'	=>	'receipt', 
	   'access' =>	array('0','1')
	  	  ),
	   	    
array( 'name'	=>	'MB:CMS Admin Users', 
	   'table' 	=>	'mbcms_users', 
	   'do' 	=>	'Add, Edit and Delete users with administrative rights to the MB:CMS', 
	   'field'	=>	array('id', 'name', 'email', 'nameu', 'pass', 'level', 'active', 'date'), 
	   'lable'	=>	array('ID', 'Name', 'Email', 'Login', 'Password', 'Auth Level', 'Active', 'Date'), 
	   'type'	=>	array('hidden','textfield','textfield','textfield','textfield','selectbox','radiobuttonlist','NULL'), 
	   'note'	=>	array('','users name','for reference only','no spaces or special characters','','','',''),
	   'listme'	=>	'name',
	   'select'	=>	array('level' => '0,Full Access|1,Order Access Only|'),
	   'access' =>	array('0')
	   	  )
	);

global $tables;


/*

How to edit this document:

Each key in the $tables array is a side navigation link in the MB:CMS, in the same order as listed here.

1.  name   = 	Lable which shows in the MB:CMS for this page, in the side nav and detail page
2.  table  = 	Name of the database table which is used in this page
3.  do     = 	Nav rollover text which shows up below the nav. Kind of an initial explanation of what the page does
4.  field  = 	array of all the fields, in order shown in the MB:CMS which are visible/editible. These should be the same field names as in the database table
5.  lable  = 	Lable shown next to the field in the MB:CMS. You can have a field called 'description' but the client sees "Long Detail" or something in the MB:CMS
6.  type   = 	Type of front-end field to show. Fields include textfield, textarea, selectbox, selectmult, radiobuttonlist, text (not editible), and null
				Note that selectbox (and selectmult) will auto generate themselves if the field name is also a table name. selectmult fields store a comma delinated list of IDs in the field specified.
7.  note   =	A note which shows next to the field to instruct the user as to the format of allowed input
8.  listme =	The field used as the main "title" field. Usually "title", but might be something like "email" or "username"
9.  select =	Optional field which allows you to create a custom select box in the MB:CMS. Format is ID,Text lable|ID,Text lable... etc.
10. access =	Limits access to certain pages based on MB:CMS admin user "level". Access can be defined by the developer in the mbcms_users "select" field in this document.

*/
?>