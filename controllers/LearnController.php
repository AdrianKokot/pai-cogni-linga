<?php

class LearnController extends Controller {
  public function learn() {
    if(count($_SESSION['routeOther']) == 1) {
      $id = $_SESSION['routeOther'][0];
      
      $flashcardSet = DB::selectOne("SELECT ss.id, title, flashcard_count, created_by, c.name as 'categoryName', description, term_lang, definition_lang FROM study_set as ss join category as c on c.id = ss.category WHERE ss.id = :id", ['id' => $id]);
      $flashcardSet["data"]["term_lang"] = DB::selectOne("SELECT lang FROM language WHERE id = :id", ["id" => $flashcardSet["data"]["term_lang"]])["data"]["lang"];
      $flashcardSet["data"]["definition_lang"] = DB::selectOne("SELECT lang FROM language WHERE id = :id", ["id" => $flashcardSet["data"]["definition_lang"]])["data"]["lang"];
      $flashcardSet["data"]["created_by"] = DB::selectOne("SELECT login FROM user WHERE id = :id", ["id" => $flashcardSet["data"]["created_by"]])["data"]["login"];

      $flashcards = DB::select("SELECT id, term, definition FROM study_set_flashcard as ssf join flashcard as f on ssf.flashcard = f.id WHERE ssf.study_set = :id", ["id" => $id]);
      return $this->view('learn.php', [
        'pageTitle' => $flashcardSet["data"]["title"],
        'web' => [
          'studySet' => $flashcardSet["data"],
          'flashcards' => $flashcards["data"]
          ]
      ]);
    } else if (count($_SESSION['routeOther']) == 2) {
      $id = $_SESSION['routeOther'][0];
      $method = $_SESSION['routeOther'][1];

      switch($method) {
        case 'pisanie': return $this->writingMode($id); break;
        case 'fiszki': return $this->flashcardMode($id); break;
        case 'edytuj': return $this->edit($id); break;
        default: return $this->view('notfound');
      }
    }
    die();
  }

  public function writingMode($id) {
    return $this->view('writing_mode.php', ['pageTitle' => 'Nauka zestawu '.$id]);
  }
  
  private function flashcardMode($id) {
    return $this->view('flashcard_mode.php', ['pageTitle' => 'Nauka zestawu '.$id]);
  }

  private function edit($id) {
    return $this->view('edit.php', ['pageTitle' => 'Edycja zestawu '.$id]);
  }
}