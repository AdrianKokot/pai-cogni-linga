<?php

class HomeController extends Controller {
  public function main() {
      return $this->view('main.php', ['pageTitle' => 'Strona główna', 'web' => [
          'categories' => DB::select('SELECT * FROM category')["data"],
          'allSets' => DB::select("SELECT id, title, flashcard_count FROM study_set WHERE visibility = 1 ORDER BY created_date DESC LIMIT 3")["data"],
          'favouriteSets' => DB::select("SELECT id, title, flashcard_count FROM favourite_sets as fs join study_set as ss on ss.id = fs.study_set WHERE visibility = 1 and user = :id", ["id" => $_SESSION["userId"]])["data"],
          'historySets' => DB::select("SELECT id, title, flashcard_count FROM learning_history as fh join study_set as ss on fh.study_set = ss.id WHERE visibility = 1 and user = :id order by created_date DESC LIMIT 3", ["id" => $_SESSION["userId"]])["data"]
      ]]);
  }

  public function allsets() {
    return $this->view('allsets.php', ['pageTitle' => 'Wszystkie fiszki', 'web' => [
        'allSets' => DB::select("SELECT id, title, flashcard_count FROM study_set WHERE visibility = 1 ORDER BY created_date DESC")["data"]
    ]]);
  }

  public function usersets() {
    return $this->view('usersets.php', ['pageTitle' => 'Moje fiszki', 'web' => [
      'mySets' => DB::select("SELECT id, title, flashcard_count FROM study_set WHERE visibility = 1 and created_by = :id ORDER BY created_date DESC", ['id' => $_SESSION['userId']])["data"],
      'favouriteSets' => DB::select("SELECT id, title, flashcard_count FROM favourite_sets as fs join study_set as ss on ss.id = fs.study_set WHERE visibility = 1 and user = :id", ["id" => $_SESSION["userId"]])["data"],
      'historySets' => DB::select("SELECT id, title, flashcard_count FROM learning_history as fh join study_set as ss on fh.study_set = ss.id WHERE visibility = 1 and user = :id order by finished_date DESC", ["id" => $_SESSION["userId"]])["data"]
    ]]);
  }
}