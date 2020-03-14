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
              <img src="<?= ROOT_URL ?>/img/<?= $set["category"] ?>.jpg" alt="" />
            </div>
            <div class="flash-description">
              <h3><?= $set["title"] ?></h3>
              <p>
                <span class="flash-count">Zestaw zawiera <?= $set["flashcard_count"] > 4 ? $set["flashcard_count"]." pojęć" : ($set["flashcard_count"] == 1 ? $set["flashcard_count"]." pojęcie" : $set["flashcard_count"]." pojęcia") ?></span>
              </p>
            </div>
          </a>
          <?php
            }
          ?>
        </section>
        <h2 class="load-more">
          <a href="<?= ROOT_URL ?>/wszystkie-fiszki">Wyświetl więcej</a>
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
      <?php
        }
      ?>
      <section>
        <h2>Kategorie</h2>
        <section id="categories">
        <?php
          foreach($web["categories"] as $cat) {
        ?>
          <a href="<?= ROOT_URL ?>/kategoria/<?= $cat["name"] ?>" class="category-prev">
            <h3><?= $cat["name"] ?></h3>
          </a>
        <?php  }
        ?>
        </section>
      </section>
      <?php
      if(count($web["week_rank"]) >0){
        ?>
      
      <section>
        <h2>Ranking ostatniego tygodnia</h2>
        <section class="ranking">
          <?php
            foreach($web["week_rank"] as $key => $rank) {
              $msg = $rank["score_week"];
              switch($rank["score_week"]){
                case 1: $msg .= " punkt"; break;
                case 2:
                case 3:
                case 4: $msg .= " punkty"; break;
                default: $msg .= " punktów"; break;
              }
              ?>
          <div class="user-prev">
            <span class="left">#<?= $key +1 ?></span>
            <span class="right">
              <strong><?= $rank['login'] ?></strong>
              <span><?= $msg ?></span>
            </span>
          </div>
              <?php
            }
          ?>
        </section>
      </section>
      <?php 
        } 

      if(count($web["global_rank"]) >0){
        ?>
      
      <section>
        <h2>Ranking globalny</h2>
        <section class="ranking">
          <?php
            foreach($web["global_rank"] as $key => $rank) {
              $msg = $rank["score"];
              switch($rank["score"]){
                case 1: $msg .= " punkt"; break;
                case 2:
                case 3:
                case 4: $msg .= " punkty"; break;
                default: $msg .= " punktów"; break;
              }
              ?>
          <div class="user-prev">
            <span class="left">#<?= $key +1 ?></span>
            <span class="right">
              <strong><?= $rank['login'] ?></strong>
              <span><?= $msg ?></span>
            </span>
          </div>
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