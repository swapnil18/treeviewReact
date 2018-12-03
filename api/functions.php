<?php

require_once("Database.php");
ini_set('max_execution_time', 300);
ini_set( 'date.timezone', 'Asia/kolkata' );

class functions {

    function functions() {
        $this->db = new Database();
    }

    function pre($arr) {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    function response($res) {
        
        $file_handle = fopen(date('Y-m-d')."log.txt", "a");
        $file_contents = date('Y-m-d H:i:s').'Response:'.basename ( $_SERVER['PHP_SELF'])."\n#########################################\n".json_encode($res)."\n#########################################\n\n";        
        fwrite($file_handle, $file_contents);
        fclose($file_handle);        
        
        return json_encode($res);
    }    
    
    function getTreeData($id)
    {
        //error_reporting(E_ALL);
        //ini_set('display_errors', 1);
        $sql = "SELECT * from treeitems where parent_id = $id";
        
        $arr = $this->db->FetchRecords($sql);

        if (!empty($arr)) {
            $result = [];
            $i = 0;
            foreach ($arr as $value) {
                $result[$i]['id'] = $value['id'];
                $result[$i]['name'] = $value['name'];
                $result[$i]['children'] = $this->getTreeData($value['id']);  
                $i++;              
            }
            return $result;
        } else {
            return false;
        }
    }

    function addTreeNode($data)
    {
        if(empty($data)) {
            return;
        }
        $name = $data['name'];
        $parent_id = $data['parent_id'];

        $insert = "INSERT INTO treeitems(name,parent_id) values('$name',$parent_id)";
        return $this->db->executeQuery($insert);
    }


    function removeTreeNode($parent_id)
    {
        if(empty($parent_id)) {
            return;
        }
        $qlist=$this->db->FetchRecords("SELECT * FROM treeitems WHERE parent_id='$parent_id'");
        if (count($qlist)>0) {
            foreach ($qlist  as $value) {
                $this->removeTreeNode($value['id']);    
            }
            
        }
        $delete = "DELETE FROM treeitems WHERE id = $parent_id";
        $this->db->executeQuery($delete);
    }
}

$cmfunct = new functions();
?>
