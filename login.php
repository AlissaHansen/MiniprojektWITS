<?php session_start(); // Starter session. 
require_once '/home/mir/lib/db.php'; // Kontakter database. 
if (!empty($_SESSION['user'])) // Hvis brugeren allerede har en session, så log direkte ind. 
{
    header('Location:minSide.php'); // Brugeren bliver sendt direkte til ny side. 
    exit;
}
if (isset($_POST['submit'])) {
    if (login($_POST['uid'], $_POST['password'])) // Tjekker om uid & password matcher en bruger. 
    {
        $_SESSION['user'] = $_POST['uid']; // Sætter session 'user' til brugerens 'uid'.
        header('Location:index.php');
        exit;
    }
    else {
        header('Location:loginFejl.php'); // Sendes til fejl side.
    }
}
// Nedenfor bruges heredoc til at skrive HTML direkte i PHP. Vi laver en form & styler med bootstrap og CSS. 

echo <<<END
<!DOCTYPE html>
<html lang="en">
<head>
    <!--Bootstrap CSS-->
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
    <div class="login-div">
        <h1 class="login-header">Login</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="userID"  class="form-label">Brugernavn</label>
                <input type="text" class="form-control" id="userID" name="uid" placeholder="Skriv brugernavn" required>
            </div>
            <div>
                <label for="password" class="form-label">Adgangskode</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Skriv adgangskode" required>
            </div>
            <div class="login-knap">
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
        <div class="opret-bruger">
           <span> Har du ikke en bruger?</span> 
           <a class="btn btn-outline-secondary" href = "register.php">Sign up</a>
        </div>
    </div> 

    <!--Bootstrap Bundle-->    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
END
?>
