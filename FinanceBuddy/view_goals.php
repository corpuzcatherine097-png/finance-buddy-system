<?php include 'db.php'; session_start();
if (!isset($_SESSION['user_id'])) header("Location:index.php");
$uid=(int)$_SESSION['user_id'];
$res=$conn->query("SELECT * FROM goals WHERE user_id=$uid ORDER BY created_at DESC");
?>
<!doctype html><html><head><meta charset="utf-8"><title>Goals</title>
<link rel="stylesheet" href="css/style.css"></head><body>
<div class="header"><h1>FINANCE BUDDY</h1></div>
<div class="form-container" style="max-width:800px">
<h2>Your Goals</h2>
<table><tr><th>Title</th><th>Target</th><th>Current</th><th>Due</th></tr>
<?php while($g=$res->fetch_assoc()): ?>
<tr><td><?php echo htmlspecialchars($g['title']);?></td>
<td><?php echo number_format($g['target_amount'],2);?></td>
<td><?php echo number_format($g['current_amount'],2);?></td>
<td><?php echo $g['due_date'];?></td></tr>
<?php endwhile;?>
</table>
<p><a href="dashboard.php">Back</a></p>
</div></body></html>
<a href="delete_goal.php?id=<?= $g['id'] ?>" onclick="return confirm('Delete this goal?')" class="delete">❌ Delete</a>
