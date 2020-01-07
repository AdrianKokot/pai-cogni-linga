<nav id="page-nav">
  <h1 class="cogni"><a href="index.html">Cogni linga</a></h1>
  <div id="account-panel">
    <i class="fas fa-angle-down"></i>
    <div id="account-panel-menu">
      <a href="/logowanie">Zaloguj się</a>
      <a href="/rejestracja">Utwórz konto</a>
    </div>
  </div>
</nav>
<section>
  <section id="login-form">
    <form method="post">
      <p class="mb-25 wrong"><?= Session::flash() ?></p>
      <label>
        Login:
        <input type="text" name="username" required />
      </label>
      <label>
        Hasło:
        <input type="password" name="password" required />
      </label>
      <input type="submit" name="btnSubmit" value="Zaloguj się" />
      <p class="mt-15">Nie masz konta? <a href="/rejestracja">Zarejestruj się!</a></p>
    </form>
  </section>
</section>

<script src="js/navigation.js"></script>