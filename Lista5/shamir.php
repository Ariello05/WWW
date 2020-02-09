<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Zakamarki Kryptografii - Shamir</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" type="text/css" />
  <meta http-equiv="refresh" content="300; url=logout.php" /><!-- LOGOUT TIME -->

  <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
  <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
  <script>
    window.MathJax = {
      tex: {
        inlineMath: [
          ['$', '$']
        ],
      },
      options: {
        skipHtmlTags: ['script'],
      },
    };
  </script>
</head>

<body>
  <nav id="mySidenav" class="sidenav">
    <h3>Jump to:</h3>
    <ul>
      <li><a href="#schemat-shamira">Schemat progowy $(t,n)$ dzielenia sekretu Shamira</a></li>
      <li><a href="#lagrange">Interpolacja Lagrange'a</a></li>
    </ul>
  </nav>

  <!-- Use any element to open the sidenav -->
  <main>
    <article id="container">
      <nav id="myTopnav" class="topnav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="goldwasser.php">Goldwasser</a></li>
          <li><a class="active" href="shamir.php">Shamir</a></li>
        </ul>
      </nav>

      <section id="schemat-shamira">
        <header>
          <h2>Schemat progowy $(t,n)$ dzielenia sekretu Shamira</h2>
        </header>
        <p>
          <b>Cel:</b> Zaufana Trzecia Strona $T$ ma sekret $S \geq 0$, który
          chce podzielić pomiędzy $n$ uczestników tak, aby dowolnych $t$
          spośród niech mogło sekret odtworzyć.
        </p>
        <p>
          <b>Faza inicjalizacji:</b>
        </p>
        <ul>
          <li>
            $T$ wybiera liczbę pierwszą $p \ge max(S, n)$ i definiuje $a_0 =
            S$,
          </li>
          <li>
            $T$ wybiera losowo i niezależnie $t - 1$ współczynników $a_1, ...,
            a_{t-1} \in \mathbb{Z}_p$,
          </li>
          <li>
            $T$ definiuje wielomian nad $\mathbb{Z}_p$: $$f(x) = a_0 +
            \sum^{t-1}_{j = 1} a_jx^j,$$
          </li>
          <li>
            Dla $1 \leq i \leq n$ Zaufana Trzecia Strona $T$ wybiera losowo
            $x_i \in \mathbb{Z}_p$, oblicza: $S_i = f(x_i) \mod p$ i
            bezpiecznie przekazuje parę $(x_i, S_i)$ uzytkownikowi $P_i$.
          </li>
        </ul>
        <p>
          <b>Faza łączenia udziałów w sekret:</b> Dowolna grupa $t$ lub więcej
          użytkowników łączy swoje udziały - $t$ róznych punktów $(x_i, S_i)$
          wielomianu $f$ i dzięki interpolacji Lagrange'a odzyskuje sekret $S
          = a_0 = f(0)$.
        </p>
      </section>

      <section id="lagrange">
        <header>
          <h2>Interpolacja Lagrange'a</h2>
        </header>
        <p>
          Mając dane $t$ różnych punktów $(x_i, y_i)$ nienanego wielomianu $f$
          stopnia mniejszego od $t$ możemy policzyć jego współczynniki
          korzystając ze wzoru: $$f(x) = \sum^t_{i = 1}\left( y_i \prod_{1
          \leqslant j \leqslant t,\, j\neq i} \frac{x - x_j}{x_i - x_j}
          \right) \mod p$$
          <b>Wskazówka:</b> w schemacie Shamira, aby odzyskać sekret <i>S</i>,
          użytkownicy nie muszą znać całego wielomianu $f$. Wsstawiając do
          wzoru na iterpolację Lagrange'a $x = 0$, dostajemy wersję
          uproszczoną, ale wystarczającą aby policzyć sekret $S = f(0)$:
          $$f(x) = \sum^t_{i = 1} \left(y_i \prod_{1 \leqslant j \leqslant
          t,\, j\neq i} \frac{x_j}{x_j - x_i} \right) \mod p$$
        </p>
      </section>
      <section id="comments">

        <h2 style="text-align:center">Komentarze</h2>

        <ul style="align-self:flex-start">

          <?php
          $db = new PDO("sqlite:./app.db");
          $result = $db->query("select * from comments where articleID=2 ");
          $tab = $result->fetchAll();
          if ($tab != null) {
            foreach ($tab as $row) {
              echo "<li class='comment'>";
              echo "<p>" . $row["content"] . "</p>";
              echo "<small> ~ " . $row['author'] . "</small>";
              echo "</li>";
            }
          }
          ?>

        </ul>

        <?php
        if (isset($_SESSION["username"])) { ?>
          <form class="commentForm" method="POST" action="comment.php" id="usrform">
            <input hidden=true name="article" value="2">
            <input style="width:90%;" type="text" name="content">
            <input type="submit" value="Wyślij">
          </form>
        <?php } ?>

      </section>
      <footer>© Copyright 2019 Paweł Dychus</footer>
    </article>

  </main>


</body>

</html>

<!--
<label for="ninput">n</label>
<input
    class="input"
    id="ninput"
    name="ninput"
    type="number"
    value="1"
    required
/>
<label for="kinput">k</label>
<input
    class="input"
    id="kinput"
    name="kinput"
    type="number"
    value="1"
    required
/>
<input
    class="submit"
    type="button"
    onclick="check()"
    value="Submit"
/>
-->