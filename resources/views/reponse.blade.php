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
<html id="theme" data-theme="dark">

<head>
    <script src="js/timeline.min.js"></script>
    <link href="css/timeline.min.css" rel="stylesheet" />
    <script src="js/reponse.js"></script>
    <link href="css/index.css" rel="stylesheet" />
    <link href="css/pico.min.css" rel="stylesheet" />

</head>

<body>
    
<button onclick="window.location='{{url("/") }}'" class="retour-tap contrast">Retour </button>
    <main class="container">
        <div>
            <h2>Rappel des critères.</h2>
            <div class="grid">
                <?php
                foreach ($criteres as $key => $value) {
                    echo "<p>" . LABELS[$key]  . " : " . $value . "</p>";
                }
                ?>
            </div>
        </div>
        <br />
        <br />
        <div class="timeline" data-mode="vertical">
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
    </main>
    <button class="theme-tap contrast  theme-switcher"><i class="theme-switcher" id="theme-label">Mode jour 🌞</i></button>
</body>

</html>