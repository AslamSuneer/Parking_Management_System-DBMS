<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin | Vehicle Parking Management System</title>
  
  <?php include('./header.php'); ?>
  <?php include('./db_connect.php'); ?>
  <?php 
  session_start();
  if(isset($_SESSION['login_id']))
      header("location:index.php?page=home");
  ?>
</head>

<style>
  body {
    width: 100%;
    height: 100vh; /* Full viewport height */
    display: flex;
    justify-content: center;
    align-items: center;
    background: black; /* Set background color to black */
  }
  main#main {
    width: 100%;
    max-width: 400px; /* Set max-width for the card */
    background: white; /* Card background color */
    padding: 20px;
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Shadow effect */
    text-align: center; /* Center text */
  }
  .logo {
    display: flex;
    justify-content: center;
    font-size: 8rem; /* Size of the car icon */
    color: #007bff; /* Color of the icon */
  }
  .company-name {
    font-size: 2rem; /* Size of the company name */
    color: #007bff; /* Adjust this color */
    margin: 10px 0; /* Spacing around company name */
  }
  .form-group {
    margin-bottom: 15px; /* Spacing between input fields */
  }
</style>

<body>
  <main id="main">
    <div class="logo"><span class="fa fa-car"></span></div> <!-- Car icon -->
    <div class="company-name">PARKSMART</div> <!-- Company Name -->
    
    <form id="login-form">
      <div class="form-group">
        <label for="username" class="control-label">Username</label>
        <input type="text" id="username" name="username" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="password" class="control-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
      </div>
      <center><button class="btn-sm btn-block btn-wave btn-primary">Login</button></center>
    </form>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

</body>

<script>
  $('#login-form').submit(function(e){
    e.preventDefault()
    $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
    if($(this).find('.alert-danger').length > 0)
      $(this).find('.alert-danger').remove();
    $.ajax({
      url: 'ajax.php?action=login',
      method: 'POST',
      data: $(this).serialize(),
      error: err => {
        console.log(err)
        $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
      },
      success: function(resp){
        if(resp == 1){
          location.href = 'index.php?page=home';
        } else if(resp == 2){
          location.href = 'voting.php';
        } else {
          $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
          $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
        }
      }
    })
  })
</script>
</html>
