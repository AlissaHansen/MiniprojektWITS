<?php 
session_start();
require_once '/home/mir/lib/db.php'; 
if (!empty($_SESSION['user'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css"> <!-- Importerer css til style -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
</head>
<body>
<header class="nav-header">
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Hjem</a></li>
                <li><a href="alleIndlæg.php">Alle indlæg</a></li>
                <li><a href='login.php'>Login</a></li>
                <li><a href='register.php'>Opret bruger</a></li>
            </ul>
        </nav>
    </header>
    <div class="login-div"> <!--div der indeholder form-->
        <h1 class="login-header">Login</h1>
        <form method="POST" action="">
            <div class="mb-3"> <!--Bootstrap form-->
                <label for="userID"  class="form-label">Brugernavn</label>
                <input type="text" class="form-control" id="userID" name="uid" placeholder="Skriv brugernavn" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Adgangskode</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Skriv adgangskode" required>
            </div>
            <div class="login-knap">
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
        <p class="ErrorMessage">Brugernavn eller adgangskode er ikke korrekt. </p>
       
        <div class="opret-bruger">
           <span> Har du ikke en bruger?</span> 
           <a class="btn btn-outline-secondary" href = "register.php">Sign up</a>
    </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<?php
    if (isset($_POST['submit'])) { //Tjekker når der bliver trykket login, om det matcher. 
        if (login($_POST['uid'], $_POST['password'])) {
            $_SESSION['user'] = $_POST['uid'];
            header('index.php'); // Sender brugeren til startside/hjem. 
            exit;
        }
    }

?>