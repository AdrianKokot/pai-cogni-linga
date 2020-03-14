<?php
require_once ROOT_DIR.'/layout/app-nav.php';
$studySetID = $web['studySet']['id'];
?>
<section>
  <section id="app-panel">
    <article>
      <section>
        <p>
          <a href="<?= ROOT_URL ?>/nauka/<?= $studySetID?>"><i class="fas fa-angle-left"></i> <strong>Powrót</strong></a>
        </p>
        <h2 class="lowercase learning"><?= $web['studySet']['title'] ?>
          <span class="learning-settings">
            <span class="btn" id="progress-reset" title="Resetuj postęp"><i class="fas fa-sync-alt"></i></span>
            <span class="btn" id="change-term-definition" title="Zmień kolejność wyświetlania definicji i pojęcia"><i class="fas fa-exchange-alt"></i></span>
          </span>
        </h2>
        <p><strong>Twój postęp: <span class="flashcards-counter"></span></strong></p>
        <section id="learn-panel" class="flashcards-panel-write">
          <section class="flashcards-panel flashcards-panel-write">
            <p id="errorMessage" class="wrong"></p>
            <section class="flashcard-view">
              
            </section>
            <form id="answer">
              <input type="text" name="flashcard-answer" id="answerInput" autofocus>
              <input type="submit" value="Sprawdź" id="answerBtn">
            </form>
          </section>
        </section>
      </section>
    </article>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>
<script>
  const flashcardsArr = <?= json_encode($web['flashcards']) ?>;
  flashcardsArr.reverse();

  function renderFlashcards(termFirst) {
    const flashcardView = document.querySelector(".flashcard-view");
    flashcardView.innerHTML = "";
    flashcardsArr.forEach(el => {
      flashcardView.innerHTML += `<div class="flashcard">
                      ${termFirst ? el.term : el.definition}
                </div>`;
    });
  }

  function initFlashcardFunctionality () {

    function initController() {
      pos = 1;
      correct = 0;
      currTerm = termFirst;
      renderFlashcards(termFirst);
      curr = document.querySelector(`.flashcard-view .flashcard:last-of-type`);
      curr.classList.add("active");
      flashcardsCounter.textContent = `${pos}/${flashcardsArr.length}`;
      flashcards = document.querySelectorAll(".flashcard-view .flashcard");
    }

    const flashcardsCounter = document.querySelector(".flashcards-counter");
    const resetBtn = document.querySelector("#progress-reset");
    const termDefinitionBtn = document.querySelector("#change-term-definition");
    let pos, curr, next, currTerm = true, termFirst = true, flashcards, correct = 0, canCheck = true, badAnswers = [];
    const answerInput = document.querySelector("#answerInput");
    const answerBtn = document.querySelector("#answerBtn");
    const errorMessage = document.querySelector("#errorMessage");

    initController();

    function nextFlash() {
      if(pos < flashcardsArr.length) {
        pos++;
        currTerm=termFirst;
        flashcardsCounter.textContent = `${pos}/${flashcardsArr.length}`;
        curr.classList.add("learned");
        next = document.querySelector(`.flashcard-view .flashcard:nth-last-of-type(2)`);
        next.classList.add("active");
        setTimeout(() => {
          curr.remove();
          curr = next;
        }, 301);
      } else if(pos == flashcardsArr.length){
        document.querySelector("#learn-panel .flashcards-panel.flashcards-panel-write").remove();
        const learnPanel = document.querySelector("#learn-panel");
        learnPanel.innerHTML += `<h3 class="t-center mt-20"><span>Poprawnych odpowiedzi: <span class="good">${correct}</span></span> | <span>Niepoprawnych odpowiedzi: <span class="wrong">${badAnswers.length}</span></span></h3>`;
        if(badAnswers.length > 0) learnPanel.innerHTML += `<p class="t-center">Spis słówek, na które odpowiedziano błędnie:</p>`;
        badAnswers.forEach(answerPos => {
          learnPanel.innerHTML += `<p class="t-center mt-15">${flashcardsArr[flashcardsArr.length - answerPos].definition} <strong>-</strong> ${flashcardsArr[flashcardsArr.length - answerPos].term}</p>`;
        });
        fetch(`<?= ROOT_URL ?>/postep`, {
          method: "POST",
          credentials: "same-origin",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({"correct": correct, "id": <?= $studySetID ?>})
        }).then(res => {
          if(res.ok) return res.json();
        }).then(json => {
          
          if(json.earned != 0) {
            var msg = json.earned;
            switch(json.earned) {
              case 1: msg += " punkt"; break;
              case 2:
              case 3:
              case 4: msg += " punkty"; break;
              default: msg += " punktów"; break;
            }
            learnPanel.innerHTML += `<p class="t-center mt-15">Zyskano dodatkowe ${msg}!</p>`;
          }
        }).catch(e => {
          console.log(e);
        })
      }
    }

    function check() {
      if(canCheck){
        let correctAnswer = termFirst ? flashcardsArr[flashcardsArr.length - pos].definition : flashcardsArr[flashcardsArr.length - pos].term;
        if(answerInput.value.toLowerCase() == correctAnswer.toLowerCase()){
          correct++;
          nextFlash();
        } else {
          errorMessage.textContent = "Niepoprawna odpowiedź!";
          badAnswers.push(pos);
          canCheck = false;
          answerInput.disabled = true;
          setTimeout(() => {
            errorMessage.textContent = "";
            canCheck = true;
            nextFlash();
            answerInput.disabled = false;
            answerInput.focus();
          },1000);
        }
        answerInput.value = "";
      }
    }

    answerBtn.addEventListener("click", e => {
      e.preventDefault();
      check();
    })
    
    resetBtn.addEventListener("click", initController);

    termDefinitionBtn.addEventListener("click", () => {
      termFirst = !termFirst;
      currTerm = termFirst;
      initController();
    })
  }

  initFlashcardFunctionality();
</script>