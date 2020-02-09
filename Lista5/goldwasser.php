<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Zakamarki Kryptografii - Goldwasser</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" type="text/css" />
  <meta http-equiv="refresh" content="300; url=logout.php" /><!-- LOGOUT TIME -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="script.js"></script>
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
      <li><a href="#goldwasser-micali">Schemat Goldwasser-Micali szyfrowania probabilistycznego</a></li>
      <li><a href="#reszta-kwadratowa">Reszta/niereszta kwadratowa</a></li>
      <li><a href="#symbol-legendrea">Symbol Legendre`a i Jacobiego</a></li>
    </ul>
  </nav>

  <!-- Use any element to open the sidenav -->
  <main>
    <article id="container">
      <nav id="myTopnav" class="topnav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a class="active" href="goldwasser.php">Goldwasser</a></li>
          <li><a href="shamir.php">Shamir</a></li>
        </ul>
      </nav>

      <section id="goldwasser-micali">
        <header>
          <h2>Goldwasser-Micali szyfrowania probabilistycznego</h2>
        </header>
        <h4>Algorytm generowania kluczy</h4>

        <ol type="a">
          <li>
            Wybierz losowo dwie duże liczby pierwsze $p$ oraz $q$ (podobnego
            rozmiaru),
          </li>
          <li>Policz $n = pq$</li>
          <li>
            Wybierz $y \in \mathbb{Z}_n$, takie, że $y$ jest nieresztą
            kwadratową modulo $n$ i symbol Jacobiego $\left( \frac{y}{n} = 1
            \right)$ (czyli $y$ jest pseudokwadratem modulo $n$),
          </li>
          <li>
            Klucz publiczny stanowi para $(n, y)$, zaś odpowiadający mu klucz
            prywatny to para $(p, q)$.
          </li>
        </ol>

        <h4>Algorytm szyfrowania</h4>
        Chcąc zaszyfrować wiadomość $m$ przy użycviu klucz publicznego $(n,y)$
        wykonaj kroki:

        <ol type="a">
          <li>
            Przedstaw $m$ w postaci łańcucha binarnego $m = m_1m_2\dots m_t$
            długości $t$
          </li>
          <li>
            <pre>
For $i$ from $1$ to $t$ do 
      wybierz losowe $x \in \mathbb{Z}^*_n$
      If $m_i = 1$ then set $c_i \gets yx^2 \text{ mod } n$
      Otherwise set $c_i \gets x^2\text{ mod } n$</pre>
          </li>
          <li>
            Kryptogram wiadomości $m$ stanowi $c = (c_1,c_2,\dots,c_t)$
          </li>
        </ol>
        <h4>Algorytm deszyfrowania</h4>
        <p>
          Chcąc odzyskać wiadomości z kryptogramu $c$ przy uzyciu klucza
          prywatnego $(p, q)$ wykonaj kroki:
        </p>
        <ol type="a">
          <li>
            <pre>
For $i$ from $1$ to $t$ do
    policz symbol Legendre'a $c_i = \left( \frac{c_i}{p} \right)$
    If $c_i = 1$ then set $m_i \leftarrow 0$
    Otherwise set $m_i \leftarrow 1$</pre>
          </li>
          <li>Zdeszyfrowana wiadomość to $m = m_1m_2...m_t$</li>
        </ol>
      </section>
      <section id="reszta-kwadratowa">
        <header>
          <h2>Reszta/niereszta kwadratowa</h2>
        </header>
        <b>Definicja.</b> Niech $a \in \mathbb{Z}_n$. Mówimy, że $a$ jest
        <i>resztą kwadratową modulo n (kwadratem modulo n)</i>, jeżeli
        istnieje $x\in \mathbb{Z}^*_n$ takie, że $x^2 \equiv a(\mod p)$.
        Jeżeli takie $x$ nie istnieje, to wówczas $a$ nazywamy
        <i>nieresztą kwadratową modulo</i> $n$. Zbiór wszystkich reszt
        kwadratowych modulo $n$ oznaczamy $Q_n$, zaś zbiór wszystkich niereszt
        kwadratowych modulo $n$ oznaczamy $\bar{Q}_n$.
      </section>
      <section id="symbol-legendrea">
        <header>
          <h2>Symbol Legendre`a i Jacobiego</h2>
        </header>
        <p>
          <b>Definicja.</b> Niech $p$ bedzie nieparzystą liczbą pierwszą a $a$
          liczbą całkowitą. <i>Symbol Legendre’a</i> $\left( \frac{a}{p}
          \right)$ jest zdefiniowany jako: $$\left( \frac{a}{p} \right )=
          \left\{ \begin{array}{lll} & 0 & \textrm{jeżeli $p | a$}\\ & 1 &
          \textrm{jeżeli $a \in Q_p$}\\ & -1 & \textrm{jeżeli $a \in
          \bar{Q}_p$}\\ \end{array} \right. $$
          <b>Własności symbolu Legendre'a.</b> Niech $a, b \in \mathbb{Z}$,
          zaś $p$ to nieparzysta liczba pierwsza. Wówczas:
        </p>
        <ul>
          <li>
            $\left( \frac{a}{p} \right) \equiv a^{\frac{(p-1)}{2}} (\mod p)$
          </li>
          <li>
            $\left( \frac{ab}{p} \right) = \left( \frac{a}{p} \right) \left(
            \frac{b}{p} \right)$
          </li>
          <li>
            $a \equiv b (\mod p) \Rightarrow \left( \frac{a}{p} \right) =
            \left( \frac{b}{p} \right)$
          </li>
          <li>$\left( \frac{2}{p} \right) = (-1)^{\frac{(p^2 - 1)}{8}}$</li>
          <li>
            Jeżeli $q$ jest nieparzystą liczbą pierwszą inną od $p$ to:
            $$\left( \frac{p}{q} \right) = \left( \frac{q}{p} \right)
            (-1)^{\frac{(p - 1)(q - 1)}{4}}$$
          </li>
        </ul>
        <b>Definicja.</b> Niec $n \geq 3$ będzie liczbą nieparzystą, a jej
        rozkład na czynniki pierwsze to $n = p^{e_1}_1 p^{e_2}_2 \ldots
        p^{e_k}_k$. <i>Symbol Jacobiego</i> $\left( \frac{a}{n} \right)$ jest
        zdefiniowany jako: $$\left( \frac{a}{n} \right) = \left( \frac{a}{p_1}
        \right)^{e_1} \left( \frac{a}{p_2} \right)^{e_2} \ldots \left(
        \frac{a}{p_k} \right)^{e_k}. $$ Jeżeli $n$ jest liczbą pierwszą, to
        symbol Jacobiego jest symbolem Legendre'a.

        <p>
          <b>Własności symbolu Jacobiego.</b> Niech $a, b \in \mathbb{Z}$, zaś
          $m, n \geq 3$ to nieparzyste liczby całkowite. Wówczas:
        </p>

        <ul>
          <li>
            $\left( \frac{a}{n} \right) = 0, 1$, albo -1. Ponadto $\left(
            \frac{a}{n} \right) = 0 \iff gcd(a, n) \neq 1$
          </li>
          <li>
            $\left( \frac{ab}{n} \right) = \left( \frac{a}{n} \right) \left(
            \frac{b}{n} \right)$
          </li>
          <li>
            $\left( \frac{a}{mn} \right) = \left( \frac{a}{m} \right) \left(
            \frac{a}{n} \right)$
          </li>
          <li>
            $a \equiv b (\mod n) \Rightarrow \left( \frac{a}{n} \right) =
            \left( \frac{b}{n} \right)$
          </li>
          <li>$\left( \frac{1}{n} \right) = 1$</li>
          <li>$\left( \frac{-1}{n} \right) = (-1)^{\frac{(n - 1)}{2}}$</li>
          <li>$\left( \frac{2}{n} \right) = (-1)^{\frac{(n^2 - 1)}{8}}$</li>
          <li>
            $\left( \frac{m}{n} \right) = \left( \frac{n}{m} \right)
            (-1)^{\frac{(m - 1)(n - 1)}{4}}$
          </li>
        </ul>

        Z własności symbolu Jacobiego wynika, że jeżeli $n$ nieparzyste oraz
        $a$ nieparzyste i w postaci $a = 2^e a_1$, gdzie $a_1$ też nieparzyste
        to: $$\left( \frac{a}{n} \right) = \left( \frac{2^e}{n} \right) \left(
        \frac{a_1}{n} \right) = \left( \frac{2}{n} \right)^e \left( \frac{n
        \mod a_1}{a_1} \right) (-1)^{\frac{(a_1 - 1)(n - 1)}{4}}$$
        <p>
          <b>Algorytm obliczania symbolu Jacobiego $\left( \frac{a}{n}
            \right)$ (i Legendre'a)</b>
          dla nieparzystej liczby całkowitej $n \geq 3$ oraz całkowitego $0
          \leq a \le n$
        </p>
        <pre>JACOBI($a, n$)</pre>
        <ol class="pseudo" type="a">
          <li>
            <pre>If $a = 0$ then return $0$</pre>
          </li>
          <li>
            <pre>If $a = 1$ then return $1$</pre>
          </li>
          <li>
            <pre>Write $a = 2^ea_1$, gdzie $a_1$ nieparzyste</pre>
          </li>
          <li>
            <pre>
If $e$ parzyste set $set \leftarrow 1$
Otherwise set $s \leftarrow 1$ if $n \equiv 1 $ or $7 ($mod$8)$, or set
$s \leftarrow -1$ if $n \equiv 3$ or $5 ($mod$8)$</pre>
          </li>
          <li>
            <pre>
If $n \equiv 3 ($mod$4)$ and $a_1 \equiv 3($mod$3)$ then set $s \leftarrow -s$</pre>
          </li>
          <li>
            <pre>Set $n_1 \leftarrow n$mod$a_1$</pre>
          </li>
          <li>
            <pre>
If $a_1 = 1$ then return $s$
Otherwise reurn $s \cdot$JACOBI($n_1, a_1$)</pre>
          </li>
        </ol>
        Algorytm działa w czasie $\mathcal{O}((\lg n)^2)$ operacji bitowych.
        <p>
          <b>Krótkie demo</b>
        </p>
        <div id="demo">
          <h2>$\left( \frac{n}{k} \right)$</h2>
          <div class="col">
            <label for="ninput">n</label>
            <input class="input" id="ninput" name="ninput" type="number" value="1" required />
          </div>
          <div class="col">
            <label for="kinput">k</label>
            <input class="input" id="kinput" name="kinput" type="number" value="1" required />
          </div>
          <span>$=$</span>
          <div id="result"></div>
        </div>
      </section>
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
          $result = $db->query("select * from comments where articleID=1 ");
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
            <input hidden=true name="article" value="1">
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