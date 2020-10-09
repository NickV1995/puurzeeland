<?php

class Review{

  public $goedgekeurd = '';

 
 public function setId( $id ){
  if ( is_int(intval($id) ) ){
    $this->id = $id;
  }
  
}

public function setNaam( $naam ){
  if ( is_string($naam)){
    $this->naam = trim($naam);
  }
  
}

public function setRecensie( $recensie ){
  if ( is_string($recensie)){
    $this->recensie = trim($recensie);
  }
  
}

public function setDatum( $datum ){
  if ( date($datum)){
    $this->datum = trim($datum);
  }
  
}

public function setGoedGekeurd( $goedgekeurd ){
  if ( is_string($goedgekeurd)){
    $this->goedgekeurd = trim($goedgekeurd);
  }
  
}

/**
 * 
 * @return int    
 */
public function getId(){
  
  return $this->id;
  
}

public function getNaam(){
    
  return $this->naam;
    
}

public function getRecensie(){
    
  return $this->recensie;
    
}

public function getDatum(){
    
  return $this->datum;
    
}

public function getGoedGekeurd(){
    
  return $this->goedgekeurd;
    
}

  //return number of reviews in DB
  public function getNumberOfReviews(){

    global $wpdb;

    $query = "SELECT COUNT(*) AS nr FROM`". $wpdb->prefix . "review`";

    $result = $wpdb->get_results($query, ARRAY_A);

    return $result[0]['nr'];

  }

  public function getNumberOfNewReviews(){

    global $wpdb;

    $query = ("SELECT COUNT(*) AS nr FROM ". $this->getTableName() . " WHERE goedgekeurd='In afwachting'");

    $result = $wpdb->get_results($query, ARRAY_A);

    return $result[0]['nr'];

  }

  public function getNumberOfApprovedReviews(){

    global $wpdb;

    $query = ("SELECT COUNT(*) AS nr FROM ". $this->getTableName() . " WHERE goedgekeurd='Ja'");

    $result = $wpdb->get_results($query, ARRAY_A);

    return $result[0]['nr'];

  }

  public function getApprovedReviewList(){

    
    global $wpdb;
        
    $return_array = array();    
    $result_array = $wpdb->get_results("SELECT * FROM ". $this->getTableName() . " WHERE goedgekeurd='Ja' ORDER BY `review_datum` DESC", ARRAY_A);

    foreach($result_array as $idx => $array){
      $review = new Review();
      $review->setNaam($array['naam']);
      $review->setId($array['review_id']);
      $review->setRecensie($array['recensie']);
      $review->setDatum($array['review_datum']);
      $review->setGoedgekeurd($array['goedgekeurd']);

      $return_array[] = $review;
    }

    return $return_array;
  }

    
  public function getReviewList(){
    
    global $wpdb;
    $return_array = array();
    $result_array = $wpdb->get_results("SELECT * FROM ". $this->getTableName() . " WHERE goedgekeurd='In afwachting' ORDER BY `review_datum` DESC", ARRAY_A);

    // for all db results:
    foreach($result_array as $idx => $array){
      $review = new Review();
      $review->setNaam($array['naam']);
      $review->setId($array['review_id']);
      $review->setRecensie($array['recensie']);
      $review->setDatum($array['review_datum']);
      $review->setGoedgekeurd($array['goedgekeurd']);

      $return_array[] = $review;
    }

    return $return_array;
  }

  public function getPostValues(){

    // Define the check for params
    $post_check_array = array (
    'action' => array('filter' => FILTER_SANITIZE_STRING ),

    'id' => array( 'filter' => FILTER_VALIDATE_INT )
    );
    // Get filtered input:
    $inputs = filter_input_array( INPUT_POST, $post_check_array );
    // RTS
    return $inputs;
    }

  public function getGetValues(){
    // Define the check for params
    $get_check_array = array (
    // Action
    'action' => array('filter' => FILTER_SANITIZE_STRING ),
   
    // Id of current row
    'id' => array( 'filter' => FILTER_VALIDATE_INT )
    );
    // Get filtered input:
    $inputs = filter_input_array( INPUT_GET, $get_check_array );
    // RTS
    return $inputs;
    }

  private function getTableName(){

    global $wpdb;

    return $table = $wpdb->prefix . "review";
    
  }

  public function delete($input_array){

    try{
      if(!isset($input_array['id']))

      throw new Exception(__('Missing mandatory fields'));

      global $wpdb;
      $query = $wpdb->prepare("Delete FROM `" . $this->getTableName() . "` WHERE `review_id` = %d", $input_array['id']);

      $wpdb->query($query);

      $wpdb->delete($this->getTableName(), array('review_id' => $input_array['id']), array('%d'));

      if(!empty($wpdb->last_error)){
        
        throw new Exception($wpdb->last_error);
      
      }
    } catch(Exception $exc){
      echo '<pre>';
      $this->last_error = $exc->getMessage();
      echo $exc->gettraceAsString();
      echo $exc->getMessage();
      echo '<pre>';
    }
    return true;
  }

  public function goedkeuren($input_array){

    try{
      if(!isset($input_array['id']))

      throw new Exception(__('Missing mandatory fields'));

      global $wpdb;
      // $query = $wpdb->prepare("UPDATE FROM `" . $this->getTableName() . "` WHERE `review_id` = %d", $input_array['id']);

      // $wpdb->query($query);

      $wpdb->query($wpdb->prepare("UPDATE ".$this->getTableName(). " SET `goedgekeurd` = 'Ja' ". "WHERE ". $this->getTableName() ."`review_id` =%d;", $input_array['id']) );

      if(!empty($wpdb->last_error)){
        
        throw new Exception($wpdb->last_error);
      
      }
    } catch(Exception $exc){
      echo '<pre>';
      $this->last_error = $exc->getMessage();
      echo $exc->gettraceAsString();
      echo $exc->getMessage();
      echo '<pre>';
    }
    return true;
  }

  public function handleGetAction( $get_array ){
    $action = '';
   
    switch($get_array['action']){ 


      case 'goedkeuren':
        // Delete current id if provided
        if ( !is_null($get_array['id']) ){
          $this->goedkeuren($get_array);
        }
        $action = 'goedkeuren';
      break;

      case 'delete':
        // Delete current id if provided
        if ( !is_null($get_array['id']) ){
          $this->delete($get_array);
        }
        $action = 'delete';
      break;
      default:
      // Oops
    break;
  }
  return $action;
}

}