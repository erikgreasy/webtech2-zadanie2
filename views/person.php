<?php include_once 'header.php' ?>


<main>
    <div class="container"> 
        <?php $GLOBALS['msg']->display(); ?>
        <div class="jumbotron">
            <h1 class="display-4 text-center"><?= filter_var( $person->getFullName(), FILTER_SANITIZE_STRING ) ?></h1>

            <hr>
            <div class="row mt-4 text-center">
            
                <div class="col-lg-6">
                    <h2>Narodenie</h2>
                    <?= filter_var( $person->getBirthDay(), FILTER_SANITIZE_STRING ) ?>
                    <?= filter_var( $person->getBirthPlace(), FILTER_SANITIZE_STRING ) ?>
                    <?= filter_var( $person->getBirthCountry(), FILTER_SANITIZE_STRING ) ?>
                    
                </div>
                <div class="col-lg-6">
                    <h2>Úmrtie</h2>
                    <?= filter_var( $person->getDeathDay(), FILTER_SANITIZE_STRING ) ?>
                    <?= filter_var( $person->getDeathPlace(), FILTER_SANITIZE_STRING ) ?>
                    <?= filter_var( $person->getDeathCountry(), FILTER_SANITIZE_STRING ) ?>
                </div>
            </div>
        </div>

        <div class="my-5">
            <h3 class="text-center mb-4">Tabuľka umiestnení</h3>
            <table class="table table-bordered">
                <tr>
                    <th>Umiestnenie</th>
                    <th>Rok</th>
                    <th>Miesto konania</th>
                    <th>Typ OH</th>
                    <th>Disciplína</th>
                </tr>
                
                <?php foreach($standings as $standing): ?>

                    <tr>
                        <td><?= $standing->placing ?></td>
                        <td><?= $standing->year ?></td>
                        <td><?= $standing->city ?></td>
                        <td><?= $standing->type ?></td>
                        <td><?= filter_var( $standing->discipline, FILTER_SANITIZE_STRING ) ?></td>


                    </tr>

                <?php endforeach; ?>
            </table>
        </div>

    </div> <!-- END CONTAINER -->

</main>


<?php include_once 'footer.php' ?>