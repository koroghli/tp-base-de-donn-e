<?php
/* tester si le contenu est vide ou non */
$validate= true;
if ($_POST['game_name'] == '' && $_POST['game_year'] == '' && $_POST['game_note'] == '') {
  $validate=false;
}


/*se conncter a la base de donnees*/
$db = mysqli_connect('localhost','root','0000','video_game');

$search_sql = "SELECT * FROM game WHERE name='" . strtolower($_POST['game_name']) . "'";
$search_result = mysqli_query($db, $search_sql);

/*verifier si la requete a un contenu avec la methode "mysqli_num_rows"*/
if (mysqli_num_rows($search_result) !== 0)
{
  session_start();
  $_SESSION['error_message']="jeu deja existant";
  header("Location: index.php");
  //si le jeu existe
}else
 {
//si le jeu n'existe pas
//on cree le jeu
$insert_sql = "INSERT INTO game (year ,name , note , id_category)
VALUES(
  '" . $_POST['game_year'] ."' ,
  '" . $_POST['game_name'] . "',
  '" . $_POST['game_note'] . "',
  '" . $_POST['category_select'] . "'
  )";
  if ($validate == true) {
  $insert_result = mysqli_query($db, $insert_sql);
}else {
  session_start();
  $_SESSION['success_message'] = "Vous deverz indiquer un nom pour le jeu";
  header("Location: index.php");exit;
}

if ($insert_result == true){
  $insert_intermediary_sql = "INSERT INTO game_editor (id_game, id_editor)
       VALUES(
         '" . mysqli_insert_id($db). "',
         '" . $_POST['editor_select'] . "'
         )";
         mysqli_query($db, $insert_intermediary_sql);
  session_start();
  $_SESSION['success_message'] = "Insertion du jeu " . $_POST['game_name'] . " effectuée";
  header("Location: index.php");
}else
  {
  session_start();
  $_SESSION['error_message']="Erreur lors de l\'insertion";
  header("Location: index.php");
  }
}


mysqli_close($db);
