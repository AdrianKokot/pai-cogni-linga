<?php

require_once (ROOT_DIR.'/app/Controller.php');

class AdminController extends Controller {
  public function users() {
    if(isset($_SESSION['routeOther'][0]) && !empty($_SESSION['routeOther'][0])) {
      return $this->changeStatus($_SESSION['routeOther'][0]);
    }
    return $this->view('users.php', ['pageTitle' => 'Menedżer użytkowników', 'web' => [
        'users' => DB::select("SELECT u.id as 'id', login, score, score_week, s.name as 'status', r.name as 'role' FROM users as u join statuses as s on u.status = s.id join roles as r on u.role = r.id where u.id <> :id", ["id" => $_SESSION["userId"]])["data"]
    ]]);
  }

  private function changeStatus($id) {
    if($id != $_SESSION["userId"]) {
      $dbUser = DB::selectOne("SELECT * FROM users WHERE id = :id", ['id' => $id]);
      if($dbUser["rows"] == 1) {
        $status = $dbUser["data"]["status"];
        switch($status) {
          case 1: $status = 2; break;
          case 2: $status = 1; break;
        }
        DB::update("UPDATE users SET status = :status WHERE id = :id", ['status' => $status, 'id' => $id]);
      }
    }
    return $this->redirectTo(ROOT_URL."/uzytkownicy");
  }

  public function categories() {
    if(isset($_SESSION['routeOther'][0]) && !empty($_SESSION['routeOther'][0]) && $_SESSION['routeOther'][0] == 'nowa') {
      return $this->newCategory();
    }
    if(isset($_SESSION['routeOther'][0]) && !empty($_SESSION['routeOther'][0]) && $_SESSION['routeOther'][0] == 'usun') {
      return $this->deleteCategory($_SESSION['routeOther'][1] ?? null);
    }
    return $this->view('categories.php', ['pageTitle' => 'Menedżer kategorii', 'web' => [
      'categories' => DB::select("SELECT * FROM categories")["data"]
    ]]);
  }

  public function newCategory() {
    return $this->view('newcategory.php', ['pageTitle' => "Dodawanie kategorii"]);
  }

  public function postCategory() {
    if(isset($_SESSION['routeOther'][0]) && !empty($_SESSION['routeOther'][0]) && $_SESSION['routeOther'][0] == 'nowa') {
      Session::setFormData([
        'name' => $_POST['name'] ?? null
      ]);

      if(!((isset($_POST["name"]) && !empty($_POST["name"])) || (isset($_POST["image"]) && !empty($_POST["image"])))) {
        Session::setFlash("Wypełnij wszystkie wymagane pola.");
        return $this->redirectTo(ROOT_URL."/kategorie/nowa");
      }

      $target_dir = ROOT_DIR."/img/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      $check = getimagesize($_FILES["image"]["tmp_name"]);
      if($check == false || $imageFileType != "jpg") {
        Session::setFlash("Plik nie jest zdjęciem w formacie jpg.");
        return $this->redirectTo(ROOT_URL."/kategorie/nowa");
      }
      
      $id = DB::insert("INSERT INTO categories VALUES (null, :name)", ["name" => $_POST["name"]]);
      if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        DB::update("DELETE from categories where id =:id", ["id" => $id]);
        Session::setFlash("Wystąpił błąd podczas wysyłania pliku.");
        return $this->redirectTo(ROOT_URL."/kategorie/nowa");
      } 

      if($id) {
        unset($_SESSION['formData']);
        rename($target_file, $target_dir."$id.jpg");
      } else {
        unlink($target_file);
        Session::setFlash("Wystąpił błąd podczas tworzenia kategorii.");
        return $this->redirectTo(ROOT_URL."/kategorie/nowa");
      }

    }
    return $this->redirectTo(ROOT_URL."/kategorie");
  }

  public function deleteCategory($id) {
    if(Guard::isAdmin()) {
      try {
        $dbQuery = DB::selectOne("SELECT * FROM categories where id = :id", ["id" => $id]);
        if($dbQuery["rows"] == 1){
          if(DB::update("DELETE FROM categories where id = :id", ["id" => $id])){
            $filename = $dbQuery['data']['id'];
            unlink(ROOT_DIR."/img/$filename.jpg");
          }
        }
      } catch(Exception $e) {
        Session::setFlash("Nie można usunąć kategorii ponieważ istnieją zestawy, które do niej należą.");
      } 
    }
    return $this->redirectTo(ROOT_URL."/kategorie");
  }
}