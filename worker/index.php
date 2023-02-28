<?php include '../includes/header.php'; ?>
<?php include '../config/Database.php'; ?>
<?php include '../models/Worker.php'; ?>

<?php

$database = new Database();
$db = $database->connect();

$worker = new Worker($db);
$listWorker = $worker->read();

?>
<h2 class="text-center my-3">Рабочие</h2>
<div class="row">
    <div class="col">
        <a href="../worker/add.php" type="button" id="btn-add" class="btn btn-primary">Добавить</a>
        <a href="../worker/edit.php" type="button" id="btn-edit" class="btn btn-warning">Изменить</a>
        <a href="../worker/delete.php" type="button" id="btn-delete" class="btn btn-danger">Удалить</a>
    </div>
</div>
<div class="row">
    <div class="col-12 table-fixed">
        <?php if (empty($listWorker)) : ?>
            <p class="lead mt3">Нету записей</p>
        <?php else : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Фамилия</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Отчество</th>
                        <th scope="col">Должность</th>
                        <th scope="col">Зарплата</th>
                        <th scope="col">ID бригады</th>
                        <th scope="col">График работы бригады</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listWorker as $item) : ?>
                        <tr>
                            <th scope="row"> <?php echo $item['id']; ?></th>
                            <td><?php echo $item['surname']; ?></td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['lastname']; ?></td>
                            <td><?php echo $item['position']; ?></td>
                            <td><?php echo $item['salary']; ?></td>
                            <td><?php echo $item['brigade_id'] ?: '-'; ?></td>
                            <td><?php echo $item['brigade_shift']?: '-'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>