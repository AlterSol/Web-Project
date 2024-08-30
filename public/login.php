<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f5f5f5;
    }

    main {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 300px;
      text-align: center;
    }

    form div {
      margin-bottom: 15px;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"] {
      width: calc(100% - 20px);
      padding: 8px 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #7e57c2;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #6c49a1;
    }

    .register-section {
      margin-top: 10px;
      font-size: 14px;
      color: #666;
    }

    .register-section a {
      text-decoration: none;
      color: #7e57c2;
      font-weight: bold;
    }

    .register-section a:hover {
      text-decoration: underline;
    }

    .error_text {
      color: red;
      font-weight: bold;
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>

<body>
  <main>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <h1>Login</h1>
      <?php
      if (!empty($error_text)) {
        echo "<p class='error_text'>$error_text</p>";
      }
      ?>
      <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter username">
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter password">
      </div>
      <section>
        <button type="submit" name="submit" id="submit">Login</button>
        <div class="register-section">
          Don't have an account? <a href="register.php">Register</a> now
        </div>
      </section>
    </form>
  </main>
</body>

</html>

<?php
ob_end_flush(); // Flush the output buffer
?>
