<?php
//appel du fichier function.php
require_once('functions.php');
// connexion a la bd
$db = connectToDb('0000','video_game');

/*switch pour passer sur touts les champ*/
$criteria='';
switch ($_POST['search_select']) {
  case 'game_name':
   $criteria = 'game.name';
   $search = '\''  .  $_POST['search_data'] . '\'' ;
    break;

  case 'game_year':
   $criteria='game.year';
   $search=$_POST['search_data'] ;
   break;

  case ' game_note':
    $criteria='game.note';
     $search=$_POST['search_data'] ;
   break;

  case 'game_editor':
    $criteria='editor.name';
     $search = '\''  .  $_POST['search_data'] . '\'' ;
   break;

  case 'game_category':
    $criteria='category.content';
     $search = '\''  .  $_POST['search_data'] . '\'' ;
   break;

   default:
   session_start();
   $_SESSION['error message']='Critere de recherche tout pourri';
   header("Location:index.php");

};

/*s'assurer que la variable n est pas vide*/
if ($criteria != '') {
  $result=searchAllByCriteria($db,$criteria,$search);

  $htmlString= '';
  $htmlString.='<table>';
  $htmlString.= '<tr>';
  $htmlString.= '<td>' . "Nom du jeu" . '</td>';
  $htmlString.= '<td>' . "Année de sortie" . '</td>';
  $htmlString.= '<td>' . "note" . '</td>';
  $htmlString.= '<td>' . "categorie" . '</td>';
  $htmlString.= '<td>' . "Editeur" . '</td>';
  $htmlString.= '</tr>';
  while ($data = mysqli_fetch_assoc($result) )
  {
    $htmlString.= '<tr>';
    $htmlString.= '<td>' . $data['game_name'] . '</td>';
    $htmlString.= '<td>' . $data['game_year'] . '</td>';
    $htmlString.= '<td>' . $data['game_note'] . '</td>';
    $htmlString.= '<td>' . $data['editor_name'] . '</td>';
    $htmlString.= '<td>' . $data['category_name'] . '</td>';
    $htmlString.= '</tr>';
  };
    $htmlString.='</table>';
    session_start();
   $_SESSION['searchResult'] = $htmlString;
   header("Location:index.php");

}

else{
  session_start();
  $_SESSION ['error message'] ='Erreur lors de la recherche';
  header("Location:index.php");
}
/*excuter la requte*/
