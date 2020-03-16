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
}