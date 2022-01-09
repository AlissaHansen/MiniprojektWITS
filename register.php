<?php
session_start(); // Starter session. 
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
    <title>Registering</title>
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
        <h1 class="login-header">Opret bruger</h1>
        <form action="" method = "POST"> <!-- Registerings form. -->
            <div class="mb-3">
                <label for="firstname" class="form-label">Fornavn</label>
                <input type="text" class="form-control" id="firstname" name="fornavn" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Efternavn</label>
                <input type="text" class="form-control" id="lastname" name="efternavn" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Brugernavn</label>
                <input type="text" class="form-control" id="username" name="brugernavn" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Adgangskode</label>
                <input type="password" class="form-control" id="password" name="adgangskode" required>
            </div>
            <div class="signup-knap">
                <button type="submit" name="submit" class="btn btn-primary">Opret bruger</button>
            </div>    
    </form>
    <div class="opret-bruger">
       <span> Har du allerede en bruger?</span> 
       <a class="btn btn-outline-secondary" href = "login.php">Login</a>
    </div>
       
    </div>
    
<?php
require_once '/home/mir/lib/db.php';
    if (isset($_POST['submit'])) {
        $brugernavn = $_POST['brugernavn'];
        $fornavn = $_POST['fornavn'];
        $efternavn = $_POST['efternavn'];
        $adgangskode = $_POST['adgangskode'];
        add_user($brugernavn, $fornavn, $efternavn, $adgangskode); // Tilføj en bruger med følgende værdier. 
        $_SESSION['user'] = $_POST['brugernavn']; // Sætter session 'user' til brugerens 'brugernavn'.
        header('Location:index.php');
    }

    

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    
</body>
</html>