<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="refresh" content="300; url=logout.php" /><!-- LOGOUT TIME -->
  <link href="./style.css" rel="stylesheet" />
  <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
  <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
  <title>Zakamarki kryptografii</title>
</head>

<body>
  <article id="container">
    <header>
      <h1>Zakamarki kryptografii</h1>
    </header>
    <section class="center">
      <h2>
        Artykuły:
      </h2>
      <nav>
        <ul>
          <li>
            <a href="goldwasser.php">Algorytm szyfrowania probabilistycznego Goldwasser-Micali</a>
          </li>
          <li>
            <a href="shamir.php">Schemat progowy dzielenia sekretu Shamira</a>
          </li>
        </ul>
      </nav>
    </section>

    <?php
    if (isset($_SESSION["username"])) {
    ?>

      <section>
        <h2>Witaj <?php echo $_SESSION["username"]; ?></h2>
        <a href="logout.php">Logout</a>
      </section>

    <?php
    } else {
    ?>
      <section class="center">
        <h2>Zaloguj się</h2>
        <form action="login.php" method="post">
          <label for="username">Nazwa</label>
          <input type="text" name="username" id="username">
          <br>
          <label for="password">Hasło</label>
          <input type="password" name="password" id="password">
          <br>
          <input type="submit" value="Zaloguj się">
        </form>
      </section>
      <section class="center">
        <h2>Zarejestruj się</h2>
        <form action="register.php" method="post">
          <label for="username">Nazwa</label>
          <input type="text" name="username" id="username">
          <br>
          <label for="password">Hasło</label>
          <input type="password" name="password" id="password">
          <br>
          <input type="submit" value="Zarejestruj się">
        </form>
      </section>
    <?php
    }
    ?>
    <footer>
      <small>
        Korzystając z tej strony, wyrażasz zgodę na wykorzystanie plików cookies.
      </small>
      <div style="align-self:flex-end"><?php include('counter.php') ?></div>

    </footer>
  </article>
</body>

</html>