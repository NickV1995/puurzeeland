<?php

class ReviewLabel {

    public function setId($id) {
        if (is_int(intval($id))){
            $this->id = $id;
        }
    }

    public function setLabel($label) {
        if (is_string ($label)){
            $this->label = trim($label);
        }
    }

    public function setDescription($description) {
        if (is_string ($description)){
            $this->description = trim($description);
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPostValues() {
        // definieer check naar parameters uit verzonden formulier
        $post_check_array = array(

            // toevoegen action
            'add' => array( 'filter' => FILTER_SANITIZE_STRING),

            //action update
            'update' => array('filer' => FILTER_SANITIZE_STRING),

            // label naam
            'label' => array('filter' => FILTER_SANITIZE_STRING),

            // label description
            'description' => array('filter' => FILTER_SANITIZE_STRING),

            //label id
            'id' => array('filter' => FILTER_VALIDATE_INT)
        );

        // get gefilterde input
        $inputs = filter_input_array(INPUT_POST, $post_check_array);

        return $inputs;
    }

    public function save($input_array) {
        //check of beide inputvelden zijn ingevuld
        if ((strlen($input_array['label']) > 1) AND (strlen($input_array['description']) > 1) ){
            global $wpdb;
            //insert query
            $wpdb->query($wpdb->prepare("INSERT INTO `". $wpdb->prefix."review_label` ( `label`, `description`)". " VALUES ('%s', '%s');",$input_array['label'], $input_array['description']));

            echo 'Het label is opgeslagen.';
            
            return TRUE;
        } else {

            echo  'Vul aub alle velden in!';
            
            return FALSE;
        }
        
    }

    public function getAantalLabels() {
        global $wpdb;

        // select query om aantal reviews op te halen
        $query = "SELECT COUNT(*) AS nr FROM `" . $wpdb->prefix . "review_label`";
        
        $result = $wpdb->get_results($query, ARRAY_A);

        return $result[0]['nr'];
    }

    public function getReviewLabelList() {
        global $wpdb;

        $return_array = array();

        $result_array = $wpdb->get_results("SELECT * FROM `wp_review_label` ORDER BY `id_label`", ARRAY_A);

        //var_dump($result_array);

        // voor alle db resultaten
        foreach ($result_array as $idx => $array) {
            // nieuw object
            $label = new ReviewLabel();
            // set info
            $label->setId($array['id_label']);
            $label->setLabel($array['label']);
            $label->setDescription($array['description']);

            //voeg nieuw object toe aan return array
            $return_array[] = $label;
        }

        return $return_array;
    }

    public function getGetValues() {
        //definieer check naar parameters
        $get_check_array = array (

            'action' => array('filter' => FILTER_SANITIZE_STRING),

            'id' => array('filter' => FILTER_VALIDATE_INT)
        );

        //GET gefilterde input
        $inputs = filter_input_array(INPUT_GET, $get_check_array);

        return $inputs;
    }

    public function handleGetAction($get_array) {
        $action = '';

        switch($get_array['action']){
            case 'update':
            if(!is_null($get_array['id'])){
                $action = $get_array['action'];
            }break;
            
            case 'delete':
            if(!is_null($get_array['id'])){
                $this->delete($get_array);   
            }
            $action = 'delete';
            break;

            default:
            // default waarde
            break;
        }
        
        return $action;
    }

    public function getTableName() {

        global $wpdb;

        return $this->$wpdb->prefix . "review_label";
    }

    public function update($input_array) {

        try {
            $array_fields = array('id', 'label', 'description');
            $table_fields = array('id_label', 'label' , 'description');
            $data_array = array();

            foreach($array_fields as $field) {
                if (!isset($input_array[$field])) {
                    throw new Exception(__("$field is verplicht om te updaten"));
                }
                $data_array[] = $input_array[$field];
            }

            global $wpdb;

            //update query
            $wpdb->query($wpdb->prepare("UPDATE `wp_review_label` "." SET `label` = '%s', `description` = '%s'" ." WHERE `wp_review_label`.`id_label` =%d;", $input_array['label'], $input_array['description'], $input_array['id']));
        
            } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->last_error = $exc->getMessage();

            return FALSE;
        }

        return TRUE;
    }

    public function delete($input_array) {
        try {
            if (!isset($input_array['id']))
            throw new Exception (__('Mist verplichte velden'));

            global $wpdb;

            $query = $wpdb->prepare("DELETE FROM `wp_review_label` WHERE `id_label` = %d;", $input_array['id']);

            $wpdb->query($query);

            if (!empty($wpdb->last_error)) {
                throw new Exception($wpdb->last_error);
            }
        } catch (Exception $exc) {
            $this->last_error = $exc->getMessage();
            echo $exc->getTraceAsString();
            echo $exc->getMessage(); 
        }

        return TRUE;
    }

}