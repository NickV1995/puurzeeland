<?php
include REVIEW_PLUGIN_MODEL_DIR . '/ReviewList.php';

$review_list = new Review;

// Set base url to current file and add page specific vars
$base_url = get_admin_url().'admin.php';

$params = array('page' => basename(__FILE__,".php"));
// Add params to base url
$base_url = add_query_arg($params, $base_url);

// Get the GET data in filtered array
$get_array = $review_list->getGetValues();

// Get the post data in filtered array
$post_array = $review_list ->getPostValues();

// Keep track of current action.
$action = FALSE;
if (!empty($get_array)){

 // Check actions
 if (isset($get_array['action'])){
 $action = $review_list->handleGetAction($get_array);
 }
}

?>
<div class="wrap">

<h1>Nieuwe recensies</h1>
<?php echo 'Je hebt ' . $review_list->getNumberOfNewReviews() . ' nieuwe recensie(s)!'; ?>
<table>
<caption>Alle nieuwe Recensies</caption>
<thead>
<!-- <th width="10">ID</th> -->
<td width="20%"><b>Naam</b</td>
<td width="60%"><b>Recensie</b</td>
<td width="12%"><b>Datum</b</td>
<td width="10%"><b>Status</b</td>
<td width="20%"><b>Actie</b></td>
</tr>
</thead>
</table>
<?php

//*
if ($review_list->getNumberOfReviews() < 1) {
  
  ?>

    <tr><td colspan="3">Er zijn nog geen recensies aanwezig</td></tr>

<?php }  else { 
  $review_lijst = $review_list->getReviewList();

  foreach ($review_lijst as $review_list_obj){

    $params = array( 'action' => 'delete', 'id' => $review_list_obj->getId());

    $del_link = add_query_arg( $params, $base_url ); 

    $params = array( 'action' => 'goedkeuren', 'id' => $review_list_obj->getId());

    $approve_link = add_query_arg( $params, $base_url );

  ?>
  <table>
  <tr>
  <?php $review_list_obj->getId();?>
  <td width='20%'><?php echo $review_list_obj->getNaam();?></td>
  <td width='59%'><?php echo $review_list_obj->getRecensie();?></td>
  <td width='12%'><?php echo date('d-m-Y', strtotime($review_list_obj->getDatum()));?></td>
  <td width='16%'><?php echo $review_list_obj->getGoedgekeurd();?></td>
  <td width='20%'>
  <button title="goedkeuren"><a href='<?php echo $approve_link; ?>'><i style="color:green;" class="fas fa-check-circle"></i></a></button>
  </td>
  <td >
  <button title="verwijderen"><a href='<?php echo $del_link; ?>' onclick="return checkDelete()"><i style="color:red;" class="fas fa-minus-circle"></i></a></button>
  </td>
  </tr>  
  <tr>
    <hr>
  </tr>
<?php }?> 
</table> 
<?php }?> 


</div>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Weet je zeker dat je deze recensie wilt verwijderen? Dit kan niet ongedaan gemaakt worden.');
}
</script>