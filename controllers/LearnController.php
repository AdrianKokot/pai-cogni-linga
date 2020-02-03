<?php

class LearnController extends Controller {
  public function learn() {
    try {
      $id = $_SESSION['routeOther'][0];

      $publicId = DB::$vPublicID;
    
      $flashcardSet = DB::selectOne("SELECT ss.id, title, flashcard_count, created_by, c.name as 'categoryName', visibility, description, term_lang, definition_lang FROM study_sets as ss join categories as c on c.id = ss.category WHERE ss.id = :id", ['id' => $id]);
      if($flashcardSet['rows'] == 0 || ($flashcardSet['data']['visibility'] != $publicId && $flashcardSet['data']['created_by'] != $_SESSION["userId"])) throw new Exception();

      $flashcardSet["data"]["term_lang"] = DB::selectOne("SELECT lang FROM languages WHERE id = :id", ["id" => $flashcardSet["data"]["term_lang"]])["data"]["lang"];
      $flashcardSet["data"]["definition_lang"] = DB::selectOne("SELECT lang FROM languages WHERE id = :id", ["id" => $flashcardSet["data"]["definition_lang"]])["data"]["lang"];
      $flashcardSet["data"]["created_by"] = DB::selectOne("SELECT login FROM users WHERE id = :id", ["id" => $flashcardSet["data"]["created_by"]])["data"]["login"];
  
      $flashcardSet["data"]["favourite"] = DB::select("SELECT * FROM favourite_sets WHERE user = :userId and study_set = :studySet", ["userId" => $_SESSION['userId'], 'studySet' => $id])["rows"];
  
      $flashcards = DB::select("SELECT id, term, definition FROM study_set_flashcards as ssf join flashcards as f on ssf.flashcard = f.id WHERE ssf.study_set = :id", ["id" => $id]);
  
      $routeData = [
        'pageTitle' => $flashcardSet["data"]["title"],
        'web' => [
          'studySet' => $flashcardSet["data"],
          'flashcards' => $flashcards["data"]
          ]
        ];
      
      if(count($_SESSION['routeOther']) == 1) {
        return $this->view('learn.php', $routeData);
      } else if (count($_SESSION['routeOther']) == 2) {
        $id = $_SESSION['routeOther'][0];
        $method = $_SESSION['routeOther'][1];
  
        switch($method) {
          case 'pisanie': return $this->writingMode($id, $routeData); break;
          case 'fiszki': return $this->flashcardMode($id, $routeData); break;
          case 'edytuj': return $this->edit($id); break;
          case 'ulubione': return $this->favourite($id); break;
          case 'postep': return $this->progress($id); break;
          default: return $this->abort();
        }
      }
    } catch(Exception $e) {
      return $this->abort();
    }
    die();
  }

  public function progress($id) {
    
  }

  public function writingMode($id, $data = null) {
    $this->saveToHistory($id);
    return $this->view('writing_mode.php', $data);
  }
  
  private function flashcardMode($id, $data = null) {
    $this->saveToHistory($id);
    return $this->view('flashcard_mode.php', $data);
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