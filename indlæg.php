<?php session_start(); // Starter session. 
require_once '/home/mir/lib/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="stylesheet.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indlæg</title>
</head>
<body>
    <!--NavBar-->
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

    <?php // Tjekker om det er sat et postID
        if (empty($_GET['pid'])){
            echo "Fejl: pid er ikke sat";
            exit;
        }
        // Tjekker om det et tal. 
        if (!is_numeric($_GET['pid'])){
            echo "Fejl: pid skal være et tal";
            exit;
        }

        $pidInput = $_GET['pid']; // Gemmer pid. 
        $post = get_post($pidInput);
        $titel = htmlspecialchars($post['title']);
        

        $userID = htmlspecialchars($post['uid']); // Fjerner mulighed for HTML injection.
        $url = 'userSide.php?uid='. $userID; // URL til en brugers side.
        $indhold = htmlspecialchars($post['content']);

        echo "<h2 class= 'section-header'>";
        echo "<span class='span-title'> Titel: </span>"; 
        echo "<span>$titel</span>"; 
        echo "</h2>"; 
        echo "<div class='post-outer-div'>";
        echo "<article> $indhold </article>"; 

    // Henter og viser billeder, hvis de findes til et indlæg. 
        $imageID = get_iids_by_pid($pidInput); 
        if (!empty($imageID)) {
            echo "<div class='image-container'>"; 
            foreach ($imageID as $iid) {
                $imageINFO = get_image($iid);
                $imagePATH = $imageINFO['path'];
                echo "<div>"; 
                echo "<img src='$imagePATH' witdh='200' height='200'>"; // Vi viser billedet i 200x200px. 
                echo "</div>";     
            }
            echo "</div>";
        }

        echo "<address class='author'>Af "; 
        echo "<a rel='author' href='$url'>";
        echo htmlspecialchars ($userID);
        echo "</a>";
        echo "</address>";
        echo "</div>";

        // Modal knapper div 
        echo"<div class='modal-div'>"; 
        //Tilføj kommentar modal 
        if (!empty($_SESSION['user'])) { // Modal findes kun, hvis brugeren er logget ind.
            echo "<button type='button' class='btn btn-light btn-sm modal-button' data-bs-toggle='modal' data-bs-target='#modalForm'>";
            echo 'Tilføj kommentar';
            echo "</button>";
        } else { // Ellers besked om at brugeren skal logge ind. 
            echo "<p class='info-paragraph'>For at kommentere på indlægget, skal du være <a href='login.php'>logget ind.</a></p>";
        }

        // Rediger & slet indlæg modal
        if (strtolower($_SESSION['user']) == strtolower($userID)) {
            echo "<button type='button' class='btn btn-light btn-sm modal-button' data-bs-toggle='modal' data-bs-target='#modalEdit'>";
            echo 'Rediger indlæg';
            echo "</button>";
            echo "<button type='button' class='btn btn-danger btn-sm modal-button' data-bs-toggle='modal' data-bs-target='#modalDelete'>";
            echo 'Slet indlæg';
            echo "</button>";
        }
        echo "</div>"; //Modal knapper div-luk.

       // Pop-up Modal rediger indlæg
        echo "<div class='modal fade' id='modalEdit' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
        echo "<div class='modal-dialog'>";
        echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
                echo "<h5 class='modal-title' id='exampleModalLabel'>Rediger indlæg</h5>";
                echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
            echo "</div>";
            echo "<div class='modal-body'>";
                echo "<form action='' method='post'>";
                echo "<div class='mb-3'>";
                        echo "<label for='newTitle' class='form-label'>Titel</label>";
                        echo "<input type='text' class='form-control' id='newTitle' name='newTitle' value= '$titel' />";
                    echo "</div>";
                    echo "<div class='mb-3'>";
                        echo "<textarea id='newContent' name='newContent' rows='5' cols='45'>";
                        echo $indhold;
                        echo "</textarea>";
                    echo "</div>";
                    echo "<div class='modal-footer d-block'>";
                        echo "<button type='submit' name='submitEditedPost' class='btn btn-dark float-end'>Rediger</button>";
                    echo "</div>";
                echo "</form>";
            echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

if (isset($_POST['submitEditedPost'])) { // Hvis bruger trykker submit: rediger indlæg.
    modify_post($pidInput, $_POST['newTitle'], $_POST['newContent']);
    header("Refresh:0"); //refresher siden så indlægget er opdateret
}
         // Pop-up Modal SLET indlæg
         echo "<div class='modal fade' id='modalDelete' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
         echo "<div class='modal-dialog'>";
         echo "<div class='modal-content'>";
             echo "<div class='modal-header'>";
                 echo "<h5 class='modal-title' id='exampleModalLabel'>Slet indlæg</h5>";
                 echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
             echo "</div>";
             echo "<div class='modal-body'>";
                echo "<p>";
                echo "Er du sikker på, at du vil slette dit indlæg?";
                echo "</p>";
                 echo "<form action='' method='post'>";
                     echo "<div class='modal-footer d-block'>";
                         echo "<button type='submit' name='submitDelete' class='btn btn-danger float-end'>Slet</button>";
                     echo "</div>";
                 echo "</form>";
             echo "</div>";
         echo "</div>";
         echo "</div>";
         echo "</div>";

         if (isset($_POST['submitDelete'])) {
            // Indsæt kode til at slette post. Funktion findes ikke i Mortens API. 
         }


       // Pop-up Modal tilføj kommentar. 
        echo "<div class='modal fade' id='modalForm' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
        echo "<div class='modal-dialog'>";
        echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
                echo "<h5 class='modal-title' id='exampleModalLabel'>Tilføj kommentar</h5>";
                echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
            echo "</div>";
            echo "<div class='modal-body'>";
                echo "<form action='' method='post'>";
                    echo "<div class='mb-3'>";
                        echo "<textarea id='comment' name='comment' rows='5' cols='45'></textarea>";
                    echo "</div>";
                    echo "<div class='modal-footer d-block'>";
                        echo "<button type='submit' name='submit' class='btn btn-dark float-end'>Tilføj</button>";
                    echo "</div>";
                echo "</form>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
echo "</div>";

if (isset($_POST['submit'])) { // Hvis brugeren trykker submit: tilføjes kommentar. 
    add_comment($_SESSION['user'], $pidInput, $_POST['comment']);

}
        $cidsForPost = get_cids_by_pid($pidInput); // Henter kommentarers ID's, for dette indlæg. 
        echo "<h3 class='comment-headline'>Kommentarer</h3>";
        
        if (!empty($cidsForPost)) { // Hvis der findes kommentarer
            echo "<div class = 'comment-section'>";
            foreach ($cidsForPost as $cids) { // Løber igennem alle kommentars ID's. 
                echo "<div class='comment'>";
                $commentINFO = get_comment($cids);
                $uidFromComment = $commentINFO['uid'];
                $url = 'userSide.php?uid='. $uidFromComment;
                echo "<div>";

                // Tjekker om brugeren er forfatteren af kommentar eller indlæg,
                // vi bruger strtolower da brugernavn ikke afhænger af store/små bogstaver.  
                if (strtolower(($_SESSION['user']) == strtolower($uidFromComment)) or strtolower($_SESSION['user']) == strtolower($userID)) {
                    $cidURL = 'deleteComment.php?cid='.$cids.'&pid='.$pidInput;
                    echo "<a href='$cidURL'><button type='button' class='btn btn-light btn-sm dl-comment-button'>Slet</button></a>";

                }
                echo "<a href='$url'>$uidFromComment</a>";
                echo ': '. $commentINFO['content'];
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        }
        
    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>