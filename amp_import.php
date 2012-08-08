<?php
/*
 * Template Name: AMP Importer
 *
 
 Drop this file into the theme folder and assign it as the custom template for a random post
 create a file called connection.php which sets up the $user and $pass variables for your DB
 
 Notes about textpattern format:
  -links to images are relative, in the format of '/images/123.jpg'
  -links to other posts on the site are explicit 'http://www.mbaproject.org/CATEGORY/ARTICLE-SLUG'
    because wordpress doesn't support a category prefix within it's pretty url scheme
    we have to scrub these out
  -categories from the old site don't translate 1-to-1 so we're ignoring all except for ones listed in
    $cat_replace 

*/
//kick us off the page if we're not logged in
if (!is_user_logged_in()){
header('Location: /');
}


/*
SETTINGS
*/
$user = ""; //
$pass = ""; //define these guys in another file
$dbname = "vvamp1";
include('connection.php');

//OPTIONS
$debug = false; //don't actually do anything to the WP database
$import_limit = 0; //bring only this many posts in if > 0
$mark_imported = true; //add a custom field 'imported=true' to these posts
$auto_publish = true; //publish posts after importing if they are published in amp
$clean_links = false; //scrub the category prefix out of links


?>
<html>
<body>

<?php 
if($_POST['go']=='true'){
  
  $con = mysql_connect('localhost',$user,$pass);
  if(!$con){
  die('connection didnt work :(<br/>');
  } else {
  echo 'connection worked';
  }
  
  //'textpattern' table in textpattern DB equiv of wp_posts
  mysql_select_db($dbname);
  $query = "SELECT *, a.id as article_id FROM articles as a where type = 10";
  $result = mysql_query($query);
  echo '<br/>'.mysql_numrows($result) . ' rows<br/>';
  
  
  //loop through all of the posts
  $i = 0;
	$amp2wp_map = array();
	$wp2parent_map = array();
  while ($row = mysql_fetch_assoc($result)) {
    print('Adding post: '.$row['title'].'<br/>');
		if($debug){
			print_r($row);
		}
    
    $body_text = $row['test'];
    //do some cleanup to remove those nasty microsoft smart quotes
    $body_text = str_replace(
      array("\xe2\x80\x98", "\xe2\x80\x99", "\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x93", "\xe2\x80\x94", "\xe2\x80\xa6"),
      array("'", "'", '"', '"', '-', '--', '...'),
      $body_text
    );
    $body_text = str_replace(
      array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133)),
      array("'", "'", '"', '"', '-', '--', '...'),
      $body_text
    );
   $postname = strtolower(str_replace(':','-',str_replace('.','-',str_replace(',', '-', str_replace(' ','-', $row['title']))))); 
    //start building out our post
    $post = array(
      'post_title' => $row['title'],
      'post_content' => $body_text,
      'post_author' => '1',
			'post_name' => $postname,
			'post_type' => 'page',
      'post_date' => $row['date']
    );
    

        
    // only publish things that are live (amp status 1)
    // if not set, wordpress saves post as a draft
    if($auto_publish && $row['publish']==1){
      $post['post_status'] = 'publish';
    }
    
    //insert the post
    if(!$debug){
			//why the actual fuck does this not work!
			//TODO FIX THIS BULLSHIT
      $pid = wp_insert_post($post);
			print_r($pid);
			/*if(is_object($pid)){
				die('exception!: ' . var_export($pid->get_error_messages(), true));
			}*/
      echo '<b>Added post!</b>';
		$amp2wp_map[$row['article_id']] = $pid;
    }
		 
    //add custom field imported = true so we can keep track of these guys
    if($mark_imported && !$debug){
      add_post_meta($pid,'imported',true);
			add_post_meta($pid,'oldid', $row['article_id']);
    }

		//add custom field of old_parent id so we can rebuild the heirarchy in a later pass
		$section_header_class = 8;
		$type = $row['type'];
		$parent_query = "SELECT id as parent_id FROM articles WHERE type=$type AND class=$section_header_class LIMIT 1";
		$parent_result = mysql_query($parent_query);
		$parent_article = mysql_fetch_assoc($parent_result);
		if(!$debug){
			add_post_meta($pid,'old_parent_id',$parent_article['parent_id']);
		}
		$wp2parent_map[$pid] = $parent_article['parent_id'];
 	
    
    echo ' - post added as '.$pid;
    echo '<br/><b>'.$row['title'].'</b></br>';
    //echo $body_text;
    echo '<hr/>';
    
    $i++;
    //if we're limiting and we're over our limit stop
    if($import_limit > 0 && ($i+1)>$import_limit){
      break;
    }
  }

	//second pass, import all of the heirarchy and url redirects
	echo '<pre>';
	echo "amp 2 wp array\n";
	print_r($amp2wp_map);
	echo "wp 2 parent\n";
	print_r($wp2parent_map);


	foreach($amp2wp_map as $amp_id => $wp_id){
		//don't do any of this in debug mode
		if($debug){
			$break;
		}
		//build heirarchy
		$old_parent_id = $wp2parent_map[$wp_id];
		$new_parent_id = $amp2wp_map[$old_parent_id];
		wp_update_post(array('ID' => $wp_id, 'post_parent' => $new_parent_id));
	
	  //build redirect
		$old_url = "/article.php?id=$amp_id";
    $new_url = "/?p=$wp_id";
		$auto_redirect_group = 3;
		$wpdb->query("INSERT INTO `wp_redirection_items` (`url`, `regex`, `group_id`, `status`, `action_type`, `action_code`, `action_data`, `match_type`) VALUES ($old_url, 0, 0, $auto_redirect_group, 'enabled', 'url', 301, $new_url, 'url')");

	}
 	
	
} else {
  echo '<h2>Please post the form to trigger the importer</h2>';
  if($auto_publish) {
   echo '-imported posts are set to be published by default!<br/>';
  } else {
    echo '-imported posts will be saved as drafts<br/>';
  }
  if($import_limit>0){
    echo '-importing first '.$import_limit.' posts';
  } else {

    echo '-importing all posts';
  }

}
?>
<br/><br/>
<form target="import" method="POST">
<input type="hidden" name="go" value="true">
<input type="submit" value="Go!" >
</form>

</body>
</html>

