<link rel='stylesheet' type='text/css' href='css/style.php' />
<?php

include REVIEW_PLUGIN_MODEL_DIR.'/ReviewList.php';
require_once REVIEW_PLUGIN_MODEL_DIR.'/NewReview.php';
require_once REVIEW_PLUGIN_MODEL_DIR.'/ReviewLabel.php';

$nieuwe_review = new NewReview();
$review_list = new Review();
$review_label = new ReviewLabel();

$review_label_list = $review_label->getReviewLabelList();

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
}?>

<div class="container">
<?php if ($review_list->getNumberOfApprovedReviews() < 1) {?>

  <div class="row">
    <div class="col-md-12">
      Er zijn nog geen goedgekeurde recensies aanwezig
    </div>
  </div>

<?php }  else { 
  $review_lijst = $review_list->getApprovedReviewList();

  foreach ($review_lijst as $review_list_obj){
  ?>
<div class="row">
  <div class="col-md-4"><?php echo $review_list_obj->getNaam();?></div>
  <div class="col-md-4"><?php echo $review_list_obj->getLabel();?></div>
  <div class="col-md-4"><?php echo date('d-m-Y', strtotime($review_list_obj->getDatum()));?></div>
<div class="row">
  <div class="col-md-12">"<?php echo $review_list_obj->getRecensie();?>"</div>
</div>

<?php }}?>

<div class="container">
    <div class="row">
    <div class="col-md-6">
<h2><?php echo 'Laat hier een recensie achter'?></h2>
</div>
<div class="col-md-6">
<form action="<?php $base_url;?>" method="post">
<button class="btn btn-primary" type="button" data-naam="Anoniem" data-email="ano@niem.anoniem">Anoniem</button>
  <!-- <label >Klik op 'Anoniem' om een anonieme review in te vullen</label> -->
</div>
<div class="container">
    <div class="row d-md-block">
        <div class="col-9 ">
          <?php echo 'Naam:';?></td>
          <input type="text" id="naam" required name="naam"/></td>
        </div>
        <div class="col-12 col-md-9">
          <?php echo 'Email:';?></td>
          <input type="email" id="email" required name="email"/></td>
        </div>
        <div class="col-12 col-md-9">
          <?php echo 'Label: ';?></td>
          <select name="label"><?php foreach ($review_label_list as $review_label_object) { ?>
          <option value="<?php echo $review_label_object->getLabel();?>"><?php echo $review_label_object->getLabel(); ?></option>
          <?php } ?></select>
        </div>
        <div class="col-12 col-md-9">
          <?php echo 'Recensie:';?></td>
          <textarea type="text" name="review" rows="5" cols="80"></textarea>
        </div>
        <div class="col-12 col-md-9">
        <input type="checkbox" required name="terms"> Ik geef toestemming om ingevulde gegevens op te slaan en te gebruiken.
        <br><br>
        <input type="submit" name="add_review" value="<?php echo __('Versturen');?>"/>
        </div>
    </div>
</div>
 <!--<tr>
 <td class="privacy-statement">Voor de privacyverklaring klikt u <a href='http://testpuur.webnv.nl/wp-content/uploads/2020/10/privacy_statement_puurzeeland_22-11-2019.pdf' target="_blank" >hier</a></td>
 </tr>-->
<script>

const buttons = document.querySelectorAll("button");
const naamField = document.getElementById("naam");
const emailField = document.getElementById("email");

buttons.forEach(button => {
  button.addEventListener("click", () => {
    naamField.value = button.dataset.naam;
    emailField.value = button.dataset.email;
  });
})
</script>