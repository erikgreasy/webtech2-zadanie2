<?php require_once 'model/Person.php';
    require_once 'inc/functions.php';
require_once 'controller/PersonController.php';


?>

<?php include 'header.php' ?>

<?php 

    // $person = new Person( 'Erik', 'Masny', '06.07.1999', 'Zilina', 'Slovensko', '', '', '' );

    // var_dump($person);

    $personController = new PersonController();


    print_r( $personController->index() );
?>


<?php include 'footer.php' ?>
