<?php

?>
<?php include 'header.php' ?>

<?php 
    // dd($persons);
?>
<main>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <form action="">
                            <input type="hidden" name="orderby" value="surname">
                            <button type="submit">Meno</button>
                        </form>
                    </th>
                    <th>
                        <form action="">
                            <input type="hidden" name="orderby" value="year">
                            <button type="submit">Rok</button>
                        </form>
                    </th>
                    <th>Miesto konania</th>
                    <th>
                        <form action="">
                            <input type="hidden" name="orderby" value="<?= isset($_GET['orderby']) ? $_GET['orderby'] : '' ?>">
                            <input type="hidden" name="type_order" value="type">
                            <button type="submit">Typ OH</button>
                        </form>
                    </th>
                    <th>Disciplína</th>
                    <th>Akcia</th>

                </tr>
            </thead>

        <?php foreach( $persons as $person ): ?>

            <tr>
                <td>
                    <a href="persons/<?= $person->id ?>">
                        <?= $person->name ?></td>
                    </a>
               
                <td><?= $person->year ?></td>

                <td><?= $person->city ?></td>
                <td><?= $person->type ?></td>
                <td><?= $person->discipline ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/persons/<?= $person->id ?>/edit" class="btn btn-info">Edit</a>
                  
                    <form action="delete.php" method="POST">
                        <input type="hidden" name="person_id" value="<?= $person->id ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>



            </tr>

        <?php endforeach; ?>

        </table>

        <a href="<?= BASE_URL ?>/persons/create">Create new person</a>
    </div>
</main>

<?php include 'footer.php' ?>
