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
            <li class="nav-item">
                <a class="nav-link" href="citation.php">Informations <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link active" href="recherche.php">Recherche <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="modification.php">Modification <span class="sr-only">(current)</span></a>
            </li>

        </ul>
    </div>

</nav>

<div class="container">
    <div class="col-md-7">
        <form method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Auteur</label>
                <select class="form-control" name ="author">
                    <?php
                    include "connexpdo.php";
                    $dsn = 'pgsql:dbname=citations;host=localhost;port=5432';
                    $user = 'postgres';
                    $password = 'new_password';
                    $query = "SELECT count (*) FROM auteur";
                    $sth = connexpdo($dsn, $user, $password)->query($query);
                    $sth->execute();
                    $result=$sth->fetch();
                    $size = $result['count'];
                    $query = "SELECT prenom,nom,id FROM auteur";
                    $sth = connexpdo($dsn, $user, $password)->query($query);
                    $sth->execute();
                    $result=$sth->fetchAll();
                    for($i = 0;$i<$size;$i++){
                        echo "<option value = '" . $result[$i]['id'] . "'>".$result[$i]['nom']. " " . $result[$i]['prenom'] ."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Siècle</label>
                <select class="form-control" name ="siecle">
                    <?php
                    $dsn = 'pgsql:dbname=citations;host=localhost;port=5432';
                    $user = 'postgres';
                    $password = 'new_password';
                    $query = "SELECT count (*) FROM siecle";
                    $sth = connexpdo($dsn, $user, $password)->query($query);
                    $sth->execute();
                    $result=$sth->fetch();
                    $size = $result['count'];
                    $query = "SELECT numero, id FROM siecle";
                    $sth = connexpdo($dsn, $user, $password)->query($query);
                    $sth->execute();
                    $result=$sth->fetchAll();
                    for($i = 0;$i<$size;$i++){
                        echo "<option value = '" . $result[$i]['id'] . "'>".$result[$i]['numero']."</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="searchAuthor" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <?php
        if(isset($_POST["searchAuthor"])){
            $dsn = 'pgsql:dbname=citations;host=localhost;port=5432';
            $user = 'postgres';
            $password = 'new_password';
            $conn = connexpdo($dsn, $user, $password);
            $sth = $conn->query($query);
            $sth->execute();
            $result=$sth->fetchAll();
            echo'<br>';
            echo'<table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Citation</th>
                    <th scope="col">Auteur</th>
                    <th scope="col">Siecle</th>
                </tr>
            </thead>
            <tbody>';

            $nb_citations=0;
            $query = "SELECT phrase FROM citation WHERE auteurid =".$_POST['author']. " AND siecleid = ".$_POST['siecle'];
            $sth = $conn->query($query);
            $sth->execute();
            foreach ($sth as $data) {
                $nb_citations++;
            }

            if($nb_citations>=1) {
                $query = "SELECT phrase FROM citation WHERE auteurid =" . $_POST['author'] . " AND siecleid = " . $_POST['siecle'];
                $sth = $conn->prepare($query);
                $sth->execute();
                $result=$sth->fetchAll();

                for ($it = 0; $it < $nb_citations; $it++) {
                    $index=$it+1;
                    echo '<tr>';
                    echo '<th scope="row">'.$index.'</th>';
                    echo '<td>' . $result[$it]['phrase'] . '</td>';

                    $query1 = "SELECT nom, prenom FROM auteur WHERE id =" . $_POST['author'];
                    $auteur = $conn->query($query1);
                    foreach ($auteur as $data) {
                        echo '<td>' . $data['prenom'] . " " . $data['nom'] . '</td>';
                    }
                    $query2 = "SELECT numero FROM siecle WHERE id =" . $_POST['siecle'];
                    $siecle = $conn->query($query2);
                    foreach ($siecle as $data) {
                        echo '<td>' . $data['numero'] . '</td>';
                    }
                    echo '</tr>';
                }
            }
            else {
                echo "Cet auteur n'a pas fait de citations durant ce siècle. <br><br>";
            }
            echo'</tbody>
</table>';
        }
    ?>

</div>
</body>

</html>