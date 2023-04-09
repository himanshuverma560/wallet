

   <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="#">Hi, 
     <?php
          if ($this->session->userdata('user')) {
            echo $this->session->userdata('user')->name;
          }
      ?>
    </a>

    <!-- Links -->
    <ul class="navbar-nav">
      <?php 
      if ($this->session->userdata('user')) {
        ?>
        <li class="nav-item">
        <a class="nav-link" href="<?=  site_url().'/Auth/logout'; ?>">Logout</a>
      </li>

      <?php 
      } ?>
      
     
    </ul>
  </nav>

