<?php

class NewReview{

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

  public function getPostValues(){

    // Define the check for params
    $post_check_array = array (
    // submit action
    'add_review' => array('filter' => FILTER_SANITIZE_STRING ),
   
    // event type name.
    'naam' => array('filter' => FILTER_SANITIZE_STRING ),
    // Help text
    'email' => array('filter' => FILTER_SANITIZE_STRING ),

    'review' => array('filter' => FILTER_SANITIZE_STRING )
    );
    // Get filtered input:
    $inputs = filter_input_array( INPUT_POST, $post_check_array );
    // RTS
    return $inputs;
    }

    public function save($input_array){

      if (!isset($input_array['naam']) OR
     !isset($input_array['email']))
      return FALSE;
     
      global $wpdb;
     
      try {
        if ( !isset($input_array['naam']) OR
       !isset($input_array['email'])){
        // Mandatory fields are missing
        throw new Exception(__("Missing mandatory fields"));
        }
        if ( (strlen($input_array['naam']) < 1) OR
       (strlen($input_array['email']) < 1) ){
        // Mandatory fields are empty
        throw new Exception( __("Empty mandatory fields") );
        }
       
        global $wpdb;
       
        // Insert query
        $wpdb->query($wpdb->prepare("INSERT INTO " . $this->getTableName() . "(`review_id`, `naam`, `recensie`, `review_datum`,`goedgekeurd`) VALUES (NULL,'%s' , '%s', current_timestamp(), 'In afwachting');", $input_array['naam'], $input_array['review']));

        // Error ? It's in there:
        if ( !empty($wpdb->last_error) ){
        $this->last_error = $wpdb->last_error;
        return FALSE;
        }
        /*
        echo '<pre>';
        echo __FILE__.__LINE__.'<br />';
        var_dump($wpdb);
        echo '</pre>';
        //*/
        } catch (Exception $exc) {
        // @todo: Add error handling
        echo '<pre>'. $exc->getTraceAsString() .'</pre>';
        }
      return TRUE;
      
      }

      private function getTableName(){

        global $wpdb;
    
        return $table = $wpdb->prefix . "review";
        
      }
}