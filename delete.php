<?php
    require_once "pdo.php";
    session_start();

    if (! isset($_SESSION['name'])){
        die("ACCESS DENIED");
    }

    if( isset($_POST['delete']) && isset($_POST['autos_id'])){
                
        $sql = "DELETE From autos WHERE autos_id = :zip";
        $statement = $pdo->prepare($sql);
        $statement->execute(array(':zip' => $_POST['autos_id']));

        $_SESSION['success'] = "Record deleted";
        header("location: index.php");
        return;
    }

    //check for auto_id
    if(! isset($_GET['autos_id']) || $_GET['autos_id']<1){
        $_SESSION['error'] = "Bad Value for id";
        header("location: index.php");
        return;
    }

    if(isset($_SESSION['error'])){
        echo '<p style="color : red">'.$_SESSION['error']."</p><br>";
        unset($_SESSION['error']);
    }

    $stmt = $pdo->prepare("SELECT * FROM AUTOS WHERE autos_id =:autos_id");
    $stmt->execute(array(':autos_id' => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $make = htmlentities($row['make']);
    $model = htmlentities($row['model']);
    $year = htmlentities($row['year']);
    $mileage = htmlentities($row['mileage']);
?>

<html>
    <head>
        <title>
            Muhammad Arqam Ejaz
        </title>
    </head>
    <body>
        <h2>Deleting Automobiles</h2>
        <p>Confirm: Deleting <?= $make ?></p>
        <form method="POST">
            <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
            <input type="submit" value="Delete" name="delete">
            <a href="index.php">Cancel</a>

        </form>
    </body>
</html>