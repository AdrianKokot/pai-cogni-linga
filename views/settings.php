<?php
require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <article>
    <section id="usrsettings">
      <section id="login-form">
        <h2>Ustawienia użytkownika</h2>
        <details>
          <summary>Zmiana hasła</summary>
          <form action="">
            <label>
              Stare hasło:
              <input
                type="password"
                name="old-password"
                required
                title="Hasło jest wymagane"
              />
            </label>
            <label>
              Nowe hasło:
              <input
                type="password"
                name="password"
                required
                title="Nowe hasło jest wymagane"
              />
            </label>
            <label>
              Powtórz nowe hasło:
              <input
                type="password"
                name="password-repeat"
                required
                title="Potwierdzenie nowego hasła jest wymagane"
              />
            </label>
            <input type="submit" value="Zmień" />
          </form>
        </details>
        <details>
          <summary>Usuwanie konta</summary>
          <form action="">
            <input type="submit" class="wrong" value="Usuń" />
          </form>
        </details>
      </section>
    </section>
  </article>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>