<?php

require '../src/bootstrap.php';

use Calendar\Events;
use Calendar\EventValidator;

$pdo = get_pdo();
$events = new Events($pdo);
$errors = [];

try {
    $event = $events->find($_GET['id'] ?? null);
} catch (\Exception $e) {
    e404();
} catch (\Error $e) {
    e404();
}

$data = [
    'name' => $event->getName(),
    'description' => $event->getDescription(),
    'date' => $event->getStart()->format('Y-m-d'),
    'start' => $event->getStart()->format('H:i'),
    'end' => $event->getEnd()->format('H:i'),
];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $validator = new EventValidator();
    $errors = $validator->validates($data);
    if(empty($errors)) {
        $events->hydrate($event, $data);
        $events->update($event);
        header('Location: /index?success=1');
        exit();
    }
}

render('header', ['title' => $event->getName()]);
?>

<div class="container">
    <h1>Modifier l'évènement : <small><?= h($event->getName()); ?></small></h1>

    <form action="" method="post" clas="form">
        <?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Modifier l'évènement</button>
        </div>
    </form>
</div>

<?php render('footer'); ?>