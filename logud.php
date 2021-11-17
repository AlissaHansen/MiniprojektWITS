<?php
session_start(); // Starter session. 
session_destroy(); // Session ødelægges, hvis brugeren logger ud. 
header('Location:index.php'); // Brugeren sendes tilbage til login side.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>