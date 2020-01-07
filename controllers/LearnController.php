<?php

class LearnController extends Controller {
  public function learn() {
    if(count($_SESSION['routeOther']) == 1) {
      $id = $_SESSION['routeOther'][0];
      return $this->view('learn.php', ['pageTitle' => 'Zestaw '.$id]);
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