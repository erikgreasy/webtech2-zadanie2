
<?php include 'header.php' ?>



<main>
    <div class="container">
        <h1>Pridanie nového umiestnenia:</h1>
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
                <label for="person">Športovec:</label>
                <select name="person" id="person" class="form-control">
                    <?php  foreach( $persons as $person ): ?>
                        <option value="<?= $person->getId() ?>"><?= $person->getFullName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="olympic_games">OH:</label>
                <select name="olympic_games" id="olympic_games" class="form-control">
                    <?php  foreach( $olympic_games as $game ): ?>
                        <option value="<?= $game->id ?>"><?= $game->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="standing">Umiestnenie:</label>
                <input type="number" name="standing" id="standing" class="form-control" min="1" max="50">
            </div>


            <div class="form-group">
                <label for="discipline">Disciplína:</label>
                <input type="text" name="discipline" id="discipline" class="form-control">
            </div>


            <button type="submit" class="btn btn-info btn-block">Pridať</button>
        </form>
    </div>

</main>

<?php include 'footer.php' ?>
