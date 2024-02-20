<?php
    class ChatModel{
        private $db;

        public function __construct(){
            $this->db = new Database();
        }

        

        public function getChat(){
            if(isset($_SESSION['user_id'])){
                
                $outgoing_id = 26;
                $incoming_id = 2; 
                $output = "";
                // Fetch chat message for each user
                $sql = "SELECT * FROM messages WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                            OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id ";
                $this->db->query($sql);
                $this->db->bind(':incoming_id', $incoming_id);
                $this->db->bind(':outgoing_id', $outgoing_id);
                $query = $this->db->resultSet();
                foreach($query->result() as $row){
                if(mysqli_num_rows($query)>0){
                    while($row = mysqli_fetch_assoc($query)){
                        if($row['outgoing_msg_id'] === $outgoing_id){ //if this equal to then he is a msg sender
                            $output .= '<div class="outgoing">
                                <div class="details">
                                <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                    
                        }
                        else{ //he is a msg reciver
                                    $output .= '<div class="incoming">
                                            <div class="details">
                                            <p>'. $row['msg'] .'</p>
                                            </div>
                                            </div>';
                    
                            }

                    }
                }
                echo $output;
            }
        }
        
    }
        public function insertChat(){
            if(isset($_SESSION['user_id'])){
                // include_once "config.php";
                $outgoing_id = 26;
                $incoming_id = 2; 
                $message = " Hello ++++";
                     
    
                if(!empty($message)){
                    // $sql = mysqli_query($conn , "INSERT INTO chat (incoming_msg_id,outgoing_msg_id,msg)
                    //                     VALUES ({$incoming_id},{$outgoing_id},'{$message}')") or die();

                    $sql = "INSERT INTO chat (incoming_msg_id,outgoing_msg_id,msg)
                    VALUES ({$incoming_id},{$outgoing_id},'{$message}')" or die();

                    $this->db->query($sql);
                }
            }
            //else{
            //     header("../login.php");
            // }
    

        }

    

}








