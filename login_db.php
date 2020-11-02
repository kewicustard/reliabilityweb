<?php 

    require_once 'connection.php';

    session_start();

    if (isset($_POST['btn_login'])) {
        $eid = $_POST['eid']; // textbox name 
        $password = $_POST['txt_password']; // password
        // $role = "u"; // defaul role "u" as user

        if (empty($eid)) {
            $errorMsg[] = "กรุณากรอกรหัสพนักงาน";
        } else if (empty($password)) {
            $errorMsg[] = "กรุณากรอกรหัสผ่าน";
        // } else if (empty($role)) {
        //     $errorMsg[] = "Please select role";
        } else if ($eid AND $password) { //AND $role
            try {
                $select_stmt = $db->prepare("SELECT eid, password, role FROM masterlogin WHERE eid = :ueid"); // AND password = :upassword AND role = :urole
                $select_stmt->bindParam(":ueid", $eid);
                // $select_stmt->bindParam(":upassword", $password);
                // $select_stmt->bindParam(":urole", $role);
                $select_stmt->execute(); 

                while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $dbeid = $row['eid'];
                    $dbpassword = $row['password'];
                    $dbrole = $row['role'];
                }
                if ($eid != null AND $password != null) { //AND $role != null
                    if ($select_stmt->rowCount() > 0) {
                        if ($eid == $dbeid AND $password == $dbpassword) {  //AND $role == $dbrole
                            switch($dbrole) {
                                case 'a': // 'a' as admin
                                    $_SESSION['admin_login'] = $eid;
                                    $_SESSION['success'] = "Admin... Successfully Login...";
                                    $_SESSION['role'] = $dbrole;
                                    // header("location: admin/admin_home.php");
                                    echo "1"; // return "1" if successful login but not no return
                                break;
                                case 'u': // 'u' as user
                                    $_SESSION['user_login'] = $eid;
                                    $_SESSION['success'] = "User... Successfully Login...";
                                    $_SESSION['role'] = $dbrole;
                                    // header("location: index.php");
                                    echo "1"; // return "1" if successful login but not no return
                                break;
                                default:
                                    $_SESSION['error'] = "รหัสพนักงาน หรือรหัสผ่านผิด";
                                    // header("location: index.php");
                            }
                        } else {
                            $_SESSION['error'] = "รหัสผ่านไม่ถูกต้อง";
                            echo $_SESSION['error'];
                        }
                    } else {
                        $_SESSION['error'] = "รหัสพนักงานไม่ถูกต้อง";
                        echo $_SESSION['error'];
                        // header("location: login.php");
                    }
                }
            } catch(PDOException $e) {
                $e->getMessage();
            }
        }

        if (isset($errorMsg)) {
            $_SESSION['error'] = $errorMsg[0];
            // header("location: login.php");
        }
        
    }

?>