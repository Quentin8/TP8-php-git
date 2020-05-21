
<?php
    include "connexpdo.php";
    $dsn = 'pgsql:dbname=citations;host=localhost;port=5432';
    $user = 'postgres';
    $password = 'new_password';
    $query = "SELECT prenom, nom FROM auteur";
    $sth = connexpdo($dsn, $user, $password)->query($query);
    $sth->execute();
    $result=$sth->fetchAll();
    echo "<p>Prenom / Nom</p>";
    foreach($result as $data)
    {
        echo $data['prenom']. " " . $data['nom'] . "<br>";
    }
    echo "<h2>Citations de la BD</h2>";
    $query = "SELECT phrase FROM citation";
    $sth = connexpdo($dsn, $user, $password)->query($query);
    $sth->execute();
    $result=$sth->fetchAll();
    foreach($result as $data)
    {
        echo $data['phrase']. " <br>";
    }
    echo "<h2>Siecles de la BD</h2>";
    $query = "SELECT numero FROM siecle";
    $sth = connexpdo($dsn, $user, $password)->query($query);
    $sth->execute();
    $result=$sth->fetchAll();
    foreach($result as $data)
    {
        echo $data['numero']. " <br>";
    }

?>
