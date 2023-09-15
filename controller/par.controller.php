<?php


function getAllAddedPar($conn,$owner){
    
    return $conn->query("SELECT * FROM `items` LEFT JOIN `par` ON par.par_item = items.item_id INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN suppliers ON suppliers.supplier_id = items.supplier INNER JOIN itemtype ON itemtype.id = items.item_type INNER JOIN measurement ON items.measurement = measurement.id WHERE par.par_owner = $owner AND par.par_id IS NOT NULL");
}

function getAllSentPar($conn,$owner){
    
    return $conn->query("SELECT * FROM `items` LEFT JOIN `par` ON par.par_item = items.item_id INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN suppliers ON suppliers.supplier_id = items.supplier INNER JOIN itemtype ON itemtype.id = items.item_type INNER JOIN measurement ON items.measurement = measurement.id WHERE par.par_owner = $owner AND par.par_id IS NOT NULL AND par.par_status != 1");
}

function getAllUnAddedPar($conn,$owner){
    
    return $conn->query("SELECT *FROM `items` INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN suppliers ON suppliers.supplier_id = items.supplier INNER JOIN itemtype ON itemtype.id = items.item_type INNER JOIN measurement ON items.measurement = measurement.id");
}

function addPar($conn,$owner,$item,$qty,$now,$jan,$feb,$mar,$apr,$may,$june,$jul,$aug,$sep,$oct,$nov,$dec){
    
      $query = $conn->prepare("INSERT INTO par (par_owner,par_item,jan,feb,mar,apr,may,june,july,aug,sep,oct,nov,decem,par_quantity,par_added_date,par_status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)");

     $query->bind_param('iiiiiiiiiiiiiiis',$owner,$item,$jan,$feb,$mar,$apr,$may,$june,$jul,$aug,$sep,$oct,$nov,$dec,$qty,$now);

     return $query->execute();
}

function editPar($conn,$parId,$qty){
    
      $query = $conn->prepare("UPDATE par SET par_quantity = ? WHERE par_id = ?");

     $query->bind_param('ii',$qty,$parId);

     return $query->execute();
}
function submitPar($conn,$owner,$now){
    
      $query = $conn->prepare("UPDATE par SET par_status = 2, par_date_sent = ? WHERE par_owner = ?");

     $query->bind_param('si',$now,$owner);

     return $query->execute();
}

function deletePar($conn,$id){
    
      $query = $conn->prepare("DELETE FROM par WHERE par_id = ?");

     $query->bind_param('i',$id);

     return $query->execute();
}

function exist($conn,$owner,$item){

     $result = $conn->query("SELECT * FROM par WHERE par_owner = $owner AND par_item = $item");

     return $result->num_rows;
}


//supplies admin's end

function getAllParRequests ($conn,$type){
    if($type == 0){
        return $conn->query("SELECT * FROM user INNER JOIN par ON par.par_owner = user.id INNER JOIN department ON user.department = department.department_id INNER JOIN `role` ON role.role_id = user.role WHERE par.par_status = 2 GROUP BY user.id");
    }else{
         return $conn->query("SELECT * FROM user INNER JOIN par ON par.par_owner = user.id INNER JOIN department ON user.department = department.department_id INNER JOIN `role` ON role.role_id = user.role WHERE par.par_status = $type GROUP BY user.id");
    }
}

function getAllParApprovedRequests ($conn){

        return $conn->query("SELECT * FROM user INNER JOIN par ON par.par_owner = user.id INNER JOIN department ON user.department = department.department_id INNER JOIN `role` ON role.role_id = user.role WHERE par.par_status = 3 GROUP BY user.id");
   
}

function getAllReleasedRequests ($conn){

        return $conn->query("SELECT * FROM user INNER JOIN par ON par.par_owner = user.id INNER JOIN department ON user.department = department.department_id INNER JOIN `role` ON role.role_id = user.role WHERE par.par_status = 5 GROUP BY user.id");
   
}

function getAllParDisApprovedRequests ($conn){
        return $conn->query("SELECT * FROM user INNER JOIN par ON par.par_owner = user.id INNER JOIN department ON user.department = department.department_id INNER JOIN `role` ON role.role_id = user.role WHERE par.par_status = 4 GROUP BY user.id");
   
}

function getAllParItems ($conn,$id){
  
        return $conn->query("SELECT * FROM par INNER JOIN items ON par.par_item = items.item_id INNER JOIN measurement ON measurement.id = items.measurement INNER JOIN user ON par.par_owner = user.id WHERE user.id = $id ");
}


function changeParStatus ($conn,$owner,$status,$now){
     if($status == 4){
          $query = $conn->prepare("UPDATE par SET par_status = 1, par_date_sent = NULL, supplies_response = ? WHERE par_owner = ? AND par_status = 2");
          $query->bind_param('si',$now,$owner);
     }else{
         $query = $conn->prepare("UPDATE par SET par_status = ?, supplies_response = ? WHERE par_owner = ? AND par_status = 2");
         $query->bind_param('isi',$status,$now,$owner);
     }



     return $query->execute();
}

//par report


function getSuppliesAdmin($conn){
    return $conn->query("SELECT * FROM user WHERE `role`= 2")->fetch_assoc();
}

function getRequester($conn,$id){
    return $conn->query("SELECT * FROM user INNER JOIN department ON user.department = department.department_id INNER JOIN `role` ON user.role = role.role_id WHERE user.id= $id")->fetch_assoc();
}

function getReleaseItem($conn,$id){
    
    return $conn->query("SELECT * FROM par INNER JOIN items ON par.par_item = items.item_id INNER JOIN user ON par.par_owner = user.id INNER JOIN measurement ON items.measurement = measurement.id WHERE par.par_owner = $id AND par.par_status = '3' OR par.par_status = '5'");

}