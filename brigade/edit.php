<?php include '../includes/header.php'; ?>
<?php include '../config/Database.php'; ?>
<?php include '../models/Brigade.php'; ?>

<?php

session_start();

$showEdit = false;
$id = $shift = $notes = '';
$idErr = $shiftErr  = '';

$database = new Database();
$db = $database->connect();

$brigade = new Brigade($db);
$listBrigade = $brigade->read();

if (isset($_POST['choose-note'])) {
    //Validate id
    if (empty($_POST['select-delete'])) {
        $idErr = "Выберите ID";
    } else {
        $id = $_POST['select-delete'];
    }
    if (empty($idErr)) {
        //Check if exist
        if ($brigade->check_single($id)) {
            //Find this note
            $brigade->read_single($id);
            $showEdit = true;
            $_SESSION['id'] = $id;
        }
    }
}

if (isset($_POST['edit'])) {
    //Validate shift
    if (empty($_POST['shift'])) {
        $shiftErr = "Ошибка ввода";
    } else {
        $shift = filter_input(INPUT_POST, 'shift', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    //Notes
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (isset($_SESSION['id']) && empty($shiftErr)) {
        if ($brigade->edit($_SESSION['id'], $shift, $notes)) {
            header('Location: ./index.php');
        }
    }
}

?>

<div class="row" id="form-edit">
    <div class="col">
        <form method="POST">
            <div class="mb-3">
                <select class="form-select <?php echo !$idErr ?: 'is-invalid'; ?>" name="select-delete">
                    <option selected disabled value="">Выберите ID</option>
                    <?php foreach ($listBrigade as $item) : ?>
                        <?php if ($id == $item['id']) : ?>
                            <option value="<?php echo $item['id'] ?>" selected><?php echo $item['id'] ?></option>
                        <?php else : ?>
                            <option value="<?php echo $item['id'] ?>"><?php echo $item['id'] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?php echo $idErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <input type="submit" name="choose-note" value="Найти ID" class="btn btn-primary w-100">
            </div>
        </form>
        <div class="<?php echo $showEdit ? 'd-block' : 'd-none'; ?>">
            <form method="POST">
                <div class="mb-3">
                    <label for="shift" class="form-label">График работы</label>
                    <input type="text" value="<?php echo !$brigade->shift ?: $brigade->shift; ?>" class="form-control <?php echo !$shiftErr ?: 'is-invalid'; ?>" id="shift" name="shift" placeholder="Введите график работы бригады">
                    <div class="invalid-feedback">
                        <?php echo $shiftErr; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Заметки</label>
                    <textarea class="form-control" id="notes" name="notes" placeholder="Введите заметки для бригады" style="min-height: 100px;"><?php echo !$brigade->notes ?: $brigade->notes; ?></textarea>
                </div>
                <div class="mb-3">
                    <input type="submit" name="edit" value="Изменить запись" class="btn btn-primary w-100">
                </div>
            </form>
        </div>
    </div>
</div>