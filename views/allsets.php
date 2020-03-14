<?php
  require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <section>
        <h2><?= isset($web['header']) ? $web['header'] : "Wszystkie zestawy" ?></h2>
        <section class="recent">
          <?php
            foreach($web["allSets"] as $set){
          ?>
          <a class="flash-prev" href="<?= ROOT_URL ?>/nauka/<?= $set["id"] ?>">
            <div class="flash-img">
              <img src="<?= ROOT_URL ?>/img/<?= $set["category"] ?>.jpg" alt="" />
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
    </article>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>