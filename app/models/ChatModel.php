<?php
class ChatModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    // create chat
    public function createChat($person1, $person2){
        $this->db->query('INSERT INTO chats (person1, person2) VALUE(:person1, :person2)');
        $this->db->bind(':person1', $person1);
        $this->db->bind(':person2', $person2);

        if($this->db->execute())
            return true;
        else
            return false;
    }

    public function getName($userID){
        $this->db->query('SELECT name FROM user WHERE id = :id');
        $this->db->bind(':id', $userID);

        return $this->db->single()->name;
    }

    public function getChatList(){
        $this->db->query('SELECT * FROM chats WHERE person1 = :person1 OR person2 = :person2');
        $this->db->bind(':person1', $_SESSION['user_id']);
        $this->db->bind(':person2', $_SESSION['user_id']);

        $result = $this->db->resultSet();

        foreach($result as $item){
            if($item->person1 == $_SESSION['user_id']){
                $item->senderName = $this->getName($item->person2);
            }
            else{
                $item->senderName = $this->getName($item->person1);
            }
        }

        return $result;
    }

    public function getChatHistory($chatID){
        $this->db->query('SELECT * FROM chat WHERE chatID = :chatID ORDER BY time ASC');
        $this->db->bind(':chatID', $chatID);

        $result = $this->db->resultSet();

        return $result;
    }

    public function sendMessage($message, $chatID){
        $this->db->query("INSERT INTO chat VALUE(:chatID, :senderID, :message, :time)");
        $this->db->bind(":chatID", $chatID);
        $this->db->bind(":message", $message);
        $this->db->bind(":senderID", $_SESSION['user_id']);
        $this->db->bind(":time", date("Y-m-d H:i:s"));

        if($this->db->execute())
            return true;
        else 
            return false;
    }
}