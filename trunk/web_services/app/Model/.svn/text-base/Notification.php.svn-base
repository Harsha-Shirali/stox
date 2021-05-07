<?php

App::uses('AppModel', 'Model');

/**
 * Notification Model
 *
 */
class Notification extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'message' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'between' => array(
                'rule'    => array('between', 1, 150),
                'message' => 'Between 1 to 150 characters'
            )
        )
    );
    
    
    function getAllNotifications($data = array()) {
        $limit = trim($data['no_of_records']);
        $page = trim($data['page_no']);
        
        $conditions = array();
        $recursive = -1;
        $type = "all";
        $order = array('Notification.created' => 'DESC');
        
//        if($data["user_created_date"]!=0){
//            $conditions['Notification.created >'] = $data["user_created_date"];
//        }
        
        if($data["last_loaded_id"]!=0){
            $conditions['Notification.id <'] = $data["last_loaded_id"];
        }
        
        $options = $this->find($type, array('conditions' => $conditions, 'recursive' => $recursive, 'order' => $order, 'limit' => $limit));
        
        $body = array();

        if (!empty($options)) {
            $i = 0;
            foreach ($options as $value) {
                $body["Notification"][$i]["notification_id"] = $value["Notification"]["id"];
                $body["Notification"][$i]["message"] = $value["Notification"]["message"];         
                $body["Notification"][$i]["created_date"] = $value["Notification"]["created"];
                $i++;
            }
            $getTotRemValues = $this->totAndRemNoOfNoti($conditions, $recursive, $order, $page, $limit, $data["top_id"]);
            $body["total_number_of_notifications"] = $getTotRemValues["count"];
            $body["remaining_notifications_count"] = $getTotRemValues["remaining"];
            $body["should_load_more"] = $getTotRemValues["load_more"];
        }
        
        return $body;
    }
    
    function totAndRemNoOfNoti($conditions = array(), $recursive = -1, $order = array('Notification.created DESC'), $page = 1, $limit = 15, $top_notification_id) {
        
        unset($conditions['Notification.id <']);
        
        if($top_notification_id!=0){
           $conditions['Notification.id <='] = $top_notification_id;
        }
        
        $count = $this->find('count', array('conditions' => $conditions, 'recursive' => $recursive, 'order' => $order));

        $data = array();

        if ($count && $count != 0) {
            $data["count"] = $count;
            $remaining = $count - ($page * $limit);
            if ($remaining > 0) {
                $data["remaining"] = $remaining;
                $data["load_more"] = true;
            } else {
                $data["remaining"] = 0;
                $data["load_more"] = false;
            }
        }

        return $data;
    }
    
    
    function polling_count($data = array()) {
        
        $lastAccessTime = $data["last_notification_time"];
        $count = $this->find('count', array('conditions' => array('Notification.created >' => $lastAccessTime), 'recursive' => -1));
        return array('unread_notification_count' => $count);        
    }
    
    function getLastQuery() {
        $dbo = $this->getDatasource();
        $logs = $dbo->getLog();
        $lastLog = end($logs['log']);
        return $lastLog['query'];
    }
    
    
    function sendNotificationsToUsers($push_msg){
        $getValues = $this->query("SELECT DISTINCT(push_note_token) AS push_note_token FROM user_logs WHERE push_note_token IS NOT NULL;");

        foreach ($getValues as $values){
            if(!empty($values["user_logs"]["push_note_token"])){
               App::import('Component', 'ApiComponent');
               $apiComponent = new ApiComponent();
               $deviceToken = $values["user_logs"]["push_note_token"];
               if ($apiComponent->send_ios_notification($deviceToken, $push_msg)) {
                    //$this->log("APPLE PUSH NOTIFICATION SEND FROM API COMPONENT");
               }
            }
        }
    }

}
