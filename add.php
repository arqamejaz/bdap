<?php
    require_once "pdo.php";
    session_start();

    if (! isset($_SESSION['name'])){
        die("ACCESS DENIED");
    }

    if( isset($_POST['make']) && isset($_POST['model'])
    && isset($_POST['year']) && isset($_POST['mileage'])){
        
        //Data Validation Starts
        if( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 
        || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1){
            $_SESSION['error'] = "All fields are required";
            header("location: add.php");
            return;
        }

        if(!is_numeric($_POST['year'])){
            $_SESSION['error'] = "Year must be an integer";
            header("location: add.php");
            return;
        }
        if(!is_numeric($_POST['mileage'])){
            $_SESSION['error'] = "Mileage must be an integer";
            header("location: add.php");
            return;
        }
        // Data Validation Ends

        $sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:make, :model, :year, :mileage)";
        $statement = $pdo->prepare($sql);
        $statement->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']
        ));

        $_SESSION['success'] = "Record added";
        header("location: index.php");
        return;
    }    
?>

<html>
    <head>
        <title>
            Muhammad Arqam Ejaz
        </title>
    </head>
    <body>
        <h2>Tracking Automobiles for <?= htmlentities($_SESSION['name']) ?></h2>
        <?php 
        if(isset ($_SESSION['error'])){
            echo "<p style='color: red'>".htmlentities($_SESSION['error'])."</p>";
            unset($_SESSION['error']);
        }
        ?>
        
        <form method="POST">
            <p> Make:
                <input type="text" name="make">
            </p>
            <p> Model:
                <input type="text" name="model">
            </p>
            <p> Year:
                <input type="text" name="year">
            </p>
            <p> Mileage:
                <input type="text" name="mileage">
            </p>            
            <p> 
                <input type="submit" value="Add" />
                <a href="index.php">Cancel</a>
            </p>
        </form>
    </body>
</html>