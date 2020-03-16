<?php
  require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <section>
        <h2>Utwórz nową kategorię</h2>
        <p class="mb-25 wrong"><?= Session::flash() ?></p>
        <section id="create">
          <form method="post" id="create-study-set-form" enctype="multipart/form-data">
            <label>
              Nazwa kategorii:
              <input type="text" name="name" required maxlength="48" value="<?= Session::old('name') ?>">
            </label>
            <label>
              Miniaturka dla kategorii:
              <input type="file" name="image" required accept="image/jpeg" style="background-color: white; color:black">
            </label>
            <div id="submitdiv"><input type="submit" value="Zapisz"></div>
          </form>
        </section>
      </section>
    </article>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>