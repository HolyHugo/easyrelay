<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('./classes/Procedure.php');


function dateChecking($dateJour, $dateIntervention)
{
    return $dateIntervention > $dateJour;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['submit'])) {
    header("Location:./index.php");
    die;
}
$fonctionRenale = $_POST['fonction-renale'] === '' ? 0 :  $_POST['fonction-renale'];
$dateJour = DateTime::createFromFormat('Y-m-d', $_POST['date_jour']);
$dateIntervention = DateTime::createFromFormat('Y-m-d', $_POST['date_intervention']);
if (!dateChecking($dateJour, $dateIntervention)) {
    echo "Attention ! Vous avez renseignez une date d'intervention antérieur à la date du jour.";
    header("refresh:5;url=./index.php");
    die;
}

$formatter = new IntlDateFormatter(
    'fr_FR',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    'Europe/Paris',
    IntlDateFormatter::GREGORIAN
);

$exploded = explode('-', $_POST['type-ac']);
$traitement = $exploded[1];
$familleTraitement = $exploded[0];
$procedure = new Procedure(
    $traitement,
    $familleTraitement,
    $_POST['risque-hemorragique'],
    $_POST['risque-thrombotique'],
    $fonctionRenale,
    $dateJour,
    $dateIntervention
);
$infos = $procedure->getInformations();
$arret = $infos['preOp'];
$inOp = $infos['inOp'];
$reprise = $infos['postOp'];
?>
<!DOCTYPE html>
<html>

<head>
    <script src="/ressources/js/timeline.min.js"></script>
    <link href="/ressources/css/timeline.min.css" rel="stylesheet" />
    <script src="/ressources/js/reponse.js"></script>
    <link href="/ressources/css/reponse.css" rel="stylesheet" />
</head>

<body>
    <br />
    <br />
    <div class="timeline" data-mode="horizontal">
        <div class="timeline__wrap">
            <div class="timeline__items">
                <div class="timeline__item">
                    <div class="timeline__content">
                        Consultation du <?= $formatter->format($dateJour) ?>
                    </div>
                </div>
                <?php if ($arret['arret']) : ?>
                    <div class="timeline__item">
                        <div class="timeline__content">
                            <p>Arret des anti-coagulant à <?= $arret['l-arret'] ?> le <?= $formatter->format($arret['d-arret']) ?></p>
                            <p><?= $arret['description'] ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="timeline__item">
                    <div class="timeline__content">
                        Intervention prévue le <?= $formatter->format($dateIntervention) ?>
                        <p><?= $inOp['description'] ?></p>
                    </div>
                </div>
                <?php if ($reprise['reprise']) : ?>
                    <div class="timeline__item">
                        <div class="timeline__content">
                            Reprise anti-coagulant à <?= $reprise['l-reprise'] ?>
                            <p><?= $reprise['description'] ?></p>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>

</html>