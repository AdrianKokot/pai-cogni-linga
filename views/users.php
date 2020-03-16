<?php
  require_once ROOT_DIR.'/layout/app-nav.php';
?>
<section>
  <section id="app-panel">
    <article>
      <section>
        <h2>Menedżer użytkowników</h2>
        <section class="recent">
          <?php
            foreach($web["users"] as $user){
              $status = $user["status"];
              $color1 = "good";
              $color2 = "good";
              switch($status) {
                case 'active': $status ="aktywny"; break;
                case 'deleted': $status ="niekatywny"; $color1 = "wrong"; break;
              }
              $role = $user["role"];
              switch($role) {
                case 'admin': $role ="administrator";$color2 = "wrong"; break;
                case 'user': $role ="użytkownik"; break;
                case 'teacher': $role ="nauczyciel";$color2 = "wrong"; break;
              }
          ?>
          <div class="flash-prev" style="justify-content: space-between;cursor:default">
            <div class="flash-description">
              <h3><?= $user["login"] ?></h3>
              <p>
                <span class="flash-count">Status użytkownika: <em class="<?= $color1 ?>"><?= $status?></em></span>
              </p>
              <p>
                <span class="flash-count">Rola użytkownika: <em class="<?= $color2 ?>"><?= $role?></em></span>
              </p>
            </div>
            <?php 
              if($user["status"] == 'active'){
                ?>
            <a class="flash-img" style="text-align:center;line-height:80px;width:30px; cursor:pointer" title="Deaktywuj użytkownika" href="<?= ROOT_URL ?>/uzytkownicy/<?= $user['id'] ?>">
              <i class="fas fa-user-times"></i>
            </a>
                <?php
              } else {
                ?>
            <a class="flash-img" style="text-align:center;line-height:80px;width:30px; cursor:pointer" title="Aktywuj użytkownika" href="<?= ROOT_URL ?>/uzytkownicy/<?= $user['id'] ?>">
              <i class="fas fa-user-check"></i>
            </a>
                <?php
              }
            ?>
            
          </div>
          <?php
            }
          ?>
        </section>
      </section>
    </article>
  </section>
</section>

<script src="<?= ROOT_URL ?>/js/navigation.js"></script>