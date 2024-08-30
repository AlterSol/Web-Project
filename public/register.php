<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
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
      width: 320px;
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
    input[type="email"],
    input[type="password"] {
      width: calc(100% - 20px);
      padding: 8px 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    input[type="checkbox"] {
      margin-right: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #7e57c2;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #6c49a1;
    }

    footer {
      margin-top: 10px;
      font-size: 14px;
      color: #666;
    }

    footer a {
      text-decoration: none;
      color: #7e57c2;
      font-weight: bold;
    }

    footer a:hover {
      text-decoration: underline;
    }

    .terms a {
      color: #7e57c2;
      text-decoration: none;
    }

    .terms a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <main>
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
      <h1>Sign Up</h1>
      <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
      </div>
      <div>
        <label for="password2">Password Again:</label>
        <input type="password" name="password2" id="password2">
      </div>
      <div class="terms">
        <label for="agree">
          <input type="checkbox" name="agree" id="agree" value="yes" /> I agree
          with the <a href="#" title="term of services">term of services</a>
        </label>
      </div>
      <button type="submit">Register</button>
      <footer>Already a member? <a href="login.php">Login here</a></footer>
    </form>
  </main>
</body>

</html>
