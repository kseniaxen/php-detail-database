<?php include '../includes/header.php'; ?>
<?php include '../config/Database.php'; ?>
<?php include '../models/Brigade.php'; ?>

<?php

$id = $shift = $notes = '';
$shiftErr = $idErr = '';

$database = new Database();
$db = $database->connect();

$brigade = new Brigade($db);
$listBrigade = $brigade->read();

//Id Brigade
if (isset($_POST['edit'])) {
    //Validate id
    if (empty($_POST['id']) || !ctype_digit($_POST['id'])) {
        $idErr = "Ошибка ввода";
    } else {
        $id = $_POST['id'];
    }

    //Validate shift
    if (empty($_POST['shift'])) {
        $shiftErr = "Ошибка ввода";
    } else {
        $shift = filter_input(INPUT_POST, 'shift', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    //Notes
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($idErr) && empty($shiftErr)) {
        if (!$brigade->check_single($id)) {
            $idErr = "Нету такого id";
        } else {
            //Edit to Database
            if ($brigade->edit($id, $shift, $notes)) {
                header('Location: ./index.php');
            }
        }
    }
}

?>

<div class="row" id="form-edit">
    <div class="col">
        <form method="POST">
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="text" class="form-control <?php echo !$idErr ?: 'is-invalid'; ?>" id="id" name="id" placeholder="Введите ID">
                <div class="invalid-feedback">
                    <?php echo $idErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="shift" class="form-label">График работы</label>
                <input type="text" class="form-control <?php echo !$shiftErr ?: 'is-invalid'; ?>" id="shift" name="shift" placeholder="Введите график работы бригады">
                <div class="invalid-feedback">
                    <?php echo $shiftErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Заметки</label>
                <textarea class="form-control" id="notes" name="notes" placeholder="Введите заметки для бригады" style="min-height: 100px;"></textarea>
            </div>
            <div class="mb-3">
                <input type="submit" name="edit" value="Изменить запись" class="btn btn-primary w-100">
            </div>
        </form>
    </div>
</div>


<?php include '../includes/footer.php'; ?>