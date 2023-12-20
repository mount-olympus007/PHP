<?php echo $this->render('./header.php',NULL,get_defined_vars(),0); ?>
<div class="container">
    <div class="card" style="">
        <img src="/flexapp/Content/logoPlaceholder.jpg" class="card-img-top" alt="...">
        Access Your Account
        <div class="card-body">
            <form action="/flexapp/account/login" method="post">
                <div class="mb-3">
                  <label for="InputEmail" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" name="email" required="">
                  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword" class="form-label">Password</label>
                  <input type="password" class="form-control" id="InputPassword" aria-describedby="passwordHelp" name="password" required="">
                  <div id="passwordHelp" class="form-text"></div>

                </div>
                <div class="mb-3 form-check">
                  <input aria-describedby="reg" type="checkbox" class="form-check-input" id="exampleCheck1" name="rememberMe" />
                  <label class="form-check-label" for="exampleCheck1">Remember Me?</label>
                </div>
                <a href="#" onclick="submitLogForm()" class="btn btn-primary">Sign In</a>
              </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <a href="/flexapp/account/register">Create An Account</a>
        </div>
        <div class="col-md-6">
          <a href="/flexapp/account/forgotpassword">Forgot Password?</a>
        </div>
      </div>





</div>
<script>
  function submitLogForm(){
    let signInButton = document.getElementById('signInButton');
    let email = document.getElementById('InputEmail').value;
    let password = document.getElementById('InputPassword').value;
    var url = "/flexapp/account/onpostlogin?email="+email+"&password="+password;
    window.location.href = url;
  }
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<?php echo $this->render('./footer.php',NULL,get_defined_vars(),0); ?>