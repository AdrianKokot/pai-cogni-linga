<nav id="page-nav">
  <div id="nav-panel">
    <i class="fas fa-bars"></i>
  </div>
  <h1 class="cogni"><a href="<?= ROOT_URL ?>/cogni">Cogni linga</a></h1>
  <div id="account-panel">
    <i class="fas fa-angle-down"></i>
    <div id="account-panel-menu">
      <a style="font-weight: bold">Witaj <?= $_SESSION['username'] ?>!</a>
      <a href="<?= ROOT_URL ?>/ustawienia">Ustawienia</a>
      <a href="<?= ROOT_URL ?>/wyloguj">Wyloguj się</a>
    </div>
  </div>
</nav>
<nav id="aside-nav">
  <ul>
    <li title="Panel główny">
      <a href="<?= ROOT_URL ?>/cogni">
        <div class="icon"><i class="fas fa-home"></i></div>
        <div class="name">Panel aplikacji</div>
      </a>
    </li>
    <li title="Nowe fiszki">
      <a href="<?= ROOT_URL ?>/dodaj">
        <div class="icon"><i class="fas fa-plus"></i></div>
        <div class="name">Dodaj</div>
      </a>
    </li>
    <li title="Szukaj" id="searchbtn">
      <a href="<?= ROOT_URL ?>/szukaj">
        <div class="icon"><i class="fas fa-search"></i></div>
        <div class="name">Szukaj</div>
      </a>
    </li>
    <li title="Moje fiszki">
      <a href="<?= ROOT_URL ?>/moje-fiszki">
        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="name">Moje fiszki</div>
      </a>
    </li>
    <li title="Wszystkie fiszki">
      <a href="<?= ROOT_URL ?>/wszystkie-fiszki">
        <div class="icon"><i class="fas fa-th-list"></i></div>
        <div class="name">Wszystkie fiszki</div>
      </a>
    </li>
    <?php
      if(Guard::isAdmin()) {

        ?>
    <li title="Menedżer użytkowników">
      <a href="<?= ROOT_URL ?>/uzytkownicy">
        <div class="icon"><i class="fas fa-users"></i></div>
        <div class="name">Menedżer użytkowników</div>
      </a>
    </li>
        <?php
      }
      if(Guard::isAdmin() || $_SESSION['role'] == 'teacher') {
        ?>
    <li title="Kategorie">
      <a href="<?= ROOT_URL ?>/kategorie">
        <div class="icon"><i class="fas fa-stream"></i></div>
        <div class="name">Menedżer kategorii</div>
      </a>
    </li>
        <?php
      }
    ?>
  </ul>
</nav>