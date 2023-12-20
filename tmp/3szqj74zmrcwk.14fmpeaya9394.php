<?php echo $this->render('./header.php',NULL,get_defined_vars(),0); ?>
<div class="container">
    <div class="card" style="">
        <img src="/flexapp/Content/logoPlaceholder.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <form action="/flexapp/account/register" method="post">
                <span id="error" class="text-danger"></span>
                <input type="hidden" name="branch_id" value="3123" />
                <div class="mb-3">
                    <label for="InputFname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="InputFname" name="first_name" required="">
                  </div>
                  <div class="mb-3">
                    <label for="InputLname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="InputLname" name="last_name" required="">
                  </div>
                  <div class="mb-3">
                    <label for="InputAdd1" class="form-label">Address Line 1</label>
                    <input type="text" class="form-control" id="InputAdd1" name="address" required="">
                  </div>
   
                  <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" required="">
                  </div>
                  <div class="mb-3">
                    <label for="state" class="form-label">State</label>
                    <input type="text" class="form-control" id="state" name="state" required="">
                  </div>
                  <div class="mb-3">
                    <label for="zip" class="form-label">Zip Code</label>
                    <input type="text" class="form-control" id="zip" name="zip" required="">
                  </div>
                  <div class="mb-3">
                    <label for="cell" class="form-label">Cell Phone</label>
                    <input type="text" class="form-control" id="cell" name="cell_phone" required="">
                  </div>
                <div class="mb-3">
                  <label for="InputEmail" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" name="email" required="">
                  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword" class="form-label">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword" aria-describedby="passwordHelp" name="password" required="">
                  <div id="passwordHelp" class="form-text"></div>

                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" aria-describedby="passwordHelp" name="confirmpassword" required="">  
                  </div>
                <div class="mb-3 form-check">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
        </div>
      </div>





</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<?php echo $this->render('./footer.php',NULL,get_defined_vars(),0); ?>