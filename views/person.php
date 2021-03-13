<?php include_once 'header.php' ?>


<main>
    <div class="container"> 
        
        <div class="jumbotron">
            <h1 class="display-4"><?= $person->getFullName() ?></h1>

            <hr>
            <div class="row mt-4">
            
                <div class="col-lg-6">
                    <h2>Narodenie</h2>
                    <?= $person->getBirthDay() ?>
                    <?= $person->getBirthPlace() ?>
                    <?= $person->getBirthCountry() ?>
                    
                </div>
                <div class="col-lg-6">
                    <h2>Úmrtie</h2>
                    <?= $person->getDeathDay() ?>
                    <?= $person->getDeathPlace() ?>
                    <?= $person->getDeathCountry() ?>
                </div>
            </div>
        </div>

        <div class="my-5">
            <h3>Tabuľka umiestnení</h3>
            <table class="table">
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
                        <td><?= $standing->discipline ?></td>


                    </tr>

                <?php endforeach; ?>
            </table>
        </div>

    </div> <!-- END CONTAINER -->

</main>


<?php include_once 'footer.php' ?>