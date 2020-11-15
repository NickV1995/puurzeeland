<?php
include REVIEW_PLUGIN_MODEL_DIR.'/ReviewLabel.php';

//class var
$review_label = new ReviewLabel();

// zet base url naar current file en voeg pagina specifieke vars toe
$base_url = get_admin_url() . 'admin.php';
$params = array('page' => basename(__FILE__,".php"));

// append parameters aan base url
$base_url = add_query_arg($params, $base_url);

$post_array = $review_label->getPostValues();

$get_array = $review_label->getGetValues();

$label_list = $review_label->getReviewLabelList();

// var_dump($post_array);
// var_dump($get_array);

$error = FALSE;

$action = FALSE;

// controleer de POST data
if (!empty($post_array)){
    //controleer add formulier
    $add = FALSE;
    if (!is_null($post_array['add'])) {
      // sla het label op
      $result = $review_label->save($post_array);
      
      if ($result){
      $add = TRUE;
      }else {
        $error = TRUE;
      }
    }
    if (isset($post_array['update'])){
      $review_label->update($post_array);
    }
}

// get get data uit gefilterde array
$get_array = $review_label->getGetValues();

$action = FALSE;

if (!empty($get_array)) {
  //check de actions
  if(isset($get_array['action'])){
    $action = $review_label->handleGetAction($get_array);
  }
}
//check of de action == update : daarna begin update form
echo (($action == 'update') ? '<form action="'. $base_url .'" method="post">' : '');
?>
<table class="table table-dark">
  <thead>
  <caption>Review labels</caption>
    <tr>
      <th scope="col-md-4">Id</th>
      <th scope="col-md-4">Label</th>
      <th scope="col-md-4">Description</th>
    </tr>
  </thead>
  <?php if ($review_label->getAantalLabels() < 1) { ?>
    <tr>
      <th scope="col">Er zijn nog geen labels aanwezig</th>
    </tr>
  <?php } else {  $label_list; 
    foreach($label_list as $label_object) {
      //update link
      $params = array('action' => 'update', 'id' => $label_object->getId());

      $update_link = add_query_arg($params, $base_url);

      $params = array('action' => 'delete', 'id' => $label_object->getId());

      $delete_link = add_query_arg($params, $base_url);

      $params = array('action');
    ?>
    <tr>
      <th scope="col-md-4"><?php echo $label_object->getId(); ?></th>
      <?php if (($action == 'update') && ($label_object->getId() == $get_array['id'])) { ?>
        <div class="form-group">
          <input type="hidden" name="id" class="form-control"  value="<?php echo $label_object->getId(); ?>">
        </div>
        <div class="form-group">
          <input type="text" name="label" class="form-control"  value="<?php echo $label_object->getLabel(); ?>">
        </div>
        <div class="form-group">
          <input type="text" name="description" class="form-control" value="<?php echo $label_object->getDescription(); ?>">
        </div>
        <button type="submit" name="update" value="Updaten">Updaten</button>
      <?php } else { ?>
      <th scope="col-md-4"><?php echo $label_object->getLabel(); ?></th>
      <th scope="col-md-4"><?php echo $label_object->getDescription(); ?></th>
      <?php if ($action !== 'update') { ?>
      <th scope="col-md-4"><a href="<?php echo $update_link; ?>">Update</a></th>
      <th scope="col-md-4"><a href="<?php echo $delete_link; ?>">Delete</a></th>
      <?php } }?>
    </tr>
    <?php } 
  }?>
</table>
<?php echo (($action == 'update') ? '</form>' : '') ?>
<form action="<?php echo $base_url; ?>" method="post">
<?php if ($action !== 'update'){  ?>
  <div class="form-group">
    <input type="text" name="label" class="form-control"  placeholder="Label">
  </div>
  <div class="form-group">
    <input type="text" name="description" class="form-control"  placeholder="Omschrijving">
  </div>
  <button type="submit" name="add" value="toevoegen" class="btn btn-primary">Toevoegen</button>
<?php }?>
</form>