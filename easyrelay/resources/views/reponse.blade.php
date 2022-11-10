<?php
const LABELS  = [
    'urgence' => 'Urgence',
    'risque_h' => 'Risque Hémorragique',
    'risque_t' => 'Risque Thrombotique',
    'debit_renal' => 'Fonction rénale',
    'traitement' => 'Traitement',
    'famille_traitement' => 'Type de traitement',
];
?>
<!DOCTYPE html>
<html>

<head>
    <script src="{{ URL::asset('/js/timeline.min.js')}}"></script>
    <link href="{{ URL::asset('/css/timeline.min.css')}}" rel="stylesheet" />
    <script src="{{ URL::asset('/js/reponse.js')}}"></script>
    <link href="{{ URL::asset('/css/reponse.css')}}" rel="stylesheet" />
</head>

<body>
    <bt />
    <bt />
    <div>
        <h2>Rappel des critères.</h2>
        <?php
        foreach ($criteres as $key => $value) {
            echo "<p>" . LABELS[$key]  . " : " . $value . "</p>";
        }
        ?>
    </div>
    <br />
    <br />
    <div class="timeline" data-mode="horizontal">
        <div class="timeline__wrap">
            <div class="timeline__items">
                <div class="timeline__item">
                    <div class="timeline__content">
                        Consultation du <?= $infos['date_jour'] ?>
                    </div>
                </div>
                <?php foreach ($infos['preOpInfos'] as $key => $values) :
                ?>
                    <div class="timeline__item">
                        <div class="timeline__content">
                            <?= $values['short_desc'] ?> : <?= $values['dateJ'] ?> <br />
                            <?= $values['long_desc'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="timeline__item">
                    <div class="timeline__content">
                        Intervention le <?= $infos['date_intervention'] ?>
                        <?php foreach ($infos['inOpInfos'] as $key => $values) : ?>
                            <br />
                            <?= $values['long_desc'] ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php foreach ($infos['postOpInfos'] as $key => $values) :
                ?>
                    <div class="timeline__item">
                        <div class="timeline__content">
                            <?= $values['short_desc'] ?> : <?= $values['dateJ'] ?> <br />
                            <?= $values['long_desc'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>

<?php /* if ($arret['arret']) : ?>
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