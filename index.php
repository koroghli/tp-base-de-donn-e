<?php
/*cherger le fichier php ds le contenu courant une seule fois*/
include_once('functions.php');
 /*verifier les erreurs et les afficher*/
displayErrors();
/*se connecter avec la fonction connectToDb*/
$db = connectToDb('0000','video_game');

/*faire le requete de selection 'category'*/
$category_result=selectDataIntoDb("SELECT * FROM  category",$db);

/*faire le requete de selection 'editor'*/
$editor_result = selectDataIntoDb ("SELECT * FROM editor ",$db);

/*le requete pour afficher toutes les elements */
$request="SELECT game.name game_name, game.year game_year,
 game.note game_note, category.content category_name, editor.name editor_name
 FROM game , category, game_editor, editor
 WHERE game.id_category = category.id
 AND game.id = game_editor.id_game
 And editor.id = game_editor.id_editor ;";
$getAllGames= selectDataIntoDb($request,$db);

 /*fermer la connexion*/
 disconnecToDb($db);
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="container">
<!--le titre-->
      <div class="row" id="ligne">
<div class="col-sm-10">
  <h1>Bienvenu sur cette base de données</h1>
</div>2
      </div>
<!--le 1 er formulaire-->
<div class="row" id="ligne1">

  <div class="col-sm-10">
    <h2>Veuillez creer votre jeu !</h2>
         <form  action="insert.php" method="post">
           <select name="category_select" class="btn btn-default">
             <?php
              while ($data = mysqli_fetch_assoc($category_result))
              {
               echo "<option value='" . $data['id'] . "'>" . $data['content'] . "</option>";/*afficher les elements*/
              }
           ?>
        </select >
        <select name="editor_select" class="btn btn-default">
          <?php
           while ($data = mysqli_fetch_assoc($editor_result))
           {
            echo "<option value='" . $data['id'] . "'>" . ucfirst($data['name']) . "</option>";/*afficher les elements*/
           }
        ?>
     </select>
      <input type="text" name="game_name" class="btn btn-default" placeholder="Nom du jeu">
       <input id="annee" type="number" name="game_year" min="1950" max="3000" class="btn btn-default" placeholder="Année de sortie">
        <input type="number" name="game_note" min="0" max="100" class="btn btn-default" placeholder="Note">
         <input type="submit" class="btn btn-default" value="Créer"style="background-color:#4a8297;border-color:#4a8297;color:white;">
         </form>
  </div>
</div>
<!--le tableau-->
<div class="row" id="ligne2">
  <div class="col-sm-8">
    <h2> Voila le resultat de votre insertion</h2>
    <table >
     <tr >
       <th >Nom du jeu</th>
       <th>Année de sortie</th>
       <th>Note</th>
       <th>Categorie</th>
       <th>Editeur</th>
     </tr>

     <?php
      while($data = mysqli_fetch_assoc($getAllGames))
      {
        $return = '<tr>';
        $return .= '<td>' . ucfirst($data['game_name']) . '</td>';
        $return .= '<td>' . $data['game_year'] . '</td>';
        $return .= '<td>' . $data['game_note'] . '</td>';
        $return .= '<td>' . $data['category_name'] . '</td>';
        $return .= '<td>' . ucfirst($data['editor_name']) . '</td>';
        $return .= '</tr>';
        echo $return ;
      };
      ?>
    </table>
  </div>
</div>
<!--le 2 eme formulaire-->
<div class="row" id="ligne3">
  <div class="col-sm-8">
    <h3>Veuillez faire votre recherche !</h3>
    <form action="search.php" method="post" id="chercher">
      <select name="search_select" class="btn btn-default">
        <option value="game_name">Nom du jeu</option>
        <option value="game_year">Annees de sortie</option>
        <option value="game_note">Note du jeu</option>
        <option value="game_editor">Editeur du jeu</option>
        <option value="game_category">Categorie du jeu</option>
        </select>
  <input type="text" name="search_data" class="btn btn-default" >
  <input type="submit" value="Search" class="btn btn-default"style="background-color:#4a8297;border-color:#4a8297;color:white;">

  </form>
  </div>
</div >
<div class="row" id="ligne4">
  <div class="col-sm-8">
    <h3>Voila le resultat de votre recherche</h3>

  <?php
  session_start();
  if (isset($_SESSION['searchResult']))
   {
    echo $_SESSION['searchResult'];
  unset( $_SESSION['searchResult']);
};
   ?>
   </div>
</div>

    </div>
  </body>
</html>
