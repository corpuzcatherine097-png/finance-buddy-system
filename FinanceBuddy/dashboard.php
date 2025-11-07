<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: index.php");
include 'db.php';
$uid = (int)$_SESSION['user_id'];

$inc = $conn->query("SELECT IFNULL(SUM(amount),0) as t FROM expenses WHERE user_id=$uid AND amount>0")->fetch_assoc()['t'];
$bal = number_format($inc,2);
$streak = $conn->query("SELECT count FROM streaks WHERE user_id=$uid")->fetch_assoc()['count'] ?? 0;
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Finance Buddy Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<div class="header">
  <h1 class="logo-text"><span class="purple">FINANCE</span> <span class="green">BUDDY</span></h1>
  <p class="tagline">Master your finances today</p>
</div>

<div class="dashboard">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
  <p>Balance: ₱<?php echo $bal; ?></p>
  <p>Login Streak: 🔥 <?php echo (int)$streak; ?> days</p>

  <div class="card-container">
    <div class="card">
      <h3>➕ Add Expense</h3>
      <p>Record your daily expenses.</p>
      <a href="add_expense.php" class="card-btn">Open</a>
    </div>

    <div class="card">
      <h3>➕ Add Budget</h3>
      <p>Set your spending limits per category.</p>
      <a href="add_budget.php" class="card-btn">Open</a>
    </div>

    <div class="card">
      <h3>🎯 Add Goal</h3>
      <p>Create and track your savings goals.</p>
      <a href="add_goal.php" class="card-btn">Open</a>
    </div>

    <div class="card">
      <h3>📊 View Budgets</h3>
      <p>Check your budget progress.</p>
      <a href="view_budgets.php" class="card-btn">Open</a>
    </div>

    <div class="card">
      <h3>🏆 View Goals</h3>
      <p>Monitor your savings goals.</p>
      <a href="view_goals.php" class="card-btn">Open</a>
    </div>

    <div class="card logout-card">
      <h3>🚪 Logout</h3>
      <p>End your current session.</p>
      <a href="logout.php" class="card-btn logout-btn">Logout</a>
    </div>
  </div>
</div>
</body>
</html>
