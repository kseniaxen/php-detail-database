<?php include '../includes/header.php'; ?>
<?php include '../config/Database.php'; ?>
<?php include '../models/Detail.php'; ?>

<?php

$id = '';
$idErr = '';

$database = new Database();
$db = $database->connect();

$detail = new Detail($db);
$listDetail = $detail->read();

if(isset($_POST['delete'])) {
    if(empty($_POST['select-delete'])) {
        $idErr="Не выбран ID!";
    } else {
        $id = $_POST['select-delete'];
    }

    if(empty($idErr)) {
        if($detail->delete($id)) {
            header('Location: ./index.php');
        }
    }
}

?>

<div class="row" id="form-delete">
    <div class="col">
        <form method="POST">
            <div class="mb-3">
                <select class="form-select <?php echo !$idErr ?: 'is-invalid'; ?>" name="select-delete">
                    <option selected disabled value="">Выберите ID</option>
                    <?php foreach ($listDetail as $item) : ?>
                        <option value=<?php echo $item['id'] ?>><?php echo $item['id'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?php echo $idErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <input type="submit" name="delete" value="Удалить запись" class="btn btn-primary w-100">
            </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>