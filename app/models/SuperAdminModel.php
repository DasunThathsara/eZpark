<?php
class SuperAdminModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    // ------------------------- Assigned Admins Functionalities -------------------------

    // Active/Inactive for admins
    public function adminAccessControl($admin_id): bool{
        // Prepare statement
        $this->db->query('UPDATE user SET status = CASE WHEN status = 5 THEN 1 WHEN status = 1 THEN 5 ELSE status END WHERE id = :id;');
        // die(print_r($admin_id));
        // Bind values
        $this->db->bind(':id', $admin_id);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }
}