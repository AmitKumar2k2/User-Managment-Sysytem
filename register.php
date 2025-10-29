<?php
include('db_connect.php');
$message='';
$errors=[];
if(isset($_POST['submit'])){
    // basic server-side validation
    $name=trim($_POST['name']);
    $mobile=trim($_POST['mobile']);
    $email=trim($_POST['email']);
    $password=$_POST['password'];
    $state=trim($_POST['state']);
    $city=trim($_POST['city']);
    $description=trim($_POST['description']);

    if(strlen($mobile)!=10) $errors[]='Mobile must be 10 digits.';
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[]='Invalid email.';
    if(strlen($password) < 6) $errors[]='Password should be at least 6 characters.';

    // handle image upload
    $image_name = '';
    if(isset($_FILES['image']) && $_FILES['image']['name']){
        $img = $_FILES['image'];
        $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
        $image_name = time().rand(100,999).'.'.$ext;
        move_uploaded_file($img['tmp_name'], 'uploads/'.$image_name);
    }

    if(empty($errors)){
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('INSERT INTO users (name,mobile,email,password,state,city,description,image) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->bind_param('ssssssss',$name,$mobile,$email,$hash,$state,$city,$description,$image_name);
        if($stmt->execute()){
            $message='Registration successful. <a href="index.php">Login</a>';
        } else {
            $message='Error: '.$conn->error;
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Register - User System</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
<header><h1>Register New User</h1><a class="btn btn-outline" href="index.php">Login</a></header>
<?php if(!empty($errors)){ foreach($errors as $e){ echo '<div class="notice">'.htmlspecialchars($e).'</div>'; } } ?>
<?php if($message) echo '<div class="notice">'. $message .'</div>'; ?>
<form method="POST" enctype="multipart/form-data">
<div class="form-row">
<label style="flex:2">Name <input class="input" name="name" required></label>
<label>Mobile <input class="input" name="mobile" required></label>
</div>
<div class="form-row">
<label style="flex:2">Email <input class="input" name="email" type="email" required></label>
<label>Password <input class="input" name="password" type="password" required></label>
</div>
<div class="form-row">
<label>State <input class="input" name="state" required></label>
<label>City <input class="input" name="city" required></label>
</div>
<label>Description <textarea class="input" name="description" rows="4"></textarea></label>
<label>Profile Image <input type="file" name="image" accept="image/*"></label>
<div class="form-actions"><button class="btn btn-primary" type="submit" name="submit">Register</button></div>
</form>
</div>
</body>
</html>