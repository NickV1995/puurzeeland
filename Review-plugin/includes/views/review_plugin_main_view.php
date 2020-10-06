<?php

include REVIEW_PLUGIN_MODEL_DIR.'/ReviewList.php';
require_once REVIEW_PLUGIN_MODEL_DIR.'/NewReview.php';

$nieuwe_review = new NewReview();
$review_list = new Review();

// Set base url to current file and add page specific vars
$base_url = get_admin_url().'admin.php';
$params = array( 'page' => basename(__FILE__,".php"));
// Add params to base url
$base_url = add_query_arg( $params, $base_url );

// Get the POST data in filtered array
$post_array = $nieuwe_review->getPostValues();

// Collect Errors
$error = FALSE;
// Check the POST data
if (!empty($post_array)){

 // Check the add form:
 $add = FALSE;
 if (isset($post_array['add_review']) ){
 // Save event categorie
 $result = $nieuwe_review->save($post_array);
 if ($result){
 // Save was succesfull
 $add = TRUE;
 echo 'Uw recensie is verzonden!'; 
 } else {
 // Indicate error
 $error = TRUE;
 }
 }
}

?>
<?php if ($review_list->getNumberOfApprovedReviews() < 1) {
  
  ?>

    <tr><td colspan="3">Er zijn nog geen goedgekeurde recensies aanwezig</td></tr>

<?php }  else { 
  $review_lijst = $review_list->getApprovedReviewList();

  foreach ($review_lijst as $review_list_obj){
  ?>
  <table>
  <tr>
  <td width='300'><?php echo $review_list_obj->getNaam();?></td>
  <td width='900'>"<?php echo $review_list_obj->getRecensie();?>"</td>
  <td width='200'><?php echo date('d-m-Y', strtotime($review_list_obj->getDatum()));?></td>
  </tr>
  </table>
<?php

}?>
<?php }?>


<h2><?php echo __('Laat hier een recensie achter.')?></h2>
<p />
<form action="<?php $base_url;?>" method="post">
 <tr>
 <td><?php echo __('Naam:');?></td>
 <td><input type="text" required name="naam"/></td>
 <td><?php echo __('Email:');?></td>
 <td><input type="email" required name="email"/></td>
 </tr>
 <tr>
 <td><?php echo __('Recensie:');?></td>
 <td><textarea type="text" name="review" rows="5" cols="80" 
 ></textarea></td>
 </tr>
 <tr>
 <td>&nbsp;</td>
 </tr>
 <tr>
 <td><input type="checkbox" required name="terms"> Ik geef toestemming om ingevulde gegevens op te slaan en te gebruiken.</td>
 <td>
 <input type="submit" name="add_review" value="<?php echo __('Versturen');?>" /></td>
 <td colspan="2">&nbsp;</td>
 </tr>
 <tr>
 <td>Voor de privacyverklaring klikt u <a href='http://testpuur.webnv.nl/wp-content/uploads/2020/10/privacy_statement_puurzeeland_22-11-2019.pdf' target="_blank" >hier</a></td>
 </tr>
</form>