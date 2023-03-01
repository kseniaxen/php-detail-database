<?php include '../includes/header.php'; ?>
<?php include '../config/Database.php'; ?>
<?php include '../models/Worker.php'; ?>
<?php include '../models/Brigade.php'; ?>
<?php include '../models/Detail.php'; ?>

<?php
session_start();

$title = $quality = $date = $notes = $brigade_id = $worker_id = '';
$titleErr = $qualityErr = $dateErr = $notesErr = $brigadeErr = $workerErr = '';

$showEdit = false;
$id = '';
$idErr = '';

$database = new Database();
$db = $database->connect();

$worker = new Worker($db);
$brigade = new Brigade($db);
$detail = new Detail($db);
$listBrigade = $brigade->read();
$listWorker = $worker->read();
$listDetail = $detail->read();

if (isset($_POST['choose-note'])) {
    //Validate id
    if (empty($_POST['select-edit'])) {
        $idErr = "Выберите ID";
    } else {
        $id = $_POST['select-edit'];
    }

    if (empty($idErr)) {
        //Check if exist
        if ($detail->check_single($id)) {
            //Find this note
            $detail->read_single($id);
            $showEdit = true;
            $_SESSION['id'] = $id;
        }
    }
}

if (isset($_POST['edit'])) {
    //Validate title
    if (empty($_POST['title']) || empty(trim($_POST['title']))) {
        $titleErr = "Ошибка ввода";
    } else {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    //Validate date
    if (empty($_POST['date']) || empty(trim($_POST['date']))) {
        $dateErr = "Ошибка ввода";
    } else {
        $date = $_POST['date'];
    }

    //Notes
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //Validate quality
    if (empty($_POST['select-quality'])) {
        $qualityErr = "Выберите ID";
    } else {
        if ($quality == 'no') {
            $quality = 0;
        }
        $quality = $_POST['select-quality'];
    }

    //Validate brigade
    if (empty($_POST['select-brigade'])) {
        $brigadeErr = "Выберите ID";
    } else {
        $brigade = $_POST['select-brigade'];
    }

    //Validate worker
    if (empty($_POST['select-worker'])) {
        $workerErr = "Выберите ID";
    } else {
        $worker = $_POST['select-worker'];
    }

    if (isset($_SESSION['id']) && empty($titleErr) && empty($qualityErr) && empty($dateErr) && empty($brigadeErr) && empty($workerErr)) {
        echo $title . ' . ' . $date . ' . ' . $quality . ' . ' . $brigade . ' . ' . $worker;
        if ($detail->edit($_SESSION['id'], $title, $date, $quality, $notes, $brigade, $worker)) {
            header('Location: ./index.php');
            session_destroy();
        }
    }
}


?>

<div class="row" id="form-edit">
    <div class="col">
        <form method="POST">
            <div class="mb-3">
                <select class="form-select <?php echo !$idErr ?: 'is-invalid'; ?>" name="select-edit">
                    <option selected disabled value="">Выберите ID</option>
                    <?php foreach ($listDetail as $item) : ?>
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
            <div>
                <h3>ID: <?php echo $_SESSION['id'] ?: $_SESSION['id']; ?></h3>
            </div>
            <form method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Наименование</label>
                    <input type="text" value="<?php echo !$detail->title ? '' : $detail->title; ?>" class="form-control <?php echo !$titleErr ?: 'is-invalid'; ?>" id="title" name="title" placeholder="Введите наименование">
                    <div class="invalid-feedback">
                        <?php echo $titleErr; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Дата</label>
                    <input type="text" value="<?php echo !$detail->date ? '': $detail->date; ?>" class="form-control <?php echo !$dateErr ?: 'is-invalid'; ?>" id="date" name="date" placeholder="Введите дату">
                    <div class="invalid-feedback">
                        <?php echo $dateErr; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <select class="form-select <?php echo !$qualityErr ?: 'is-invalid'; ?>" name="select-quality">
                        <option selected disabled value="">Проверка на качество</option>
                        <option value="no" <?php if ($detail->quality == 0) { echo ' selected="selected"'; } ?>>нету</option>
                        <option value="1" <?php if ($detail->quality == 1) { echo ' selected="selected"'; } ?>>есть</option>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo $qualityErr; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Заметки</label>
                    <textarea class="form-control" id="notes" name="notes" placeholder="Введите заметки для бригады" style="min-height: 100px;"><?php echo $detail->notes ? $detail->notes: ''; ?></textarea>
                </div>
                <div class="mb-3">
                    <select class="form-select <?php echo !$brigadeErr ?: 'is-invalid'; ?>" name="select-brigade">
                        <option selected disabled value="">Выбрать бригаду</option>
                        <?php foreach ($listBrigade as $item) : ?>
                            <?php if ($detail->brigade_id == $item['id']) : ?>
                                <option value="<?php echo $item['id'] ?>" selected><?php echo $item['id'] ?></option>
                            <?php else : ?>
                                <option value="<?php echo $item['id'] ?>"><?php echo $item['id'] ?></option>
                            <?php endif; ?>
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
                            <?php if ($detail->worker_id == $item['id']) : ?>
                                <option value="<?php echo $item['id'] ?>" selected><?php echo $item['surname'] . ' ' . $item['name'] . ', ' . $item['position'] ?></option>
                            <?php else : ?>
                                <option value="<?php echo $item['id'] ?>"><?php echo $item['surname'] . ' ' . $item['name'] . ', ' . $item['position'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?php echo $workerErr; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="submit" name="edit" value="Изменить запись" class="btn btn-primary w-100">
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>