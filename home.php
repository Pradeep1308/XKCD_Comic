<?php require_once "controllerUserData.php"; ?>

<?php 
$email = $_SESSION['email'];
if($email != false ){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        if($status == "verified"){
            if($code != 0){
                header('Location: reset-code.php');
            }
        }else{
            header('Location: user-otp.php');
        }
    }
}else{
    header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $fetch_info['name'] ?> | Home</title>
   
    <style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
    nav{
        padding-left: 100px!important;
        padding-right: 100px!important;
        background: #6665ee;
        font-family: 'Poppins', sans-serif;
    } 
    nav a.navbar-brand{
        color: #fff;
        font-size: 30px!important;
        font-weight: 500;
    }
   
    h1{
        position: absolute;
        top: 25%;
        left: 50%;
        width: 100%;
        text-align: center;
        transform: translate(-50%, -50%);
        font-size: 50px;
        font-weight: 600
    }
    h2{
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        text-align: center;
        transform: translate(-50%, -50%);
        font-size: 30px;
        font-weight: 600

    }
    </style>
</head>
<body>
    <nav  style="background-color:black; height:50px" class="navbar" >
   <center> <a style="color:white; font-size:20px" class="navbar" >XKCD Comic</a> </center>
    </nav>
    <h1>Welcome <?php echo $fetch_info['name'] ?></h1><br><br>
    <h2>You have Subscribed XKCD comics successfully</h2>
    

    
</body>
</html>