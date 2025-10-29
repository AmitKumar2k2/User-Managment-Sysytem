<?php
include('db_connect.php');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$id){ header('Location: dashboard.php'); exit; }
$stmt = $conn->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
$stmt->bind_param('i',$id); $stmt->execute(); $res = $stmt->get_result();
if($res->num_rows===0){ header('Location: dashboard.php'); exit; }
$user = $res->fetch_assoc();
$message='';
if(isset($_POST['submit'])){
    $name=trim($_POST['name']); $mobile=trim($_POST['mobile']); $state=trim($_POST['state']); $city=trim($_POST['city']); $description=trim($_POST['description']);
    // handle optional image
    $image_name = $user['image'];
    if(isset($_FILES['image']) && $_FILES['image']['name']){
        $img = $_FILES['image']; $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
        $image_name = time().rand(100,999).'.'.$ext;
        move_uploaded_file($img['tmp_name'],'uploads/'.$image_name);
    }
    $u_stmt = $conn->prepare('UPDATE users SET name=?, mobile=?, state=?, city=?, description=?, image=? WHERE id=?');
    $u_stmt->bind_param('ssssssi',$name,$mobile,$state,$city,$description,$image_name,$id);
    if($u_stmt->execute()) { $message='Update successful.'; header('Location: dashboard.php?msg='.urlencode('User updated')); exit; } else { $message='Error updating'; }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit User</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
<header><h1>Edit User</h1><a class="btn btn-outline" href="dashboard.php">Back</a></header>
<?php if($message) echo '<div class="notice">'.htmlspecialchars($message).'</div>'; ?>
<form method="POST" enctype="multipart/form-data">
<div class="form-row">
<label style="flex:2">Name <input class="input" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required></label>
<label>Mobile <input class="input" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required></label>
</div>
<div class="form-row">
<label>State <input class="input" name="state" value="<?php echo htmlspecialchars($user['state']); ?>" required></label>
<label>City <input class="input" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required></label>
</div>
<label>Description <textarea class="input" name="description" rows="4"><?php echo htmlspecialchars($user['description']); ?></textarea></label>
<?php if($user['image']): ?><div><img class="avatar" src="uploads/<?php echo htmlspecialchars($user['image']); ?>"></div><?php endif; ?>
<label>Change Image <input type="file" name="image" accept="image/*"></label>
<div class="form-actions"><button class="btn btn-primary" type="submit" name="submit">Save</button></div>
</form>
</div>
</body>
</html>