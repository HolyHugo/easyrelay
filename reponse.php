<?php
function dateChecking($dateJour, $dateIntervention)
{
    return $dateIntervention > $dateJour;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['submit'])) {
    header("Location:./index.php");
    die;
}
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
                <div class="timeline__item">
                    <div class="timeline__content">
                        Arret coagulant
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                        Intervention prévue le <?= $formatter->format($dateIntervention) ?>
                    </div>
                </div>
                <div class="timeline__item">
                    <div class="timeline__content">
                        Reprise coagulant
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>