<?php
  require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <section><a href=""><strong class="button-accent"><i class="fas fa-star"></i> Dodaj do ulubionych</strong></a><a href="1/edytuj"><strong class="button-accent"><i class="fas fa-pen"></i> Edytuj</strong></a></section>
      <section>
        <section class="columns2 margin-20">
          <div class="flash-img">
            <img src="<?= ROOT_URL ?>/img/flashcard.jpg" alt="" />
          </div>
          <div class="right-side">
            <h2 class="lowercase"><?= $web["studySet"]["title"] ?></h2>
            <p class="studysetdescription"><?= $web["studySet"]["description"] ?></p>
            <p class="studysetinfo">
              <span><?= $web["studySet"]["flashcard_count"] < 5 ? $web["studySet"]["flashcard_count"]." pojęcia" : $web["studySet"]["flashcard_count"]." pojęć" ?></span>
              <span>|</span>
              <span>kategoria: <?= $web["studySet"]["categoryName"] ?></span>
              <span>|</span>
              <span>język: <?= $web["studySet"]["term_lang"] ?> - <?= $web["studySet"]["definition_lang"] ?></span>
              <span>|</span>
              <span>autor: <?= $web["studySet"]["created_by"] ?></span>
            </p>
          </div>
        </section>
        
        <section class="margin-20">
          <h2 class="lowercase smaller">Wybierz tryb nauki:</h2>
          <p class="studysetinfo normal">
            <span><b><a href="<?= $web["studySet"]["id"] ?>/fiszki">Fiszki</a></b></span>
            <span>|</span>
            <span><b><a href="<?= $web["studySet"]["id"] ?>/pisanie">Pisanie</a></b></span>
          </p>
        </section>
        
        <section>
          <h2 class="lowercase smaller">Wszystkie pojęcia w zestawie:</h2>
          <section id="new-flashcards" class="c-40 show">
          <?php
            foreach($web['flashcards'] as $flashcard) {
              ?>
              <div class="new-flashcard">
                <span><?= $flashcard["term"] ?></span>
                <span>-</span>
                <span><?= $flashcard["definition"] ?></span>
              </div>
          <?php  }
          ?>
          </section>
        </section>
      </section>
    </article>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>