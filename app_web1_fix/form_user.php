<?php
// Start the session
session_start();
//$_SESSION['update_at'] = $userModel->selectUpdateat($user['id']);
//$version =   $_SESSION['update_at'];
require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL; //Add new user
$_id = NULL;

if (!empty($_GET['id'])) {
    $_id = $_GET['id'];
    
    $user = $userModel->findUserById($_id);
   //Update existing user
//     if($userModel->checkIs_locked($_id) == true){

// echo '<script type="text/javascript">

//             window.onload = function () { alert("Editing"); }

// </script>';

//         header('location: list_users.php');
//     }
//     else{
//         $userModel->lockUser($_id);
//     }
}


if (!empty($_POST['submit'])) {
    if (!empty($_id)) {
       
       if( $_SESSION['update_at']  ==  $user[0]['update_at']){
        $userModel->updateUser($_POST);
        session_unset();
        header('location: list_users.php');
    }
        else{?>
            <script>
            if (window.confirm("Dữ liệu không đồng nhất vui lòng kiểm tra và nhập lại")) {
                // Xử lý khi người dùng bấm "OK" (true)
                window.location = "list_users.php";
              }
            </script>
            <?php
        }
       //$userModel->unlockUser($_id);
    } else {
        $userModel->insertUser($_POST);
    }
    //header('location: list_users.php');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>
</head>
<body>
    <?php include 'views/header.php'?>
    <div class="container">

            <?php if ($user || !isset($_id)) { ?>
                <div class="alert alert-warning" role="alert">
                    User form
                </div>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $_id ?>">
                    <div class="form-group">
                        <label for="name">Name</label>
                       <?php $_SESSION['update_at'] = $user[0]['update_at']?>
                        <input class="form-control" name="name" placeholder="Name" value='<?php if (!empty($user[0]['name'])) echo $user[0]['name'] ?>'>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                <?php $timestamp = $user[0]['update_at']; ?>

                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                </form>
            <?php } else { ?>
                <div class="alert alert-success" role="alert">
                    User not found!
                </div>
            <?php } ?>
    </div>
</body>
</html>