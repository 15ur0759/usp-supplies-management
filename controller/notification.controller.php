
<?php


function getAllPendingNotifications($conn,$role,$dept){
     switch($role){
        case 2 : return returnPending(suppliesPendingNotification($conn));
        case 3 : return returnPending(chairPendingNotification($conn,$dept));
        case 8 : return returnPending(deptHeadPendingNotification($conn,$dept));
        case 4: return returnPending(deanPendingNotification($conn));
        case 5: return returnPending(cedPendingNotification($conn));
     }


}

function returnPending($query){

    $pending = $query->fetch_assoc();
    return $pending['pending'];
}

function suppliesPendingNotification($conn){

    return $conn->query("SELECT (SELECT COUNT(*) FROM request WHERE supplies_admin_status = 1) AS pending");
   
}


function chairPendingNotification($conn,$dept){

    return $conn->query("SELECT (SELECT COUNT(*) FROM request INNER JOIN user ON request.requested_by = user.id WHERE chair_status = 1 AND user.department = $dept ) AS pending");
}

function deanPendingNotification($conn){

    return $conn->query("SELECT (SELECT COUNT(*) FROM request WHERE dean_status = 1) AS pending");
}


function cedPendingNotification($conn){
    return  $conn->query("SELECT (SELECT COUNT(*) FROM request WHERE ced_status = 1) AS pending");
}


function deptHeadPendingNotification($conn,$dept){

    return $conn->query("SELECT (SELECT COUNT(*) FROM request INNER JOIN user ON request.requested_by = user.id WHERE deptHead_status = 1 AND user.department = $dept ) AS pending");
}


// function lastChairRequest($conn,$department){

//     return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id WHERE chair_status = 1 AND user.department = $department")->fetch_assoc();
// }

function lastChairRequest($conn,$department){

    $data =  $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id WHERE chair_status = 1 AND user.department = $department")->fetch_assoc();
     if(isset($data)){
    if(sizeof($data)){
       return get_time_ago(strtotime($data['request_date']));
    }else{
        return '0';
    }
}
}
function lastDeanRequest($conn){

    $data =  $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id WHERE dean_status = 1")->fetch_assoc();
     if(isset($data)){
    if(sizeof($data)){
       return get_time_ago(strtotime($data['chair_response_date']));
    }else{
        return '0';
    }
}
}

function lastCedRequest($conn){

    $data =  $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id WHERE ced_status = 1")->fetch_assoc();
     if(isset($data)){
    if(sizeof($data)){
       return get_time_ago(strtotime($data['dean_response_date']));
    }else{
        return '0';
    }
}
}

function lastSuppliesRequest($conn){

    $data =  $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id WHERE supplies_admin_status = 1")->fetch_assoc();
    if(isset($data)){
    if(sizeof($data)){
       return get_time_ago(strtotime($data['request_date']));
    }else{
        return '0';
    }
}
}
function lastHeadRequest($conn,$department){

    $data =  $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id WHERE deptHead_status = 1 AND user.department = $department")->fetch_assoc();
    if(isset($data)){
        if(sizeof($data)){
           return get_time_ago(strtotime($data['request_date']));
        }else{
            return '0';
        }
    }else{
         return '0';
    }
}

function get_time_ago( $time )
{
    $deduct = 12 * 3600;
    $current = time() - $deduct;
    $time_difference = $current - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}