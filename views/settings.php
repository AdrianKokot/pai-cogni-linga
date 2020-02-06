<?php
require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <article>
    <section id="usrsettings">
      <section id="login-form">
        <h2>Ustawienia użytkownika</h2>
        <p class="mb-25 wrong"><?= Session::flash() ?></p>
        <details>
          <summary>Zmiana hasła</summary>
          <form action="" method="post">
            <input type="hidden" name="user" value="<?= $_SESSION['userId'] ?>">
            <label>
              Stare hasło:
              <input type="password" name="old_password" required title="Hasło jest wymagane"/>
            </label>
            <label>
              Nowe hasło:
              <input type="password" name="password" required title="Nowe hasło jest wymagane" />
            </label>
            <label>
              Powtórz nowe hasło:
              <input type="password" name="password_confirmation" required title="Potwierdzenie nowego hasła jest wymagane" />
            </label>
            <input type="submit" name="pwdchange" value="Zmień" />
          </form>
        </details>
        <details>
          <summary>Usuwanie konta</summary>
          <form action="" method="post">
            <input type="hidden" name="user" value="<?= $_SESSION['userId'] ?>">
            <label>
              Hasło:
              <input type="password" name="password" required title="Hasło jest wymagane" />
            </label>
            <input type="submit" name="acdel" class="wrong" value="Usuń" />
          </form>
        </details>
      </section>
    </section>
  </article>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>