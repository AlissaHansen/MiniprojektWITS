<?php 
session_start(); // Gør at vi har adgang til session. 
require_once '/home/mir/lib/db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css"> <!-- Importerer css til style -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brugers side</title> <!-- Ændret fra 'min side' efter aflevering -->
</head>
<body>
     <header class="nav-header">
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Hjem</a></li>
                <li><a href="alleIndlæg.php">Alle indlæg</a></li>
                <?php
                if (!empty($_SESSION['user'])) {
                    echo "<li><a href='minSide.php'>Min side</a></li>";
                    echo "<li><a href='logud.php'>Log ud</a></li>";
                } else {
                    echo "<li><a href='login.php'>Login</a></li>";
                    echo "<li><a href='register.php'>Opret bruger</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
    <?php
    
    $userID = $_GET['uid'];
    $pids = get_pids_by_uid($userID);

    echo "<h1 class='main-header'>";
    echo "<span>Siden tilhører: </span>";
    echo "<span class='brugernavn-farve'>";
    echo $userID;
    echo "</span>";
    echo "</h1>";


    foreach ($pids as $pid) { // Gennemgår alle postID's som brugeren har oprettet. 
        $currentPost = get_post($pid);
        $currentAuthor = htmlspecialchars($currentPost['uid']);
        $date = $currentPost['date'];
        $postURL = 'indlæg.php?pid='.$pid;
        echo "<div class='post-container'>";
        echo "<div class='card' style='width: 18 rem;''>";
            echo "<div class='card-header'>";
                echo "<span class='post-title'>Titel: </span>";
                echo htmlspecialchars (($currentPost['title']));
                echo "<span class='author-name'>af: $currentAuthor</span>";
                echo "<span class='author-name'>$date</span>";

            echo "</div>";
                echo "<ul class='list-group list-group-flush'>";
                    echo "<li class='list-group-item'>";
                    echo htmlspecialchars (($currentPost['content']));
                    echo "</li>";
                echo "</ul>";
                echo "<a href='$postURL' class='stretched-link'></a>";
        echo "</div>";
        echo "</div>";

    }
    

    

    if (isset($_POST['submit'])){
        session_destroy(); // Session ødelægges, hvis brugeren logger ud. 
        header('Location:index.php'); // Brugeren sendes tilbage til login side. 
    }
    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    
</body>
</html>

