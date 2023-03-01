<?php include '../includes/header.php'; ?>
<?php include '../config/Database.php'; ?>
<?php include '../models/Detail.php'; ?>

<?php

$database = new Database();
$db = $database->connect();

$detail = new Detail($db);
$listDetail = $detail->read();

?>

<h2 class="text-center my-3">Детали</h2>
<div class="row">
    <div class="col">
        <a href="../detail/add.php" type="button" id="btn-add" class="btn btn-primary">Добавить</a>
        <a href="../detail/edit.php" type="button" id="btn-edit" class="btn btn-warning">Изменить</a>
        <a href="../detail/delete.php" type="button" id="btn-delete" class="btn btn-danger">Удалить</a>
    </div>
</div>
<div class="row">
    <div class="col-12 table-fixed">
        <?php if (empty($listDetail)) : ?>
            <p class="lead mt3">Нету записей</p>
        <?php else : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Проверка на качество</th>
                        <th scope="col">Заметки</th>
                        <th scope="col">ID бригады</th>
                        <th scope="col">График работы бригады</th>
                        <th scope="col">Ответсвенный</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listDetail as $item) : ?>
                        <tr>
                            <th scope="row"> <?php echo $item['id']; ?></th>
                            <td><?php echo $item['title']; ?></td>
                            <td><?php echo $item['date']; ?></td>
                            <td><?php echo $item['quality'] ? 'есть' : 'нету'; ?></td>
                            <td><?php echo $item['notes']; ?></td>
                            <td><?php echo $item['brigade_id']; ?></td>
                            <td><?php echo $item['brigade_shift'] ?: '-'; ?></td>
                            <td><?php echo $item['worker_surname'] . ' ' . $item['worker_name']?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>