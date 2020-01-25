<?php

class LearnController extends Controller {
  public function learn() {
    if(count($_SESSION['routeOther']) == 1) {
      $id = $_SESSION['routeOther'][0];
      
      $flashcardSet = DB::selectOne("SELECT ss.id, title, flashcard_count, created_by, c.name as 'categoryName', description, term_lang, definition_lang FROM study_set as ss join category as c on c.id = ss.category WHERE ss.id = :id", ['id' => $id]);
      $flashcardSet["data"]["term_lang"] = DB::selectOne("SELECT lang FROM language WHERE id = :id", ["id" => $flashcardSet["data"]["term_lang"]])["data"]["lang"];
      $flashcardSet["data"]["definition_lang"] = DB::selectOne("SELECT lang FROM language WHERE id = :id", ["id" => $flashcardSet["data"]["definition_lang"]])["data"]["lang"];
      $flashcardSet["data"]["created_by"] = DB::selectOne("SELECT login FROM user WHERE id = :id", ["id" => $flashcardSet["data"]["created_by"]])["data"]["login"];

      $flashcardSet["data"]["favourite"] = DB::select("SELECT * FROM favourite_sets WHERE user = :userId and study_set = :studySet", ["userId" => $_SESSION['userId'], 'studySet' => $id])["rows"];

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
        case 'ulubione': return $this->favourite($id); break;
        default: return $this->view('notfound');
      }
    }
    die();
  }

  public function writingMode($id) {
    $this->saveToHistory($id);
    return $this->view('writing_mode.php', ['pageTitle' => 'Nauka zestawu '.$id]);
  }
  
  private function flashcardMode($id) {
    $this->saveToHistory($id);
    return $this->view('flashcard_mode.php', ['pageTitle' => 'Nauka zestawu '.$id]);
  }

  private function saveToHistory($id) {
    if(DB::select("SELECT * FROM learning_history WHERE user = :userId and study_set = :id", ['userId' => $_SESSION["userId"], 'id' => $id])["rows"] == 0){
      DB::insert('INSERT INTO learning_history VALUES (:userId, :id, 0, 0, null)', ['userId' => $_SESSION["userId"], 'id' => $id]);
    } else {
      //TODO PROGRESS
      // DB::insert("UPDATE learning_history SET progress ")
    }
  }

  private function edit($id) {
    return $this->view('edit.php', ['pageTitle' => 'Edycja zestawu '.$id]);
  }

  private function favourite($id) {
    $data = ["userId" => $_SESSION['userId'], 'studySet' => $id];
    if(DB::select("SELECT * FROM favourite_sets WHERE user = :userId and study_set = :studySet", $data)["rows"] == 0)
      DB::insert("INSERT INTO favourite_sets values (:userId, :studySet)", $data);
    else 
      DB::insert("DELETE FROM favourite_sets WHERE user = :userId and study_set = :studySet", $data);
    return $this->redirectTo("/nauka/$id");
  }
}