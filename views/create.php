<?php
  require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <section>
        <h2>Utwórz nowy zestaw</h2>
        <p class="mb-25 wrong"><?= Session::flash() ?></p>
        <section id="create">
          <form method="post" id="create-study-set-form">
            <label>
              Nazwa zestawu:
              <input type="text" name="study-set-name" required maxlength="48" value="<?= Session::old('study-set-name') ?>">
            </label>
            <label>
              Opis zestawu:
              <textarea name="study-set-description" required maxlength="255"><?= Session::old('study-set-description') ?></textarea>
            </label>
            <div class="form-group f-wrap">
              <label>
                Język pojęcia:
                <select name="study-set-term-lang">

                <?php
                  
                  foreach($web['languages'] as $lang){
                    ?>
                    
                  <option value="<?= $lang['id'] ?>" <?= $lang['id'] == intval(Session::old('study-set-term-lang')) ? 'selected' : "" ?>><?= ucfirst($lang['lang']) ?></option>
                    <?php
                  }
                ?>
                </select>
              </label>
              <label>
                Język definicji:
                <select name="study-set-definition-lang">
                <?php
                  foreach($web['languages'] as $lang){
                    ?>
                  <option value="<?= $lang['id'] ?>" <?= $lang['id'] == intval(Session::old('study-set-definition-lang')) ? 'selected' : "" ?>><?= ucfirst($lang['lang']) ?></option>
                    <?php
                  }
                ?>
                </select>
              </label>
              <label>
                Kategoria zestawu:
                <select name="study-set-category">
                <?php
                  foreach($web['categories'] as $cat){
                    ?>
                  <option value="<?= $cat['id'] ?>" <?= $cat['id'] == intval(Session::old('study-set-category')) ? 'selected' : "" ?>><?= ucfirst($cat['name']) ?></option>
                    <?php
                  }
                ?>
                </select>
              </label>
              <label>
                Dostęp do zestawu:
                <select name="study-set-visibility">
                <?php
                  foreach($web['visibilities'] as $vis){
                    ?>
                  <option value="<?= $vis['id'] ?>" <?= $vis['id'] == intval(Session::old('study-set-visibility')) ? 'selected' : "" ?>><?= ucfirst($vis['name']) ?></option>
                    <?php
                  }
                ?>
                </select>
              </label>
            </div>
            <section>
              <h2>Fiszki:</h2>
              <section id="new-flashcards" class="c-40">
                <?php
                  $arrTerm = Session::old('new-flashcard-term') ?? null;
                  $arrDef = Session::old('new-flashcard-definition') ?? null;
                  $count = $arrTerm ? count($arrTerm) : 0;
                  if($count != 0){
                  for($i = 0; $i<$count; $i++) {
                ?>
                  <div class="new-flashcard">
                    <div class="counter"><?= $i + 1 ?></div>
                    <input type="text" name="new-flashcard-term[]" placeholder="pojęcie" value="<?= $arrTerm[$i] ?>">
                    <input type="text" name="new-flashcard-definition[]" placeholder="definicja" value="<?= $arrDef[$i] ?>">
                  </div>
                <?php }} else {?>
                <div class="new-flashcard">
                  <div class="counter">1</div>
                  <input type="text" name="new-flashcard-term[]" placeholder="pojęcie">
                  <input type="text" name="new-flashcard-definition[]" placeholder="definicja">
                </div>
                <?php } ?>
              </section>
              <div id="createnewdiv"><h2 id="createnew"><i class="fas fa-plus"></i> Dodaj</h2></div>
            </section>
            <input type="number" id="flashcard-counter" name="flashcard-count" style="display: none;">
            <div id="submitdiv"><input type="submit" value="Zapisz"></div>
          </form>
        </section>
      </section>
    </article>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>
<script>
  const createNew = document.querySelector("#createnew");
  const flashcards = document.querySelector("#new-flashcards");
  const counterInput = document.querySelector("#flashcard-counter");
  let counter = <?= $count != 0 ? $count : 1 ?>;
  createNew.addEventListener("click", () => {
    counter++;
    var div = document.createElement("div");
    div.classList.add("new-flashcard");
    div.innerHTML = `<div class="counter">${counter}</div>
                  <input type="text" name="new-flashcard-term[]" placeholder="pojęcie">
                  <input type="text" name="new-flashcard-definition[]" placeholder="definicja">`;
    flashcards.append(div);
    counterInput.value = counter;
    if(counter==100){
      flashcards.classList.remove("c-40");
      flashcards.classList.add("c-60");
    }
  })
</script>