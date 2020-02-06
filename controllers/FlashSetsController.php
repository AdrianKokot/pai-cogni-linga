<?php

require_once (ROOT_DIR.'/app/Controller.php');
require_once (ROOT_DIR.'/app/Auth.php');
require_once (ROOT_DIR.'/app/Guard.php');

class FlashSetsController extends Controller {

  public function index() {
    return $this->view('create.php', ['pageTitle' => "Tworzenie zestawu", 'web' => [
        'categories' => DB::select("SELECT * FROM categories")["data"] ?? null,
        'languages' => DB::select("SELECT * FROM languages")["data"] ?? null,
        'visibilities' => DB::select("SELECT * FROM visibilities")["data"] ?? null
    ]]);
  }

  public function edit() {
    $id = $_SESSION['routeOther'][0];
    if($id != null) {
      $set = DB::selectOne("SELECT * FROM study_sets WHERE id = :id AND created_by = :userId", ["id" => $id, "userId" => $_SESSION["userId"]]);
      if($set["rows"] == 1) {
        $set = $set["data"];
        Session::setFormData([
          'study-set-name' => $set["title"] ?? null, 
          'study-set-description' => $set["description"] ?? null, 
          'study-set-term-lang' => $set["term_lang"] ?? null, 
          'study-set-definition-lang' => $set["definition_lang"] ?? null, 
          'study-set-category' => $set["category"] ?? null, 
          'study-set-visibility' => $set["visibility"] ?? null,
          'flashcards' => DB::select("SELECT * FROM flashcards as f join study_set_flashcards as ssf on ssf.flashcard = f.id WHERE ssf.study_set = :id", ["id" => $id])["data"] ?? null
        ]);

        return $this->view('edit.php', ['pageTitle' => "Edycja \"$set[title]\"", 'web' => [
          'categories' => DB::select("SELECT * FROM categories")["data"] ?? null,
          'languages' => DB::select("SELECT * FROM languages")["data"] ?? null,
          'visibilities' => DB::select("SELECT * FROM visibilities")["data"] ?? null
        ]]);
      }
    }
    
    return $this->abort();
  }

  public function delete() {
    $id = $_SESSION['routeOther'][0];
    if($id != null) {
      if(DB::selectOne("SELECT * FROM study_sets WHERE id = :id AND created_by = :userId", ["id" => $id, "userId" => $_SESSION["userId"]])["rows"] == 1) {
        DB::update("DELETE FROM favourite_sets WHERE study_set = :id", ["id" => $id]);
        DB::update("DELETE FROM learning_history WHERE study_set = :id", ["id" => $id]);
        foreach(DB::select("SELECT * FROM study_set_flashcards WHERE study_set = :id", ["id" => $id])["data"] as $flash) {
          DB::update("DELETE FROM study_set_flashcards WHERE flashcard = :flashId and study_set = :id", ["id" => $id, "flashId" => $flash["flashcard"]]);
          DB::update("DELETE FROM flashcards WHERE id = :flashId", ["flashId" => $flash["flashcard"]]);
        }
        DB::update("DELETE FROM study_sets WHERE id = :id", ['id' => $id]);
      }
    }
    return $this->redirectTo("/");
  }

  public function postCreate() {
    Session::setFormData([
        'study-set-name' => $_POST['study-set-name'] ?? null, 
        'study-set-description' => $_POST['study-set-description'] ?? null, 
        'study-set-term-lang' => $_POST['study-set-term-lang'] ?? null, 
        'study-set-definition-lang' => $_POST['study-set-definition-lang'] ?? null, 
        'study-set-category' => $_POST['study-set-category'] ?? null, 
        'study-set-visibility' => $_POST['study-set-visibility'] ?? null, 
        'new-flashcard-term' => $_POST['new-flashcard-term'],
        'new-flashcard-definition' => $_POST['new-flashcard-definition']
      ]);

      if(
        !isset($_POST['study-set-name']) || empty($_POST['study-set-name']) ||
        !isset($_POST['study-set-description']) || empty($_POST['study-set-description']) ||
        !isset($_POST['study-set-term-lang']) || empty($_POST['study-set-term-lang']) ||
        !isset($_POST['study-set-definition-lang']) || empty($_POST['study-set-definition-lang']) ||
        !isset($_POST['study-set-category']) || empty($_POST['study-set-category']) ||
        !isset($_POST['study-set-visibility']) || empty($_POST['study-set-visibility'])
      ){
        Session::setFlash('Wypełnij wszystkie wymagane pola.');
        return $this->redirectTo('/dodaj');
      }

      if(count($_POST['new-flashcard-definition']) <=1) {
        Session::setFlash('Zestaw musi mieć przynajmniej dwie pary fiszek.');
        return $this->redirectTo('/dodaj');
      }
            

      $count = count($_POST['new-flashcard-definition']);
      $id = DB::insert("INSERT INTO study_sets (`title`, `created_by`, `flashcard_count`, `description`, `term_lang`, `definition_lang`, `category`, `visibility`, `points`) 
      VALUES (:title, :createdBy, :flashcardCount, :desc, :termLang, :defLang, :cat, :vis, :points)", [
          'title' => $_POST['study-set-name'], 
          'createdBy' => $_SESSION['userId'], 
          'flashcardCount' => $count, 
          'desc' => $_POST['study-set-description'], 
          'termLang' => $_POST['study-set-term-lang'], 
          'defLang' => $_POST['study-set-definition-lang'], 
          'cat' => $_POST['study-set-category'], 
          'vis' => $_POST['study-set-visibility'], 
          'points' => $count * 3,
      ]);

      foreach($_POST["new-flashcard-term"] as $key => $newFlashcard) {
        $fId = DB::insert("INSERT INTO flashcards (`term`, `definition`) VALUES (:term, :definition)", ['term' => $newFlashcard, 'definition' => $_POST["new-flashcard-definition"][$key]]);
        DB::insert("INSERT INTO study_set_flashcards VALUES (:flashcardId, :setId)", ['flashcardId' => $fId, 'setId' => $id]);
      }


      if($id) {
          unset($_SESSION['formData']);
          return $this->redirectTo("/nauka/$id");
      } else {
        Session::setFlash('Coś poszło nie tak.');
        return $this->redirectTo('/dodaj');
      }
  }

  public function postEdit() {
    //TODO edit post
  }
}