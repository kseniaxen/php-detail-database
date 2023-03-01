<?php include '../includes/header.php'; ?>
<?php include '../config/Database.php'; ?>
<?php include '../models/Worker.php'; ?>
<?php include '../models/Brigade.php'; ?>
<?php include '../models/Detail.php'; ?>

<?php

$title = $quality = $notes = $brigade_id = $worker_id = '';
$titleErr = $qualityErr = $notesErr = $brigadeErr = $workerErr = '';

$database = new Database();
$db = $database->connect();

$worker = new Worker($db);
$brigade = new Brigade($db);
$detail = new Detail($db);
$listBrigade = $brigade->read();
$listWorker = $worker->read();

//Add Detail
if(isset($_POST['add'])) {
    //Validation title
    if (empty($_POST['title'])) {
        $titleErr = "Ошибка ввода";
    } else {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    //Validation quality
    if (empty($_POST['select-quality'])) {
        $qualityErr = "Выберите из списка!";
    } else {
        if($_POST['select-quality'] == 'no') {
            $_POST['select-quality'] = 0;
        } 
        $quality = $_POST['select-quality'];
    }

    //Notes
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //Validation brigade
    if (empty($_POST['select-brigade'])) {
        $brigadeErr = "Выберите из списка!";
    } else {
        $brigade = $_POST['select-brigade'];
    }

    //Validation worker
    if (empty($_POST['select-worker'])) {
        $workerErr = "Выберите из списка!";
    } else {
        $worker = $_POST['select-worker'];
    }

    if(empty($titleErr) && empty($qualityErr) && empty($brigadeErr) && empty($workerErr)){
        if ($detail->add($title, $quality, $notes, $brigade, $worker)) {
            header('Location: ./index.php');
        }
    }
}

?>

<div class="row" id="form-add">
    <div class="col">
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Наименование</label>
                <input type="text" class="form-control <?php echo !$titleErr ?: 'is-invalid'; ?>" id="title" name="title" placeholder="Введите наименование">
                <div class="invalid-feedback">
                    <?php echo $titleErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <select class="form-select <?php echo !$qualityErr ?: 'is-invalid'; ?>" name="select-quality">
                    <option selected disabled value="">Проверка на качество</option>
                    <option value="no">нету</option>
                    <option value="1">есть</option>
                </select>
                <div class="invalid-feedback">
                    <?php echo $qualityErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Заметки</label>
                <textarea class="form-control" id="notes" name="notes" placeholder="Введите заметки для бригады" style="min-height: 100px;"></textarea>
            </div>
            <div class="mb-3">
                <select class="form-select <?php echo !$brigadeErr ?: 'is-invalid'; ?>" name="select-brigade">
                    <option selected disabled value="">Выбрать бригаду</option>
                    <option value="no">Нету</option>
                    <?php foreach ($listBrigade as $item) : ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo 'id: ' . $item['id'] . ', ' . $item['shift'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?php echo $brigadeErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <select class="form-select <?php echo !$workerErr ?: 'is-invalid'; ?>" name="select-worker">
                    <option selected disabled value="">Выбрать рабочего</option>
                    <?php foreach ($listWorker as $item) : ?>
                        <option value="<?php echo $item['id'] ?>"><?php echo $item['surname'] . ' ' . $item['name']  . ' , ' . $item['position'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?php echo $workerErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <input type="submit" name="add" value="Добавить запись" class="btn btn-primary w-100">
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>