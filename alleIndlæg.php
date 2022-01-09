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
    <h2 class="section-header">Alle indlæg</h2>

<?php

    // Button to Open the Modal, hvis man er logget ind. 
    if (!empty ($_SESSION['user'])) {
        echo "<button type='button' class='btn btn-secondary mx-auto mt-5 d-block' data-bs-toggle='modal' data-bs-target='#createPostModal'>";
        echo 'Opret indlæg';
        echo "</button>";
    } else {
        echo "<p class='info-paragraph'>For at oprette et indlæg, skal du være <a href='login.php'>logget ind.</a></p>";
    }

   // Pop-up Modal: Opret et indlæg:
   echo "<div class='modal fade' id='createPostModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
   echo "<div class='modal-dialog'>";
   echo "<div class='modal-content'>";
       echo "<div class='modal-header'>";
           echo "<h5 class='modal-title' id='exampleModalLabel'>Opret indlæg</h5>";
           echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
       echo "</div>";
       echo "<div class='modal-body'>";
           echo "<form action='' method='post' enctype='multipart/form-data'>";
           echo "<div class='mb-3'>";
                   echo "<label for='title' class='form-label'>Titel</label>";
                   echo "<input type='text' class='form-control' id='title' name='title' placeholder='Skriv en titel'/>";
               echo "</div>";
               echo "<div class='mb-3'>";
                echo "<label for='content' class='form-label'>Indhold</label>";
                   echo "<textarea id='content' name='content' rows='5' cols='45' placeholder='Skriv indhold her'>";
                   echo "</textarea>";
               echo "</div>";
               echo "<div class='mb-3'>";
                    echo "<input type ='file' name = 'picture' id = 'picture'>";
               echo "</div>";
               echo "<div class='modal-footer d-block'>";
                   echo "<button type='submit' name='submitPost' class='btn btn-dark float-end'>Opret</button>";
               echo "</div>";
           echo "</form>";
       echo "</div>";
   echo "</div>";
   echo "</div>";
   echo "</div>";

    if (isset($_POST['submitPost'])) { // Hvis brugeren trykker opret indlæg
        $addedPID = add_post ($_SESSION['user'], $_POST['title'], $_POST['content']); 
        header("Refresh:0"); //refresher siden så indlægget er opdateret
        if (!empty($_FILES['picture'])) { // Tjekker om brugeren vil oploade et bilede med. 
            if($_FILES['picture']['type'] == "image/png") $type = ".png";
            if ($_FILES['picture']['type'] == "image/jpeg") $type = ".jpg";
            if ($_FILES['picture']['type'] == "image/gif") $type = ".gif";

            $iid = add_image($_FILES['picture']['tmp_name'], $type); // Gemmer ID for billedet
            add_attachment($addedPID, $iid);  
        }
            }
    

    $allPIDS = get_pids(); //Array af alle post ids.
    end($allPIDS); //Sætter pointer på sidste element.
    for ($x = 0; $x < count($allPIDS); $x++) { //Looper igennem alle indlæg.
        $currentPost = get_post(current($allPIDS));
        $currentAuthor = htmlspecialchars($currentPost['uid']);
        $postID = $currentPost['pid'];
        $date = $currentPost['date']; 
        $postURL = 'indlæg.php?pid='.$postID;
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
                echo "<a href='$postURL' class='stretched-link'></a>"; // Link virker på hele div. 
        echo "</div>";
        echo "</div>";
        prev($allPIDS);
    }
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>