
<?php include 'header.php' ?>



<main>
    <div class="container">
        <h1>Pridajte nového športovca:</h1>
        <form action="" method="POST">

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

            <div class="form-group">
                <label for="name">Meno:</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>">
            </div>

            <div class="form-group">
                <label for="surname">Priezvisko:</label>
                <input type="text" name="surname" id="surname" class="form-control" value="<?= isset($_POST['surname']) ? $_POST['surname'] : '' ?>">
            </div>

            <div class="form-group">
                <label for="birth_day">Dátum narodenia:</label>
                <input type="text" name="birth_day" id="birth_day" class="form-control" value="<?= isset($_POST['birth_day']) ? $_POST['birth_day'] : '' ?>">
            </div>

            <div class="form-group">
                <label for="birth_place">Miesto narodenia:</label>
                <input type="text" name="birth_place" id="birth_place" class="form-control" value="<?= isset($_POST['birth_place']) ? $_POST['birth_place'] : '' ?>">
            </div>

            <div class="form-group">
                <label for="birth_country">Krajina narodenia:</label>
                <input type="text" name="birth_country" id="birth_country" class="form-control" value="<?= isset($_POST['birth_country']) ? $_POST['birth_country'] : '' ?>">
            </div>

            <div class="form-group">
                <label for="death_day">Dátum úmrtia:</label>
                <input type="text" name="death_day" id="death_day" class="form-control" value="<?= isset($_POST['death_day']) ? $_POST['death_day'] : '' ?>">
            </div>

            <div class="form-group">
                <label for="death_place">Miesto úmrtia:</label>
                <input type="text" name="death_place" id="death_place" class="form-control" value="<?= isset($_POST['death_place']) ? $_POST['death_place'] : '' ?>">
            </div>

            <div class="form-group">
                <label for="death_country">Krajina úmrtia:</label>
                <input type="text" name="death_country" id="death_country" class="form-control" value="<?= isset($_POST['death_country']) ? $_POST['death_country'] : '' ?>">
            </div>

            <button type="submit" class="btn btn-info btn-block">Pridať</button>
        </form>
    </div>

</main>

<?php include 'footer.php' ?>
