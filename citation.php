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
            <li class="nav-item active">
                <a class="nav-link active" href="citation.php">Informations <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item ">
                <a class="nav-link " href="recherche.php">Recherche <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="modification.php">Modification <span class="sr-only">(current)</span></a>
            </li>

        </ul>
    </div>
</nav>
<div class="container">
    <h2>La citation du jour</h2>
    <br>
    <hr>
    <p class="text-left"><?php
        include "connexpdo.php";
        $dsn = 'pgsql:dbname=citations;host=localhost;port=5432';
        $user = 'postgres';
        $password = 'new_password';
        $query = "SELECT count (*) FROM citation";
        $sth = connexpdo($dsn, $user, $password)->query($query);
        $sth->execute();
        $result=$sth->fetch();
        echo "Il y a " . $result['count'] . " citations répertoriés.<br/>";
        echo "<p class^=\"text-left\">Et voici l'une d'entre elles générée aléatoirement :</p>";
        $random = random_int(1,$result['count']);
        $query = "SELECT phrase,auteurid,siecleid FROM citation where id=$random";
        $sth = connexpdo($dsn, $user, $password)->query($query);
        $sth->execute();
        $result=$sth->fetch();
        $citation = $result['phrase'];
        $auteurId = $result['auteurid'];
        $siecleId = $result['siecleid'];
        echo "<p class=\"font-weight-bold\">$citation</p>";
        $query = "SELECT prenom, nom from auteur where id=$auteurId";
        $sth = connexpdo($dsn, $user, $password)->query($query);
        $sth->execute();
        $result=$sth->fetch();
        $auteurNom = $result['nom'] . " " . $result['prenom'];
        $query = "SELECT numero from siecle where id=$siecleId";
        $sth = connexpdo($dsn, $user, $password)->query($query);
        $sth->execute();
        $result=$sth->fetch();
        $siecle = $result['numero'];
        echo "<p>$auteurNom ($siecle ème siècle)</p>";
        ?></p>



</div>





</body>

</html>