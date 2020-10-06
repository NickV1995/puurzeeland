<?php
global $wpdb;
if(isset($_POST['add_review'])){ // Fetching variables of the form which travels in URL
$naam = $_POST['naam'];
$email = $_POST['email'];
$review = $_POST['review'];
if($naam !=''||$email !=''){
//Insert Query of SQL
$query = $wpdb->prepare("INSERT INTO `wp_review` (`review_id`, `naam`, `recensie`, `review_datum`, `goedgekeurd`) VALUES (NULL, '$naam', '$review', current_timestamp(), 'In afwachting')");

 
$wpdb->query($query );

if ( !empty($wpdb->last_error) ){

  $this->last_error = $wpdb->last_error;

  $error->get_error_message($this->last_error);

return $error;

}


} else {

 // Some WP_ERROR on input vars
 // var_dump($error);

return $error;

}
 // Return the last inserted id (Id from the newly created event)
return $wpdb->insert_id;
}?>