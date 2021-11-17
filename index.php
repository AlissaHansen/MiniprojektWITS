<?php session_start(); // Starter session. 
require_once '/home/mir/lib/db.php';
?>

<!DOCTYPE html>
<html lang="da">
<head>
    <link rel="stylesheet" href="stylesheet.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alexsa Forum</title>
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

    <h1 class="headline-content">« Alexsa Forum »</h1>
    <div class=section-div>
        <h2 class="section-header">Seneste indlæg</h2>
        
    </div>
    


<?php
    $allPIDS = get_pids(); //Array af alle post ids.
    end($allPIDS); //Sætter pointer på sidste element.

    
    for ($x = 0; $x <= 20; $x++) {
        $currentPost = get_post(current($allPIDS));
        $currentAuthor = htmlspecialchars($currentPost['uid']);
        $postID = $currentPost['pid'];
        $postURL = 'indlæg.php?pid='.$postID;
        echo "<div class='post-container'>";
        echo "<div class='card' style='width: 18 rem;''>";
            echo "<div class='card-header'>";
                echo "<span class='post-title'>Titel: </span>";
                echo htmlspecialchars (($currentPost['title']));
                echo "<span class='author-name'>af: "; 
                echo $currentAuthor; 
                echo "</span>";

            echo "</div>";
                echo "<ul class='list-group list-group-flush'>";
                    echo "<li class='list-group-item'>";
                    echo htmlspecialchars (($currentPost['content']));
                    echo "</li>";
                echo "</ul>";
                echo "<a href='$postURL' class='stretched-link'></a>";
        echo "</div>";
        echo "</div>";
        prev($allPIDS);
    }
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>