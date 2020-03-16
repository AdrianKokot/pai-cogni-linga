<?php
  require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <section>
        <h2>Menedżer kategorii</h2>
        <p class="mb-25 wrong"><?= Session::flash() ?></p>
        <section class="recent">
          <?php
            foreach($web["categories"] as $cat){
          ?>
          <div class="flash-prev" style="justify-content: space-between;cursor:default">
            <div class="flash-description">
              <h3><?= $cat["name"] ?></h3>
            </div>
            <?php
              if(Guard::isAdmin()){
                ?>
            <a class="flash-img" style="text-align:center;line-height:80px;width:30px; cursor:pointer" title="Usuń kategorię" href="<?= ROOT_URL ?>/kategorie/usun/<?= $cat['id'] ?>">
              <i class="far fa-trash-alt"></i>
            </a>
                <?php
              }
            ?>
          </div>
          <?php
            }
          ?>
        </section>
        <h2 class="load-more">
          <a href="<?= ROOT_URL ?>/kategorie/nowa"><i class="fas fa-plus"></i> Dodaj kategorię</a>
        </h2>
      </section>
    </article>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>