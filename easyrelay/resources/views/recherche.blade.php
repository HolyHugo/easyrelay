<!DOCTYPE html>
<html>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.css" rel="stylesheet">
    <link href="{{ URL::asset('/css/index.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('/css/flash.min.css') }}" rel="stylesheet" />
    <script src="{{ URL::asset('/js/index.js') }}"></script>
    <script src="{{ URL::asset('/js/flash.min.js') }}"> </script>
</head>

<body onload="SlimIt()">
    <div class="flex-container">
        <div>
            <div class="flex-item">
                <h1>EasyRelay</h1>
            </div>
            <div id="recherche-bloc" class="flex-item">
                <form action="/reponse" id="form-recherche" method="POST">
                    <h1>Recherche</h1>
                    <label class="flexed-l">Date du jour
                        <input id="date_jour" type="date" value="<?= date("Y-m-d") ?>" name="date_jour" required />
                    </label><br />
                    <label class="flexed-l">Date d'intervention
                        <input id="date_intervention" type="date" name="date_intervention" required />
                    </label>
                    <label for="traitement"> Traitement </label>
                    <select name="traitement" id="traitement">
                        <option data-placeholder="true"></option>
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
                    <div class="adaptatif h-elem">
                        <label for="fonction-renale">Fonction rénale</label>
                        <select name="fonction-renale" id="renale">
                            <option data-placeholder="true"></option>
                            <?php
                            foreach ($listeDebits as $key => $value) {
                                echo '<option value="' . $key . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" value="Chercher" name="submit" />
                </form>
            </div>
        </div>
    </div>
</body>

</html>