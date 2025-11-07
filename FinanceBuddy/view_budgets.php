<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) header("Location: index.php");
$uid = (int)$_SESSION['user_id'];

$result = $conn->query("SELECT * FROM budgets WHERE user_id = $uid ORDER BY id DESC");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>View Budgets</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="header"><h1>FINANCE BUDDY</h1></div>
<div class="content">
  <h2>Your Budgets</h2>
  <table border="1" cellpadding="8" cellspacing="0">
    <tr>
      <th>Category</th>
      <th>Amount</th>
      <th>Start</th>
      <th>End</th>
      <th>Action</th>
    </tr>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($b = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($b['category']) ?></td>
        <td>₱<?= number_format($b['amount'], 2) ?></td>
        <td><?= htmlspecialchars($b['start_date']) ?></td>
        <td><?= htmlspecialchars($b['end_date']) ?></td>
        <td>
          <a href="delete_budget.php?id=<?= $b['id'] ?>" class="delete" onclick="return confirm('Delete this budget?')">❌ Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5" class="empty">No budgets found.</td></tr>
    <?php endif; ?>
  </table>
  <p><a href="add_budget.php">➕ Add New Budget</a></p>
  <p><a href="dashboard.php">⬅ Back to Dashboard</a></p>
</div>
</body>
</html>
