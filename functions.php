<?php
/* se connecter a la base de donnees */
function connectToDb($pass,$database)
{
  return mysqli_connect('localhost','root', $pass , $database);
};
/*se deconnecter  */
function disconnecToDb($db)
{
  return mysqli_close($db);
};
/*faire le requete de selection*/
function selectDataIntoDb($sql_request , $db)
{
  return mysqli_query($db , $sql_request );
};
function displayErrors()
{
  ini_set('display_errors',1);
  ini_set('display_stratup_errors',1);
  /*afficher le type de l'erreur*/
  error_reporting(E_ALL);
}

/*chercher un champ ds la bd*/
function searchAllByCriteria($db, $criteria, $search)
{

  $request="SELECT game.name game_name, game.year game_year,
   game.note game_note, category.content category_name, editor.name editor_name
   FROM game , category, game_editor, editor
   WHERE game.id_category = category.id
   AND game.id = game_editor.id_game
   And editor.id = game_editor.id_editor
   AND  $criteria= $search
   ORDER BY game.name ASC ; ";
   return mysqli_query($db,$request);
}
