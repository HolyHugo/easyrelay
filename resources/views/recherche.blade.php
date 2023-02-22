<!DOCTYPE html>
<html id="theme" data-theme="dark">

<head>
    <link href="css/index.css" rel="stylesheet" />
    <link href="css/flash.min.css" rel="stylesheet" />
    <link href="css/pico.min.css" rel="stylesheet" />
    <script src="js/index.js"></script>
    <script src="js/flash.min.js"> </script>
</head>

<body>
    <button class="theme-tap contrast  theme-switcher"><i class="theme-switcher" id="theme-label">Mode jour 🌞</i></button>
    <main class="container">
        <h1>Recherche d'arbres de suivis.</h1>
        <form action="/reponse" id="form-recherche" method="POST">

            <div class="grid">
                <label class="flexed-l">Date du jour
                    <input id="date_jour" type="date" value="<?= date("Y-m-d") ?>" name="date_jour" required />
                </label><br />
                <label class="flexed-l">Date d'intervention
                    <input id="date_intervention" type="date" name="date_intervention" required />
                </label>
            </div>

            <label for="traitement"> Traitement </label>
            <select name="traitement" id="traitement">
                <option disabled selected value="">Choisissez ...</option>
                <?php
                foreach ($listeTraitements as $famille => $traitement) {
                    echo "<optgroup label=$famille>";
                    foreach ($traitement as $key => $infos) {
                        echo "<option value=" . $infos['value'] . ">" . $infos['text'] . "</option>";
                    }
                    echo "</optgroup>";
                }
                ?>
            </select>
            <div class="grid">
                <fieldset>
                    <legend>Urgence</legend>
                    <?php
                    foreach ($listeUrgences as $key => $value) :
                        $checked = $key === array_key_first($listeUrgences) ? 'checked' : '';
                    ?>
                        <div>
                            <label>
                                <input autocomplete="off" type="radio" name="urgence" value="<?= $key ?>" <?= $checked ?>>
                                <?= $value ?></label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
                <fieldset>
                    <legend>Risque hémorragique</legend>
                    <?php
                    foreach ($listeRisquesH as $key => $value) :
                        $checked = $key === array_key_first($listeRisquesH) ? 'checked data-weak="1"' : 'data-weak="0"';
                    ?>
                        <div>
                            <label>
                                <input autocomplete="off" type="radio" name="risque-hemorragique" value="<?= $key ?>" <?= $checked ?>>
                                <?= $value ?></label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
                <fieldset class="adaptatif h-elem">
                    <legend>Risque thrombotique</legend>
                    <?php
                    foreach ($listeRisquesT as $key => $value) :
                        $checked = $key === array_key_first($listeRisquesT) ? 'checked' : '';
                    ?>
                        <div>
                            <label>
                                <input autocomplete="off" type="radio" name="risque-thrombotique" value="<?= $key ?>" <?= $checked ?>>
                                <?= $value ?></label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            </div>

            <div class="adaptatif h-elem">
                <label for="fonction-renale">Fonction rénale</label>
                <select name="fonction-renale" id="renale">
                    <option disabled selected value="">Choisissez ...</option>
                    <?php
                    foreach ($listeDebits as $key => $value) {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <input type="submit" value="Chercher" name="submit" />
        </form>
    </main>
</body>

</html>