<?php
require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <section>
        <form action="" class="d-flex searchform">
          <input type="text" name="s" value="<?= $web['search'] ?? "" ?>">
          <input type="submit" value="Szukaj">
        </form>
      </section>
      <section>
        <h2>Znalezione zestawy</h2>
        <section class="recent">
          <?php
            if(isset($web['sets']) && !empty($web['sets'])){
              foreach($web["sets"] as $set){
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
          <?php } ?>

        </section>

        <?php
        } else {
        ?>

        </section>
        <p>Niestety nie udało nam się nic znaleźć.</p>

        <?php } ?>
      </section>
    </article>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>