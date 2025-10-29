<?php
session_start();
include('db_connect.php');
if(!isset($_SESSION['user_id'])){ header('Location: index.php'); exit; }
$msg='';
if(isset($_GET['msg'])) $msg = $_GET['msg'];
$result = $conn->query('SELECT * FROM users ORDER BY id DESC');
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Dashboard</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
<header><h1>Dashboard</h1><div><span class="small">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span> <a class="btn btn-outline" href="logout.php">Logout</a></div></header>
<div style="display:flex;gap:8px;align-items:center;justify-content:space-between">
<div><a class="btn btn-primary" href="register.php">Add User</a> <a class="btn btn-outline" href="generate_pdf.php" target="_blank">Download PDF</a></div>
</div>
<?php if($msg) echo '<div class="notice">'.htmlspecialchars($msg).'</div>'; ?>
<table class="table">
<thead><tr><th>ID</th><th>Avatar</th><th>Name</th><th>Mobile</th><th>Email</th><th>State</th><th>City</th><th>Description</th><th>Action</th></tr></thead>
<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php if($row['image']): ?><img class="avatar" src="uploads/<?php echo htmlspecialchars($row['image']); ?>"><?php endif; ?></td>
<td><?php echo htmlspecialchars($row['name']); ?></td>
<td><?php echo htmlspecialchars($row['mobile']); ?></td>
<td><?php echo htmlspecialchars($row['email']); ?></td>
<td><?php echo htmlspecialchars($row['state']); ?></td>
<td><?php echo htmlspecialchars($row['city']); ?></td>
<td class="small"><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
<td class="actions">
<a class="btn btn-outline" href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
<a class="btn btn-danger" href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this user?');">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</body>
</html>