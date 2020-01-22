<?php

require_once (ROOT_DIR.'/app/Controller.php');
require_once (ROOT_DIR.'/app/Auth.php');
require_once (ROOT_DIR.'/app/Guard.php');

class FlashSetsController extends Controller {

  public function index() {
    return $this->view('create.php', ['pageTitle' => "Tworzenie zestawu", 'web' => [
        'categories' => DB::select("SELECT * FROM category")["data"] ?? null,
        'languages' => DB::select("SELECT * FROM language")["data"] ?? null,
        'visibilities' => DB::select("SELECT * FROM visibility")["data"] ?? null
    ]]);
  }

  public function postCreate() {
    Session::setFormData([
        'study-set-name' => $_POST['study-set-name'] ?? null, 
        'study-set-description' => $_POST['study-set-description'] ?? null, 
        'study-set-term-lang' => $_POST['study-set-term-lang'] ?? null, 
        'study-set-definition-lang' => $_POST['study-set-definition-lang'] ?? null, 
        'study-set-category' => $_POST['study-set-category'] ?? null, 
        'study-set-visibility' => $_POST['study-set-visibility'] ?? null, 
      ]);

      if(!(isset($_POST['study-set-name']) && isset($_POST['study-set-description']) && isset($_POST['study-set-term-lang']) && isset($_POST['study-set-definition-lang']) && isset($_POST['study-set-category']) && isset($_POST['study-set-visibility']) && count($_POST['new-flashcard-definition']) > 1)){
        if(count($_POST['new-flashcard-definition']) <=1)  
            Session::setFlash('Zestaw musi mieć przynajmniej dwie pary fiszek.');
        else Session::setFlash('Wypełnij wszystkie wymagane pola.');
        return $this->redirectTo('/dodaj');
      }

      $count = count($_POST['new-flashcard-definition']);
      $id = DB::insert("INSERT INTO study_set (`title`, `created_by`, `flashcard_count`, `description`, `term_lang`, `definition_lang`, `category`, `visibility`, `points`) 
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
        $fId = DB::insert("INSERT INTO flashcard (`term`, `definition`) VALUES (:term, :definition)", ['term' => $newFlashcard, 'definition' => $_POST["new-flashcard-definition"][$key]]);
        DB::insert("INSERT INTO study_set_flashcard VALUES (:flashcardId, :setId)", ['flashcardId' => $fId, 'setId' => $id]);
      }


      if($id) {
          unset($_SESSION['formData']);
          return $this->redirectTo("/nauka/$id");
      } else {
        Session::setFlash('Coś poszło nie tak.');
        return $this->redirectTo('/dodaj');
      }
  }
}