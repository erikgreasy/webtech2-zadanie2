<?php include 'header.php' ?>

<main class="person-edit">
    <div class="container">
        <h1 class="mb-4 text-center">Upravte športovca:</h1>

        <form action="#" method="POST">

            <?php if( isset($errors) && !empty($errors) ): ?>
                <div class="alert alert-danger" role="alert">
                    <ul>
                        <?php foreach( $errors as $error ): ?>
                            <li>
                                <?= $error ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <input type="hidden" name="person_id" value=<?= $person->id ?>>

            <div class="form-group">
                <label for="name">Meno:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $person->name ?>">
            </div>

            <div class="form-group">
                <label for="surname">Priezvisko:</label>
                <input type="text" name="surname" id="surname" class="form-control" value="<?= $person->surname ?>">
            </div>

            <div class="form-group">
                <label for="birth_day">Dátum narodenia:</label>
                <input type="date" name="birth_day" id="birth_day" class="form-control" value="<?= date('Y-m-d', strtotime($person->birth_day) ) ?>">
            </div>

            <div class="form-group">
                <label for="birth_place">Miesto narodenia:</label>
                <input type="text" name="birth_place" id="birth_place" class="form-control" value="<?= $person->birth_place ?>">
            </div>

            <div class="form-group">
                <label for="birth_country">Krajina narodenia:</label>
                <input type="text" name="birth_country" id="birth_country" class="form-control" value="<?= $person->birth_country ?>">
            </div>

            <div class="form-group">
                <label for="death_day">Dátum úmrtia:</label>
                <input type="date" name="death_day" id="death_day" class="form-control" value="<?= $person->death_day != '' ? date('Y-m-d', strtotime($person->death_day) ) : '' ?>">
            </div>

            <div class="form-group">
                <label for="death_place">Miesto úmrtia:</label>
                <input type="text" name="death_place" id="death_place" class="form-control" value="<?= $person->death_place ?>">
            </div>

            <div class="form-group">
                <label for="death_country">Krajina úmrtia:</label>
                <input type="text" name="death_country" id="death_country" class="form-control" value="<?= $person->death_country ?>">
            </div>

            <button type="submit" class="btn btn-info btn-block">Upraviť</button>
        
        </form>
    </div>
</main>

<?php include 'footer.php' ?>
