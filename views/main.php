<?php
  require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <section>
        <h2>Najnowsze zestawy</h2>
        <section class="recent">
          <?php
            foreach($web["allSets"] as $set){
          ?>
          <a class="flash-prev" href="<?= ROOT_URL ?>/nauka/<?= $set["id"] ?>">
            <div class="flash-img">
              <!-- <img src="?= ROOT_URL ?>/img/flashcard-?= $set["id"] ?>.jpg" alt="" /> -->
              <img src="<?= ROOT_URL ?>/img/flashcard.jpg" alt="" />
            </div>
            <div class="flash-description">
              <h3><?= $set["title"] ?></h3>
              <p>
                <span class="flash-count">Zestaw zawiera <?= $set["flashcard_count"] > 4 ? $set["flashcard_count"]." pojęć" : $set["flashcard_count"] == 1 ? $set["flashcard_count"]." pojęcie" : $set["flashcard_count"]." pojęcia"?></span>
              </p>
            </div>
          </a>
          <?php
            }
          ?>
        </section>
        <h2 class="load-more">
          <a href="/wszystkie-fiszki">Wyświetl więcej</a>
          <span class="icon"><i class="fas fa-angle-down"></i></span>
        </h2>
      </section>
      <?php
        if(!empty($web["historySets"])){
      ?>
      <section>
        <h2>Ostatnio uczone zestawy</h2>
        <section class="recent">
          <?php
            foreach($web["historySets"] as $set){
          ?>
          <a class="flash-prev" href="<?= ROOT_URL ?>/nauka/<?= $set["id"] ?>">
            <div class="flash-img">
              <!-- <img src="?= ROOT_URL ?>/img/flashcard-?= $set["id"] ?>.jpg" alt="" /> -->
              <img src="<?= ROOT_URL ?>/img/flashcard.jpg" alt="" />
            </div>
            <div class="flash-description">
              <h3><?= $set["title"] ?></h3>
              <p>
                <span class="flash-count">Zestaw zawiera <?= $set["flashcard_count"] > 4 ? $set["flashcard_count"]." pojęć" : $set["flashcard_count"] == 1 ? $set["flashcard_count"]." pojęcie" : $set["flashcard_count"]." pojęcia"?></span>
              </p>
            </div>
          </a>
          <?php
            }
          ?>
        </section>
      </section>
      <?php
        }
        if(!empty($web["favouriteSets"])){
      ?>
      <section>
        <h2>Ulubione zestawy</h2>
        <section class="recent">
          <?php
            foreach($web["favouriteSets"] as $set){
          ?>
          <a class="flash-prev" href="<?= ROOT_URL ?>/nauka/<?= $set["id"] ?>">
            <div class="flash-img">
              <!-- <img src="?= ROOT_URL ?>/img/flashcard-?= $set["id"] ?>.jpg" alt="" /> -->
              <img src="<?= ROOT_URL ?>/img/flashcard.jpg" alt="" />
            </div>
            <div class="flash-description">
              <h3><?= $set["title"] ?></h3>
              <p>
                <span class="flash-count">Zestaw zawiera <?= $set["flashcard_count"] > 4 ? $set["flashcard_count"]." pojęć" : $set["flashcard_count"] == 1 ? $set["flashcard_count"]." pojęcie" : $set["flashcard_count"]." pojęcia"?></span>
              </p>
            </div>
          </a>
          <?php
            }
          ?>
        </section>
      </section>
      <?php
        }
      ?>
      <section>
        <h2>Kategorie</h2>
        <section id="categories">
        <?php
          foreach($web["categories"] as $cat) {
        ?>
          <a href="/kategoria/<?= $cat["name"] ?>" class="category-prev">
            <h3><?= $cat["name"] ?></h3>
          </a>
        <?php  }
        ?>
        </section>
      </section>
      <section>
        <h2>Ranking ostatniego tygodnia</h2>
        <section id="ranking">
          <div class="user-prev">
            <span class="left">#1</span>
            <span class="right">
              <strong>Nick użytkownika</strong>
              <span>200 punków</span>
            </span>
          </div>
          <div class="user-prev">
            <span class="left">#2</span>
            <span class="right">
              <strong>Nick użytkownika</strong>
              <span>200 punków</span>
            </span>
          </div>
          <div class="user-prev">
            <span class="left">#3</span>
            <span class="right">
              <strong>Nick użytkownika</strong>
              <span>200 punków</span>
            </span>
          </div>
          <div class="user-prev">
            <span class="left">#4</span>
            <span class="right">
              <strong>Nick użytkownika</strong>
              <span>200 punków</span>
            </span>
          </div>
          <div class="user-prev">
            <span class="left">#5</span>
            <span class="right">
              <strong>Nick użytkownika</strong>
              <span>200 punków</span>
            </span>
          </div>
        </section>
      </section>
    </article>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>