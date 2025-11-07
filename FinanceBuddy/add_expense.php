<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: index.php");
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $amount = $_POST['amount'];
  $desc = $_POST['description'];
  $uid = $_SESSION['user_id'];

  $stmt = $conn->prepare("INSERT INTO expenses (user_id, amount, description, date) VALUES (?, ?, ?, NOW())");
  $stmt->bind_param("ids", $uid, $amount, $desc);
  $stmt->execute();
  $stmt->close();

  header("Location: view_expenses.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Expense | Finance Buddy</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="header">
  <h1><span class="purple">FINANCE</span> <span class="green">BUDDY</span></h1>
</div>

<div class="container">
  <h2>Add Expense</h2>
  <form method="post">
    <input type="number" name="amount" placeholder="Amount (₱)" required>
    <textarea name="description" placeholder="Description" rows="3" required></textarea>
    <button type="submit">Save Expense</button>
  </form>
  <p><a href="dashboard.php" class="btn">⬅ Back to Dashboard</a></p>
</div>

</body>
</html>
