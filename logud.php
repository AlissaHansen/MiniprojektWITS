<?php
session_start(); // Starter session. 
session_destroy(); // Session ødelægges, hvis brugeren logger ud. 
header('Location:index.php'); // Brugeren sendes tilbage til login side.
?>