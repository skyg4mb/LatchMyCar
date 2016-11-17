<?php

/* 
 * Esta clase proveera todos los metodos necesarios para el CRUD en base de datos
 * 
 * 
 */

class DbHandler{
    
    private $conn;
            
    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }
    
    
    /**
     * Generating random Unique MD5 String for user Api key
     */
    
    public function getData($serie){
        $stmt = $this->conn->prepare("select latchAccountId from vehicles a inner join users b on a.userid=b.userId where serial = ?");
        $stmt->bind_param("i", $serie);
        if ($stmt->execute()) {
            $user_id = $stmt->get_result();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }

    }
    
    
    
}


?>
