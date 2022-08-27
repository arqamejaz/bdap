<?php
    require_once "pdo.php";
    session_start();

    if (! isset($_SESSION['name'])){
        die("ACCESS DENIED");
    }
//coment
    if( isset($_POST['make']) && isset($_POST['model'])
    && isset($_POST['year']) && isset($_POST['mileage'])){
        echo 'done';
        //Data Validation Starts
        if( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 
        || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1){
            $_SESSION['error'] = "All fields are required";
            header("location: edit.php?autos_id=".$_REQUEST['autos_id']);
            return;
        }

        if(!is_numeric($_POST['year'])){
            $_SESSION['error'] = "Year must be an integer";
            header("location: edit.php?autos_id=".$_REQUEST['autos_id']);
            return;
        }

        if(!is_numeric($_POST['mileage'])){
            $_SESSION['error'] = "Mileage must be an integer";
            header("location: edit.php?autos_id=".$_REQUEST['autos_id']);
            return;
        }
        // Data Validation Ends

        $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE autos_id = :autos_id";
        $statement = $pdo->prepare($sql);
        $statement->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':autos_id' => $_POST['autos_id']
        ));

        $_SESSION['success'] = "Record edited";
        header("location: index.php");
        return;
    }
    //check for auto_id
    if(! isset($_GET['autos_id']) || $_GET['autos_id']<1){
        $_SESSION['error'] = "Bad Value for id";
        header("location: index.php");
        return;
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
        <h2>Editing Automobiles</h2>

        <?php
         if(isset($_SESSION['error'])){
            echo '<p style="color : red">'.$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        ?>

        <form method="POST">

            <p> Make:
                <input type="text" name="make" value="<?= $make ?>">
            </p>
            <p> Model:
                <input type="text" name="model" value="<?= $model ?>">
            </p>
            <p> Year:
                <input type="text" name="year" value="<?= $year ?>">
            </p>
            <p> Mileage:
                <input type="text" name="mileage" value="<?= $mileage ?>">
            </p>
            <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
            <p> 
                <input type="submit" value="Save" />
                <a href="index.php">Cancel</a>
            </p>

        </form>
    </body>
</html>