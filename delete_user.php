<?php
include('db_connect.php');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id){
    // delete file if exists
    $stmt = $conn->prepare('SELECT image FROM users WHERE id=? LIMIT 1');
    $stmt->bind_param('i',$id); $stmt->execute(); $r = $stmt->get_result();
    if($r->num_rows){
        $row = $r->fetch_assoc();
        if($row['image'] && file_exists('uploads/'.$row['image'])) unlink('uploads/'.$row['image']);
    }
    $d = $conn->prepare('DELETE FROM users WHERE id=?');
    $d->bind_param('i',$id); $d->execute();
}
header('Location: dashboard.php?msg='.urlencode('User deleted'));
exit;
?>