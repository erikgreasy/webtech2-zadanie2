
<?php include 'header.php' ?>

<main class="person-index">
    <div class="container">
        <?php $GLOBALS['msg']->display(); ?>
        <section>
            <h1 class="mb-4 text-center">Slovenskí olympionici</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <form action="#">
                                <input type="hidden" name="orderby" value="surname">
                                <input type="hidden" name="ordersurname" value="<?= isset( $_GET['ordersurname'] ) && $_GET['ordersurname'] == 'ASC' ? 'DESC' : 'ASC' ?>">

                                <button type="submit">Meno</button>
                            </form>
                        </th>

                        <th>Umiestnenie</th>

                        <th>
                            <form action="#">
                                <input type="hidden" name="orderby" value="year">
                                <input type="hidden" name="orderyear" value="<?= isset( $_GET['orderyear'] ) && $_GET['orderyear'] == 'ASC' ? 'DESC' : 'ASC' ?>">
                                <button type="submit">Rok</button>
                            </form>
                        </th>
                        <th>Miesto konania</th>

                        <th>
                            <form action="#">
                                <input type="hidden" name="orderby" value="<?= isset($_GET['orderby']) ? $_GET['orderby'] : '' ?>">
                            
                                <?php if( isset( $_GET['orderby'] ) ): ?>
                                    <?php $order = 'order' . $_GET['orderby'] ?>
                                    <input type="hidden" name="order<?= $_GET['orderby'] ?>" value="<?= $_GET[$order] ?>">
                                <?php endif; ?>
                                
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
                            <?= filter_var( $person->name, FILTER_SANITIZE_STRING ) ?></td>
                        </a>
                
                    <td><?= filter_var( $person->placing, FILTER_SANITIZE_STRING ) ?></td>
                    <td><?= filter_var( $person->year, FILTER_SANITIZE_STRING ) ?></td>

                    <td><?= $person->city ?></td>
                    <td><?= $person->type ?></td>
                    <td><?= filter_var( $person->discipline, FILTER_SANITIZE_STRING ) ?></td>
                    <td class="d-flex">
                        <a href="<?= BASE_URL ?>/persons/<?= $person->id ?>/edit" class="btn btn-info mr-2">Edit</a>
                    
                        <form action="<?= BASE_URL ?>/persons/<?= $person->id ?>/delete" method="POST">
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>



                </tr>

            <?php endforeach; ?>

            </table>
        </section>

        <section class="mt-5">
            <h2 class="mb-4">Top 10 zlatých olympionikov:</h2>
            <table class="table table-bordered">
                <tr>
                    <th>Meno</th>
                    <th>Počet zlatých medajlí</th>
                </tr>
                <?php foreach( $top_ten as $person ): ?>

                    <tr>
                        <td><?= filter_var( $person->name, FILTER_SANITIZE_STRING ) ?></td>
                        <td><?= $person->win_count ?></td>

                    </tr>

                <?php endforeach; ?>
            </table>
        </section>
    </div>
</main>

<?php include 'footer.php' ?>
