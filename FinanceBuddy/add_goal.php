<?php include 'db.php'; session_start();
if (!isset($_SESSION['user_id'])) header("Location:index.php");
$uid=(int)$_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD']=='POST'){
  $t=$conn->real_escape_string($_POST['title']);
  $target=(float)$_POST['target'];
  $due=$_POST['due']?:NULL;
  $stmt=$conn->prepare("INSERT INTO goals (user_id,title,target_amount,due_date) VALUES (?,?,?,?)");
  $stmt->bind_param("isds",$uid,$t,$target,$due);
  if($stmt->execute()) header("Location:view_goals.php");
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Add Goal</title>
<link rel="stylesheet" href="css/style.css"></head><body>
<div class="header"><h1>FINANCE BUDDY</h1></div>
<div class="form-container">
<h2>Create Goal</h2>
<form method="post">
<input name="title" placeholder="Goal name" required>
<input name="target" type="number" step="0.01" placeholder="Target amount" required>
<input name="due" type="date">
<button type="submit">Create</button>
</form>
<p><a href="dashboard.php">Back</a></p>
</div></body></html>
