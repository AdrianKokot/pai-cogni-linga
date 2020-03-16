<?php

class HomeController extends Controller {

  public function main() {
      $publicId = DB::$vPublicID;
      $admin = Guard::isAdmin() ? "or true" : "";
      return $this->view('main.php', ['pageTitle' => 'Strona główna', 'web' => [
          'categories' => DB::select('SELECT * FROM categories')["data"],
          'allSets' => DB::select("SELECT id, title, flashcard_count, category FROM study_sets WHERE (visibility = $publicId or created_by = $_SESSION[userId] ".$admin.") ORDER BY created_date DESC LIMIT 3")["data"],
          'favouriteSets' => DB::select("SELECT id, title, flashcard_count, category FROM favourite_sets as fs join study_sets as ss on ss.id = fs.study_set WHERE (visibility = $publicId or created_by = $_SESSION[userId]) and user = :id", ["id" => $_SESSION["userId"]])["data"],
          'historySets' => DB::select("SELECT id, title, flashcard_count, category FROM learning_history as fh join study_sets as ss on fh.study_set = ss.id WHERE (visibility = $publicId or created_by = $_SESSION[userId]) and user = :id order by finished_date DESC LIMIT 3", ["id" => $_SESSION["userId"]])["data"],
          'week_rank' => DB::select("SELECT login,score_week FROM users WHERE users.status = :status ORDER BY score_week DESC LIMIT 5", ["status" => DB::$sActive])["data"] ?? [],
          'global_rank' => DB::select("SELECT login,score FROM users WHERE users.status = :status ORDER BY score DESC LIMIT 5", ["status" => DB::$sActive])["data"] ?? []
      ]]);
  }

  public function allsets() {
    $publicId = DB::$vPublicID;
    $admin = Guard::isAdmin() ? "or true" : "";
    return $this->view('allsets.php', ['pageTitle' => 'Wszystkie fiszki', 'web' => [
        'allSets' => DB::select("SELECT id, title, flashcard_count, category FROM study_sets WHERE (visibility = $publicId or created_by = $_SESSION[userId] ".$admin.") ORDER BY created_date DESC")["data"]
    ]]);
  }

  public function usersets() {
    $publicId = DB::$vPublicID;
    return $this->view('usersets.php', ['pageTitle' => 'Moje fiszki', 'web' => [
      'mySets' => DB::select("SELECT id, title, flashcard_count, category FROM study_sets WHERE created_by = :id ORDER BY created_date DESC", ['id' => $_SESSION['userId']])["data"],
      'favouriteSets' => DB::select("SELECT id, title, flashcard_count, category FROM favourite_sets as fs join study_sets as ss on ss.id = fs.study_set WHERE (visibility = $publicId or created_by = $_SESSION[userId]) and user = :id", ["id" => $_SESSION["userId"]])["data"],
      'historySets' => DB::select("SELECT id, title, flashcard_count, category FROM learning_history as fh join study_sets as ss on fh.study_set = ss.id WHERE (visibility = $publicId or created_by = $_SESSION[userId]) and user = :id order by finished_date DESC", ["id" => $_SESSION["userId"]])["data"]
    ]]);
  }

  public function category() {
    $publicId = DB::$vPublicID;
    $dbCategory = DB::selectOne("SELECT * FROM categories WHERE name = :name", ["name" => $_SESSION['routeOther'][0] ?? null]) ?? null;
    if($dbCategory != null && $dbCategory['rows'] > 0) {
      $categoryId = $dbCategory['data']['id'];
      return $this->view('allsets.php', ['pageTitle' => 'Zestawy w kategorii '.$dbCategory['data']['name'], 'web' => [
        'allSets' => DB::select("SELECT id, title, flashcard_count, category FROM study_sets WHERE (visibility = $publicId or created_by = $_SESSION[userId]) and category = $categoryId ORDER BY created_date DESC")["data"],
        'header' => 'Zestawy w kategorii '.$dbCategory['data']['name']
      ]]);
    }
    return $this->abort();
  }

  public function search() {
    $publicId = DB::$vPublicID;
    $pageTitle = "Szukaj fiszek";
    $sets = null;
    if(isset($_GET['s']) && !empty($_GET['s'])) {
      $pageTitle = "Wyniki wyszukiwania dla \"$_GET[s]\"";
      $sets = DB::select("SELECT id, title, flashcard_count, category FROM study_sets WHERE (visibility = $publicId or created_by = $_SESSION[userId]) and title LIKE :search ORDER BY created_date DESC", ['search' => "%".$_GET['s']."%"])["data"];
    } else {
      $sets = DB::select("SELECT id, title, flashcard_count, category FROM study_sets WHERE (visibility = $publicId or created_by = $_SESSION[userId]) ORDER BY created_date DESC")["data"];
    }
    return $this->view("search.php", ['pageTitle' => $pageTitle, 'web' => ['sets' => $sets, 'search' => $_GET['s'] ?? null]]);
  }
}