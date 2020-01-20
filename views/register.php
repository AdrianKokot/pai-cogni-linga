<nav id="page-nav">
  <h1 class="cogni"><a href="<?= ROOT_URL ?>/">Cogni linga</a></h1>
  <div id="account-panel">
    <i class="fas fa-angle-down"></i>
    <div id="account-panel-menu">
      <a href="<?= ROOT_URL ?>/logowanie">Zaloguj się</a>
      <a href="<?= ROOT_URL ?>/rejestracja">Utwórz konto</a>
    </div>
  </div>
</nav>
<section>
  <section id="login-form">
    <form method="POST">
      <p class="mb-25 wrong"><?= Session::flash() ?></p>
      <label>
        Nazwa użytkownika:
        <input type="text" name="username" required />
      </label>
      <label>
        Kod rejestracyjny:
        <input type="text" name="register-code" />
      </label>
      <label>
        Hasło:
        <input type="password" name="password" required />
      </label>
      <label>
        Powtórz hasło:
        <input type="password" name="password-confirm" required />
      </label>
      <input type="submit" name="btnSubmit" value="Zarejestruj się" />
      <p class="mt-15">Masz już konto? <a href="<?= ROOT_URL ?>/logowanie">Zaloguj się!</a></p>
    </form>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>