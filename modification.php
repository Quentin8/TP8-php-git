<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
                <a class="nav-link" href="citation.php">Informations <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="recherche.php">Recherche <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="modification.php">Modification <span class="sr-only">(current)</span></a>
            </li>

        </ul>
    </div>
</nav>
<?php
    include "connexpdo.php";
    try{
        $conn = connexpdo('pgsql:dbname=citations;host=localhost;port=5432','postgres','new_password');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $except){
        echo "Erreur : " . $except->getMessage();
    }
    echo '<div class="container col-sm-9 jumbotron" ><h1>Ajout</h1><hr>
        <form method="POST" action="modification.php">
            <div class="form-group">
                <label>ID de l\'auteur</label>
                <input name="authorId" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nom de l\'auteur</label>
                <input name="authorLastName" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Prénom de l\'auteur</label>
                <input name="authorFirstName" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>ID du siècle</label>
                <input name="centuryId" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Siecle</label>
                <input name="century" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Citation</label>
                <input name="citation" type="text" class="form-control" required>
            </div><br>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
<br><br>';
echo '<h1>Supprimer</h1><hr><br>
        <form method="POST" action="modification.php">
            <div class="form-group">
                <select class="form-control" name="citationId">
                    <option selected disabled>Sélectionnez l\'ID d\'une citation</option>';
$query = "SELECT id, phrase FROM citation";
$numero = $conn->query($query);
foreach ($numero as $data){
    echo "<option value=".$data['id'].">".$data['phrase']."</option>";
}

echo'</select></div><br><button type="submit" class="btn btn-primary">Supprimer</button></form></div>';

if(isset($_POST['authorId']) && isset($_POST['authorLastName']) &&  isset($_POST['authorFirstName']) && isset($_POST['centuryId']) && isset($_POST['century']) && isset($_POST['citation'])) {

    $sql = "INSERT INTO auteur (id, nom, prenom) VALUES (?, ?, ?)";
    $sqlR = $conn->prepare($sql);
    $sqlR->execute([$_POST['authorId'], $_POST['authorLastName'], $_POST['authorFirstName']]);
    $sql = "INSERT INTO siecle (id, numero) VALUES (?, ?)";
    $sqlR = $conn->prepare($sql);
    $sqlR->execute([$_POST['centuryId'], $_POST['century']]);
    $nbr_citations=$_POST['centuryId']+$_POST['authorId'];
    $sql = "INSERT INTO citation (id, phrase, auteurid, siecleid) VALUES (?, ?, ?, ?)";
    $sqlR = $conn->prepare($sql);
    $sqlR->execute([$nbr_citations, $_POST["citation"], $_POST['authorId'], $_POST['centuryId']]);
}
$citationId=$_POST['citationId'];

if($_POST['citationId'] != NULL) {
    $conn->exec("DELETE FROM citation WHERE id=" . $citationId);
}

?>
</body>
</html>