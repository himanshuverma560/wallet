<?php $this->load->view('head'); ?>
<?php $this->load->view('nav'); ?>
<div class="container">
   <div class="row">
      <div class="col-md-6">
         <div class="card" style="margin-top:100px">
            <div class="card-header">Signup</div>
            <div class="card-body">
              <form id="mySignupForm" method="post">
               <div class="form-group">
                  <label for="email">Name:</label>
                  <input type="name" class="form-control" id="name">
                  <span id="name-error" style="color:red"></span>
               </div>
               <div class="form-group">
                  <label for="email">Email address:</label>
                  <input type="email" class="form-control" id="email">
                  <span id="email-error" style="color:red"></span>
               </div>
               <div class="form-group">
                  <label for="pwd">Password:</label>
                  <input type="password" class="form-control" id="password">
                  <span id="password-error" style="color:red"></span>
               </div>
               <button type="submit" class="btn btn-dark" id="signup">Submit</button>
               &nbsp;<span id="message"></span>
               </form>
            </div>
         </div>
      </div>
   
   <div class="col-md-6">
      <div class="card" style="margin-top:100px">
         <div class="card-header">Login</div>
         <div class="card-body">
          <form id="myLoginForm">
            <div class="form-group">
               <label for="email">Email address:</label>
               <input type="email" class="form-control" id="login-email">
               <span id="login-email-error" style="color:red"></span>
            </div>
            <div class="form-group">
               <label for="pwd">Password:</label>
               <input type="password" class="form-control" id="login-password">
               <span id="login-password-error" style="color:red"></span>
            </div>
            <button type="submit" class="btn btn-dark">Login</button>
            &nbsp;<span id="loginMessage"></span>
         </div>
         </form>
      </div>
   </div>
</div>
</div>
<?php $this->load->view('footer'); ?>