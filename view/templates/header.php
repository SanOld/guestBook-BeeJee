<header class="top-head container-fluid">
  <div class="container">
    <div class="logo p-0 m-t-10 m-b-10 col-xs-6">
      <a href="#" target="_self">
        <img src="web/images/avatar.jpg" alt="logo">ЛОГОТИП
      </a>
    </div>
    <ul class="list-inline navbar-right top-menu top-right-menu profile-box">
      <!-- user login dropdown start-->
      <li class="dropdown text-center">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <img class="img-circle profile-img thumb-sm" src="web/images/avatar.jpg" alt="">
          <div class="holder-box">
            <span class="username">
                <?php echo $this->user['login'] != '' ? $this->user['login']  : 'guest'; ?>
            </span>
          </div>
          <span class="caret"></span>
        </a>
        <ul style="overflow: hidden; outline: none;" tabindex="5003" class="dropdown-menu extended pro-menu fadeInUp animated">
          <?php if($this->user['login'] != ''){ ?>
            <li><a href="index.php?cr=auth&action=logout"><i class="fa fa-sign-out"></i>Выйти</a></li>
          <?php } else { ?>
            <li><a href="index.php?cr=auth&action=showLoginForm"><i class="fa fa-sign-out"></i>Войти</a></li>
          <?php }  ?>

        </ul>
      </li>
      <!-- user login dropdown end -->
    </ul>
  </div>
</header>