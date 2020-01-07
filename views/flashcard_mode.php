<?php
require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <section>
        <p>
          <a href="/nauka/1"><i class="fas fa-angle-left"></i> <b>Powrót</b></a>
        </p>
        <h2 class="lowercase learning">Nazwa zestawu jest bardzo bardzo długa 
          <span class="learning-settings">
            <span class="btn" id="progress-reset" title="Resetuj postęp"><i class="fas fa-sync-alt"></i></span>
            <span class="btn" id="change-term-definition" title="Zmień kolejność wyświetlania definicji i pojęcia"><i class="fas fa-exchange-alt"></i></span>
            <span class="btn" id="volume-change" title="Wycisz dźwięk"><i class="fas fa-volume-up"></i></span>
          </span>
        </h2>
        
        <p><b>Twój postęp: <span class="flashcards-counter"></span></b></p>
        <section id="learn-panel">
          <section class="flashcards-panel">
            <div id="prev"><i class="fas fa-chevron-left"></i></div>

            <section class="flashcard-view">
              
            </section>

            <div id="next"><i class="fas fa-chevron-right"></i></div>
          </section>
          <div class="t-center">
            <span id="speechBtn"><b>Wymowa</b> <i class="fas fa-volume-up"></i></span>
          </div>
        </section>
      </section>
    </article>
  </section>
</section>

<script src="/js/navigation.js"></script>
<script>
  const flashcardsArr = [{
    "term": "pokój",
    "definition": "room"
  },{
    "term": "mieszkanie",
    "definition": "flat"
  },{
    "term": "postęp",
    "definition": "progress"
  }];
  flashcardsArr.reverse();
  const flashcardsLangs = {
    "termLang": "pl",
    "definitionLang": "en"
  }			

  const langs = {
    "pl": "pl-PL",
    "en": "en-US",
    "de": "de-DE"
  }

  function speech(txt, lang) {
    var msg = new SpeechSynthesisUtterance();
    msg.volume = 1;
    msg.rate = 1.5;
    msg.pitch = 1.5;
    msg.text  = txt;
    msg.lang = langs[lang];
    speechSynthesis.speak(msg);
  }

  function renderFlashcards(termFirst) {
    const flashcardView = document.querySelector(".flashcard-view");
    flashcardView.innerHTML = "";
    flashcardsArr.forEach(el => {
      flashcardView.innerHTML += `<div class="flashcard ${!termFirst ? "rotate" : ""}">
                  <div>
                    <div class="front">
                        ${el.term}
                      </div>
                      <div class="back">
                        ${el.definition}
                    </div>
                  </div>
                </div>`;
    });
  }

  function initFlashcardFunctionality () {

    function initController() {
      pos = 1;
      count = 1;
      currTerm = termFirst;
      renderFlashcards(termFirst);
      curr = document.querySelector(`.flashcard-view .flashcard:last-of-type`);
      curr.classList.add("active");
      flashcardsCounter.textContent = `${count}/${flashcardsArr.length}`;
      flashcards = document.querySelectorAll(".flashcard-view .flashcard");
      flashcards.forEach(el => {
        el.addEventListener("click", () => {
          if(el.classList.contains('active')){
            el.classList.toggle('rotate');
            currTerm=!currTerm;
            speechController();
          }
        });
      });
    }

    const prevBtn = document.querySelector("#prev");
    const nextBtn = document.querySelector("#next");
    const flashcardsCounter = document.querySelector(".flashcards-counter");
    const resetBtn = document.querySelector("#progress-reset");
    const speechBtn = document.querySelector("#speechBtn");
    const volumeBtn = document.querySelector("#volume-change");
    const termDefinitionBtn = document.querySelector("#change-term-definition");
    const volumeIcon = volumeBtn.querySelector("i");
    let pos, count, curr, next, prev, muted = false, currTerm = true, termFirst = true, flashcards, canChange = true;

    initController();

    

    nextBtn.addEventListener('click', () => {
      if(pos < flashcardsArr.length && canChange) {
        prevBtn.classList.remove("disabled");
        canChange = false;
        pos++;
        currTerm=termFirst;
        if(pos>count) count = pos;
        flashcardsCounter.textContent = `${count}/${flashcardsArr.length}`;
        curr.classList.add("learned");
        next = document.querySelector(`.flashcard-view .flashcard:nth-last-of-type(${pos})`);
        next.classList.add("active");
        setTimeout(() => {
          curr.classList.remove("active");
          curr.classList.remove("rotate");
          curr = next;
        }, 301);
        setTimeout(()=>{
          canChange = true;
        }, 400);
      } 
      if(pos == flashcardsArr.length) {
        nextBtn.classList.add("disabled");
      }
    });

    prevBtn.addEventListener('click', () => {
      nextBtn.classList.remove("disabled");
      if(pos > 1 && canChange) {
        canChange = false;
        pos--;
        currTerm=termFirst;
        prev = document.querySelector(`.flashcard-view .flashcard:nth-last-of-type(${pos})`);
        prev.classList.add("active");
        setTimeout(() => {
          prev.classList.remove("learned");
        }, 10);
        setTimeout(() => {
          curr.classList.remove("active");
          curr.classList.remove("rotate");
          curr = prev;
        }, 301)
        setTimeout(()=>{
          canChange = true;
        }, 400);
      }
      if(pos == 0){
        prevBtn.classList.add("disabled");
      }
    });
    

    prevBtn.classList.add("disabled");
    
    resetBtn.addEventListener("click", initController);

    volumeBtn.addEventListener("click", () => {
      muted = !muted;
      if(volumeIcon.classList.contains("fa-volume-up")){
        volumeIcon.classList.remove("fa-volume-up");
        volumeIcon.classList.add("fa-volume-mute");
      } else {
        volumeIcon.classList.add("fa-volume-up");
        volumeIcon.classList.remove("fa-volume-mute");
      }
      
    })

    function speechController() {
      if(!muted){
        let lang = currTerm ? flashcardsLangs.termLang : flashcardsLangs.definitionLang;
        let txt = currTerm ? flashcardsArr[flashcardsArr.length-pos].term : flashcardsArr[flashcardsArr.length-pos].definition;
        speech(txt, lang);
      }
    }
    speechBtn.addEventListener("click", speechController);

    termDefinitionBtn.addEventListener("click", () => {
      termFirst = !termFirst;
      currTerm = termFirst;
      flashcards.forEach(el => {
        if(termFirst)
          el.classList.remove("rotate");
        else
          el.classList.add("rotate");
      })
    })
  }

  initFlashcardFunctionality();

</script>