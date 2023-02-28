<?php include '../includes/header.php'; ?>
<?php include '../config/Database.php'; ?>
<?php include '../models/Brigade.php'; ?>

<?php

$database = new Database();
$db = $database->connect();

$brigade = new Brigade($db);
$listBrigade = $brigade->read();

?>

<h2 class="text-center my-3">Бригады</h2>
<div class="row">
    <div class="col">
        <a href="../brigade/add.php" type="button" id="btn-add" class="btn btn-primary">Добавить</a>
        <a href="../brigade/edit.php" type="button" id="btn-edit" class="btn btn-warning">Изменить</a>
        <a href="../brigade/delete.php" type="button" id="btn-delete" class="btn btn-danger">Удалить</a>
    </div>
</div>
<div class="row">
    <div class="col-12 table-fixed">
        <?php if (empty($listBrigade)) : ?>
            <p class="lead mt3">Нету записей</p>
        <?php else : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Время работы</th>
                        <th scope="col">Заметки</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listBrigade as $item) : ?>
                        <tr>
                            <th scope="row"> <?php echo $item['id']; ?></th>
                            <td><?php echo $item['shift']; ?></td>
                            <td class="col-sm-8"><?php echo $item['notes']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>