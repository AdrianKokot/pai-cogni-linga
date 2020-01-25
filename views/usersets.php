<?php
require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <?php
        if(!empty($web["mySets"])){
      ?>
      <section>
        <h2>Utworzone zestawy</h2>
        <section class="recent">
          <?php
            foreach($web["mySets"] as $set){
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
    </article>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>