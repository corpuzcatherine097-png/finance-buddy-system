<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if (!$username || !$email || !$password) $error = "Please fill all fields.";
    else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
        $stmt->bind_param("sss",$username,$email,$hash);
        if ($stmt->execute()) header("Location: index.php?registered=1");
        else $error = "Username or email already exists.";
        $stmt->close();
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Register</title>
<link rel="stylesheet" href="css/style.css"></head><body>
<div class="header"><h1>FINANCE BUDDY</h1></div>
<div class="form-container">
  <h2>Register</h2>
  <?php if(!empty($error)) echo "<p class='err'>$error</p>"; ?>
  <form method="post">
    <input name="username" placeholder="Username" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
  <p><a href="index.php">Already have account? Login</a></p>
</div></body></html>
