<?php include '../includes/header.php'; ?>
<?php include '../config/Database.php'; ?>
<?php include '../models/Worker.php'; ?>
<?php include '../models/Brigade.php'; ?>

<?php

$surname = $name = $lastname = $position = $salary = $brigade = '';
$surnameErr = $nameErr = $lastnameErr = $positionErr =  $salaryErr = $brigadeErr = '';

$database = new Database();
$db = $database->connect();

$worker = new Worker($db);
$brigade = new Brigade($db);
$listBrigade = $brigade->read();

//Add Worker 
if (isset($_POST['add'])) {
    //Validate surname
    if (empty($_POST['surname'])) {
        $surnameErr = "Ошибка ввода";
    } else {
        $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    //Validate name
    if (empty($_POST['name'])) {
        $nameErr = "Ошибка ввода";
    } else {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    //Validate lastname
    if (empty($_POST['lastname'])) {
        $lastnameErr = "Ошибка ввода";
    } else {
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    //Validate position
    if (empty($_POST['position'])) {
        $positionErr = "Ошибка ввода";
    } else {
        $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    //Validate salary
    if (empty($_POST['salary']) || !is_numeric($_POST['salary'])) {
        $salaryErr = "Ошибка ввода";
    } else {
        $salary = $_POST['salary'];
        $salary = str_replace(' ','',$salary);
    }

    //Validate brigade
    if (empty($_POST['select-brigade'])) {
        $brigadeErr = "Выберите ID";
    } else {
        $brigade = $_POST['select-brigade'];
    }

    if(empty($surnameErr) && empty($nameErr) && empty($lastnameErr) && empty($salaryErr) && empty($positionErr) && empty($brigadeErr)){
        if($brigade == "no") {
            $brigade = 0;
        }
        if ($worker->add($surname, $name, $lastname, $salary, $position, $brigade)) {
            header('Location: ./index.php');
        }
    }
}

?>

<div class="row" id="form-add">
    <div class="col">
        <form method="POST">
            <div class="mb-3">
                <label for="surname" class="form-label">Фамилия</label>
                <input type="text" class="form-control <?php echo !$surnameErr ?: 'is-invalid'; ?>" id="surname" name="surname" placeholder="Введите фамилию">
                <div class="invalid-feedback">
                    <?php echo $surnameErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control <?php echo !$nameErr ?: 'is-invalid'; ?>" id="name" name="name" placeholder="Введите имя">
                <div class="invalid-feedback">
                    <?php echo $nameErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Отчество</label>
                <input type="text" class="form-control <?php echo !$lastnameErr ?: 'is-invalid'; ?>" id="lastname" name="lastname" placeholder="Введите отчество">
                <div class="invalid-feedback">
                    <?php echo $lastnameErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">Должность</label>
                <input type="text" class="form-control <?php echo !$positionErr ?: 'is-invalid'; ?>" id="position" name="position" placeholder="Введите должность">
                <div class="invalid-feedback">
                    <?php echo $positionErr; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Зарплата</label>
                <input type="text" class="form-control <?php echo !$salaryErr ?: 'is-invalid'; ?>" id="salary" name="salary" placeholder="Введите зарплата">
                <div class="invalid-feedback">
                    <?php echo $salaryErr; ?>
                </div>
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
                <input type="submit" name="add" value="Добавить запись" class="btn btn-primary w-100">
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>