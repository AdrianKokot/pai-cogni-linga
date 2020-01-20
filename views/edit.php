<?php
require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <section>
        <h2>Utwórz nowy zestaw</h2>
        <section id="create">
          <form action="" id="create-study-set-form">
            <label>
              Nazwa zestawu:
              <input type="text" name="study-set-name" required maxlength="48" value="Nazwa zestawu jest bardzo bardzo długa">
            </label>
            <label>
              Opis zestawu:
              <textarea name="study-set-description" required maxlength="255">Fiszki</textarea>
            </label>
            <div class="form-group f-wrap">
              <label>
                Język pojęcia:
                <select name="study-set-term-lang">
                  <option value="en" selected>Angielski</option>
                  <option value="pl">Polski</option>
                </select>
              </label>
              <label>
                Język definicji:
                <select name="study-set-definition-lang">
                  <option value="en">Angielski</option>
                  <option value="pl" selected>Polski</option>
                </select>
              </label>
              <label>
                Kategoria zestawu:
                <select name="study-set-category">
                  <option value="it" selected>Informatyka</option>
                  <option value="maths">Matematyka</option>
                </select>
              </label>
              <label>
                Dostęp do zestawu:
                <select name="study-set-visibility">
                  <option value="1" selected>Publiczny</option>
                  <option value="0">Prywatny</option>
                </select>
              </label>
            </div>
            <section>
              <h2>Fiszki:</h2>
              <section id="new-flashcards" class="c-40">
                <div class="new-flashcard">
                  <div class="counter">1</div>
                  <input type="text" name="new-flashcard-term-1" placeholder="pojęcie" value="pojęcie 1">
                  <input type="text" name="new-flashcard-definition-1" placeholder="definicja" value="definicja 1">
                </div>
                <div class="new-flashcard">
                  <div class="counter">2</div>
                  <input type="text" name="new-flashcard-term-2" id="" value="pojęcie 2" placeholder="pojęcie"><input type="text" name="new-flashcard-definition-2" id="" value="definicja 2" placeholder="definicja">
                </div>
                <div class="new-flashcard">
                  <div class="counter">3</div>
                  <input type="text" name="new-flashcard-term-3" id="" value="pojęcie 3" placeholder="pojęcie"><input type="text" name="new-flashcard-definition-3" id="" value="definicja 3" placeholder="definicja">
                </div>
                <div class="new-flashcard">
                  <div class="counter">4</div>
                  <input type="text" name="new-flashcard-term-4" id="" value="pojęcie 4" placeholder="pojęcie"><input type="text" name="new-flashcard-definition-4" id="" value="definicja 4" placeholder="definicja">
                </div>
                <div class="new-flashcard">
                  <div class="counter">5</div>
                  <input type="text" name="new-flashcard-term-5" id="" value="pojęcie 5" placeholder="pojęcie"><input type="text" name="new-flashcard-definition-5" id="" value="definicja 5" placeholder="definicja">
                </div>
                <div class="new-flashcard">
                  <div class="counter">6</div>
                  <input type="text" name="new-flashcard-term-6" id="" value="pojęcie 6" placeholder="pojęcie"><input type="text" name="new-flashcard-definition-6" id="" value="definicja 6" placeholder="definicja">
                </div>
                <div class="new-flashcard">
                  <div class="counter">7</div>
                  <input type="text" name="new-flashcard-term-7" id="" value="pojęcie 7" placeholder="pojęcie"><input type="text" name="new-flashcard-definition-7" id="" value="definicja 7" placeholder="definicja">
                </div>
                <div class="new-flashcard">
                  <div class="counter">8</div>
                  <input type="text" name="new-flashcard-term-8" id="" value="pojęcie 8" placeholder="pojęcie"><input type="text" name="new-flashcard-definition-8" id="" value="definicja 8" placeholder="definicja">
                </div>
                <div class="new-flashcard">
                  <div class="counter">9</div>
                  <input type="text" name="new-flashcard-term-9" id="" value="pojęcie 9" placeholder="pojęcie"><input type="text" name="new-flashcard-definition-9" id="" value="definicja 9" placeholder="definicja">
                </div>
                <div class="new-flashcard">
                  <div class="counter">10</div>
                  <input type="text" name="new-flashcard-term-10" id="" value="pojęcie 10" placeholder="pojęcie"><input type="text" name="new-flashcard-definition-10" id="" value="definicja 10" placeholder="definicja">
                </div>
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
  let counter = 10;
  createNew.addEventListener("click", () => {
    counter++;
    flashcards.innerHTML += `<div class="new-flashcard">
                  <div class="counter">${counter}</div>
                  <input type="text" name="new-flashcard-term-${counter}" placeholder="pojęcie">
                  <input type="text" name="new-flashcard-definition-${counter}" placeholder="definicja">
                </div>`;
    counterInput.value = counter;
    if(counter==100){
      flashcards.classList.remove("c-40");
      flashcards.classList.add("c-60");
    }
  })
</script>