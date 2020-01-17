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
      if(!(isset($_POST['study-set-name']) && isset($_POST['study-set-description']) && isset($_POST['study-set-term-lang']) && isset($_POST['study-set-definition-lang']) && isset($_POST['study-set-category']) && isset($_POST['study-set-visibility']) && count($_POST['new-flashcard-definition']) > 0)){
          return $this->redirectTo('/');
      }
      $count = count($_POST['new-flashcard-definition']);
      if(DB::insert("INSERT INTO study_set (`title`, `created_by`, `flashcard_count`, `description`, `term_lang`, `definition_lang`, `category`, `visibility`, `points`) 
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
      ])) {
          return $this->redirectTo("/nauka/$id");
      } else {
          return $this->redirectTo('/');
      }
  }
}