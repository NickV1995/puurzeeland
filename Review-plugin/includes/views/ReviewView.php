<?php

require_once REVIEW_PLUGIN_MODEL_DIR.'/NewReview.php';

class ReviewView{

  private $NewReview;

  public function __construct() {

    $this->NewReview = new NewReview();
  }

public function setId($id){

  if (is_string($id)){
        
    $this->$id = trim($id);
    
  }
}

public function setNaam($naam){

    if (is_string($naam)){
        $this->naam = trim($naam);
    }
}

public function setEmail($email){

  if (is_string($email)){
      $this->email = trim($email);
  }
}

public function setReview($review){

  if (is_string($review)){
      $this->review = trim($review);
  }
}

public function getId(){

  return $this->id;
}

public function getNaam(){

  return $this->naam;
}

public function getEmail(){

  return $this->email;
}

public function getReview(){

  return $this->review;
}

public function getGetValues(){
  // Define the check for params
  $get_check_array = array (

    'id' => array('filter' => FILTER_VALIDATE_INT),
            
    'naam' => array('filter' => FILTER_SANITIZE_STRING ),

            // steen maat
    'email' => array('filter' => FILTER_SANITIZE_EMAIL ),

            // Steen soort
    'review' => array('filter' => FILTER_SANITIZE_STRING )
  );
  // Get filtered input:
  return filter_input_array( INPUT_GET, $get_check_array );
}

public function getPostValues(){
  // Define the check for params
  $post_check_array = array (

      // submit action
      'add_review' => array('filter' => FILTER_SANITIZE_STRING ),

     
      'naam' => array('filter' => FILTER_SANITIZE_STRING ),

      
      'email' => array('filter' => FILTER_SANITIZE_EMAIL  ),
  
      'review' => array('filter' => FILTER_SANITIZE_STRING  ),

      'id' => array('filter' => FILTER_VALIDATE_INT)
  );
  // Get filtered input:
  $post_inputs = filter_input_array( INPUT_POST, $post_check_array );
  var_dump($post_inputs);
  return $post_inputs;
}

public function is_submit_review_add_form( $post_inputs )
    {
        if (!is_null($post_inputs['add_review'])) return TRUE;

        return FALSE;
    }

    public function check_review_save_form ( $post_inputs )
    {

        // Special wordpress error class
        $errors = new WP_Error();

//        // Title
//        try {
//            $this->steen->checkSteenTitle($post_inputs['steen_title']);
//        } catch (Exception $exc) {
//            $errors->add('steen_title', $exc->getMessage());
//        }
//        // Soort ID
//        try {
//            $this->steen->checkSoort($post_inputs['fk_steen_soort']);
//        } catch (Exception $exc) {
//            $errors->add('fk_steen_soort', $exc->getMessage());
//        }
//        // Maat ID
//        try {
//            $this->steen->checkMaat($post_inputs['fk_steen_maat']);
//        } catch (Exception $exc) {
//            $errors->add('fk_steen_maat', $exc->getMessage());
//        }
//        // Aantal
//        try {
//            $this->steen->checkAantal($post_inputs['steen_aantal']);
//        } catch (Exception $exc) {
//            $errors->add('steen_aantal', $exc->getMessage());
//        }
//        // Kleur
//        try {
//            $this->steen->checkKleur($post_inputs['steen_kleur']);
//        } catch (Exception $exc) {
//            $errors->add('steen_kleur', $exc->getMessage());
//        }
//
//        // Info
//        try {
//            $this->steen->checkInfo($post_inputs['steen_info']);
//        } catch (Exception $exc) {
//            $errors->add('steen_info', $exc->getMessage());
//        }

        // Check for errors before saving the date
        if ($errors->get_error_code()) return $errors;
        return TRUE; // return the real result
    }

}