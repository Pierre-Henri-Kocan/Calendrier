<?php

require '../src/bootstrap.php';

use App\Validator;
use Calendar\EventValidator;
use Calendar\Event;
use Calendar\Events;

$data = [
    'date' => $_GET['date'] ?? date('Y-m-d'),
    'start' => $_GET['date'] ?? date('H:i'),
    'end' => $_GET['date'] ?? date('H:i'),
];
$validator = new Validator($data);
if(!$validator->validate('date', 'date')) {
    $data['date'] = date('Y-m-d');
};
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $validator = new EventValidator();
    $errors = $validator->validates($_POST);
    if(empty($errors)) {
        $events = new Events(get_pdo());
        $event = $events->hydrate(new Event(), $data);
        $events->create($event);
        header('Location: /index?success=1');
        exit();
    }
}

render('header', ['title' => 'Ajouter un évènement']);
?>


<div class="container">

    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            Merci de corriger vos erreurs
        </div>
    <?php endif; ?>

    <h1>Ajouter un évènement</h1>

    <form action="" method="post" clas="form">
        <?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Ajouter l'évènement</button>
        </div>
    </form>
</div>

<?php render('footer'); ?>