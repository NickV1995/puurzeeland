<?php

include REVIEW_PLUGIN_MODEL_DIR . '/ReviewList.php';
require_once REVIEW_PLUGIN_MODEL_DIR.'/ReviewLabel.php';

$review_list = new Review;

// Set base url to current file and add page specific vars
$base_url = get_admin_url().'admin.php';

$params = array('page' => basename(__FILE__,".php"));
// Add params to base url
$base_url = add_query_arg($params, $base_url);

// Get the GET data in filtered array
$get_array = $review_list->getGetValues();

$post_array = $review_list ->getPostValues();


$action = FALSE;
if (!empty($get_array)){

 // Check actions
 if (isset($get_array['action'])){
 $action = $review_list->handleGetAction($get_array);
 }
}
?>

<div class="wrap">

<h1>Goedgekeurde recensies.</h1>
<?php echo 'Je hebt ' . $review_list->getNumberOfApprovedReviews() . ' goedgekeurde recensie(s).'; ?>
<table>
<caption>Alle goedgekeurde recensies</caption>
<thead>
<!-- <th width="10">ID</th> -->
<th width="20%">Naam</th>
<th width="66%">Recensie</th>
<th width="">Label</th>
<th width="25%">Datum</th>
<th width="20%">Actie</th>
</tr>
</thead>
</table>
<?php
if ($review_list->getNumberOfApprovedReviews() < 1) {
  
  ?>

    <tr><td colspan="3">Er zijn nog geen goedgekeurde recensies aanwezig</td></tr>

<?php }  else { 
  $review_lijst = $review_list->getApprovedReviewList();

  foreach ($review_lijst as $review_list_obj){

    $params = array( 'action' => 'delete', 'id' => $review_list_obj->getId());

    $del_link = add_query_arg( $params, $base_url );

  ?>
  <table>
  <tr>
  <?php $review_list_obj->getId();?>
  <td width='20%'><?php echo $review_list_obj->getNaam();?></td>
  <td width='70%'><?php echo $review_list_obj->getRecensie();?></td>
  <td width='70%'><?php echo $review_list_obj->getLabel();?></td>
  <td width='20%'><?php echo date('d-m-Y', strtotime($review_list_obj->getDatum()));?></td>
  <td td width='10%'>
  <button title="verwijderen"><a href='<?php echo $del_link; ?>' onclick="return checkDelete()"><i style="color:red;" class="fas fa-minus-circle"></i></a></button>
  </td>
  </tr>
  <tr>
    <hr>
  </tr>
<?php } ?>
  </table>
<?php } ?>

</div>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Weet je zeker dat je deze recensie wilt verwijderen? Dit kan niet ongedaan gemaakt worden.');
}
</script>