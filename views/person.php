<?php include_once 'header.php' ?>


<main>
    <div class="container"> 
        <h1><?= $person->getFullName() ?></h1>
        <a href="<?= BASE_URL ?>/persons/<?= $person->getId() ?>/edit">Edit</a>
        <form action="<?= BASE_URL ?>/persons/<?= $person->getId() ?>/delete" method="POST">
            <input type="hidden" name="_method" value="delete">
            <button type="submit">Delete</button>
        </form>

        <h2>Narodenie</h2>
        *
        <?= $person->getBirthDay() ?>
        <?= $person->getBirthPlace() ?>
        <?= $person->getBirthCountry() ?>
        
        <h2>Úmrtie</h2>
        +
        <?= $person->getDeathDay() ?>
        <?= $person->getDeathPlace() ?>
        <?= $person->getDeathCountry() ?>

    </div>
</main>


<?php include_once 'footer.php' ?>