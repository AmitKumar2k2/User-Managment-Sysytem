<?php
session_start();
include('db_connect.php');
$error='';
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare('SELECT id,name,password FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res->num_rows===1){
        $row = $res->fetch_assoc();
        if(password_verify($password, $row['password'])){
            $_SESSION['user_id']=$row['id'];
            $_SESSION['username']=$row['name'];
            header('Location: dashboard.php'); exit;
        } else { $error='Invalid credentials.'; }
    } else { $error='Invalid credentials.'; }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login - User System</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
<header><h1>User System — Login</h1><a class="btn btn-outline" href="register.php">Register</a></header>
<?php if($error): ?><div class="notice"><?php echo $error; ?></div><?php endif; ?>
<form method="POST" style="max-width:480px">
<label>Email <input class="input" type="email" name="email" required></label>
<label>Password <input class="input" type="password" name="password" required></label>
<div class="form-actions">
<button class="btn btn-primary" type="submit" name="submit">Login</button>
</div>
</form>
</div>
</body>
</html>