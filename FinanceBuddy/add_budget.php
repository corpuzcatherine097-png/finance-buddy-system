<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) header("Location: index.php");
$uid = (int)$_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cat = $conn->real_escape_string($_POST['category']);
    $amt = (float)$_POST['amount'];
    $sd  = !empty($_POST['start_date']) ? $_POST['start_date'] : NULL;
    $ed  = !empty($_POST['end_date']) ? $_POST['end_date'] : NULL;

    $stmt = $conn->prepare("INSERT INTO budgets (user_id, category, amount, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdss", $uid, $cat, $amt, $sd, $ed);

    if ($stmt->execute()) {
        header("Location: view_budgets.php");
        exit;
    } else {
        $error = "Error creating budget.";
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Budget</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="header"><h1>FINANCE BUDDY</h1></div>
<div class="form-container">
  <h2>Add Budget</h2>
  <?php if (!empty($error)) echo "<p class='err'>$error</p>"; ?>
  <form method="post">
    <input name="category" placeholder="Category" required>
    <input name="amount" type="number" step="0.01" placeholder="Amount" required>
    <label>Start: <input name="start_date" type="date"></label>
    <label>End: <input name="end_date" type="date"></label>
    <button type="submit">Create Budget</button>
  </form>
  <p><a href="dashboard.php">⬅ Back</a></p>
</div>
</body>
</html>
