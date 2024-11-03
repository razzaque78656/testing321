    <?php

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin:*');

    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    require_once "./config.php";

    try {

        if(isset($_GET['user_id'])){
            $id = $_GET['user_id'];
        
            $sql = "Select * from pwds where user_id=?";
            $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$id]);
        
            if($result){
                $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($userData);
            }else {
                
            $output = array('msg'=>'Unable to Find your Account','status'=>false);
            echo json_encode($output);
        
            }
        
        }else {
            $output = array('msg'=>'Please Send Api','status'=>false);
            echo json_encode($output);
        }

    } catch (\Throwable $th) {

        $output = array('msg'=>'Unable to Find your Account','status'=>false);
        echo json_encode($output);
        
    }

    if(isset($_POST['loginData'])){
        $username = $_POST['username'];
        $website = $_POST['webName'];
        $password = $_POST['pass'];
        $userid = $_POST['userID'];

        $sql = "Insert into pwds (user_id,name,pwd,web_name) values (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$userid,$username,$password,$website]);
        if($result){
            $output = array('msg'=>'success','status'=>'true');
            echo json_encode($output);
        }else {
            $output = array('msg'=>'notsuccess','status'=>false);
            echo json_encode($output);
        }
    }