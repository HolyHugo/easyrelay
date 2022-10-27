<!DOCTYPE html>
<html>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.css" rel="stylesheet">
    <script src="/ressources/js/flash.min.js"></script>
    <link href="/ressources/css/flash.min.css" rel="stylesheet" />
    <script src="/ressources/js/index.js"></script>
    <link href="/ressources/css/index.css" rel="stylesheet" />


</head>

<body onload="SlimIt()">
    <div class="flex-container">
        <div>
            <div class="flex-item">
                <h1>EasyRelay</h1>
            </div>
            <div id="recherche-bloc" class="flex-item">
                <form action="./reponse.php" method="POST">
                    <h1>Recherche</h1>
                    <label class="flexed-l">Date du jour
                        <input id="date_jour" type="date" value="<?= date("Y-m-d") ?>" name="date_jour" required />
                    </label><br />
                    <label class="flexed-l">Date d'intervention
                        <input id="date_intervention" type="date" name="date_intervention" required />
                    </label>
                    <label for="type-aod"> Traitement </label>
                    <select name="type-aod" id="traitement">
                        <option data-placeholder="true"></option>
                        <optgroup label="AOD">
                            <option value="AOD-3">Eliquis</option>
                            <option value="AOD-2">Pradaxa</option>
                            <option value="AOD-1">Xarelto</option>
                        </optgroup>
                        <optgroup label="AVK">
                            <option value="AVK-3">Previscam</option>
                            <option value="AVK-2">Sintram</option>
                            <option value="AVK-1">Ceudmadine</option>
                        </optgroup>
                    </select>
                    <fieldset>
                        <legend>Urgence</legend>

                        <div>

                            <input autocomplete="off" type="radio" id="non" name="urgence" value="1" checked>
                            <label for="non">Non </label>
                        </div>
                        <div>
                            <input autocomplete="off" type="radio" id="oui" name="urgence" value="2">
                            <label for="oui">Oui </label>
                        </div>
                        <div>
                            <input autocomplete="off" type="radio" id="differenciable" name="urgence" value="3">
                            <label for="differenciable">Différable (+8H) </label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Risque hémorragique</legend>
                        <div class="radios">
                            <input autocomplete="off" type="radio" id="faible" name="risque-hemorragique" value="1" checked>
                            <label for="faible">Faible </label>
                        </div>

                        <div class="radios">
                            <input autocomplete="off" type="radio" id="modere-eleve" name="risque-hemorragique" value="2">
                            <label for="modere-eleve">Modéré / Élevé</label>
                        </div>

                        <div class="radios">
                            <input autocomplete="off" type="radio" id="tres-eleve" name="risque-hemorragique" value="3">
                            <label for="tres-eleve"> Très élevé </label>
                        </div>
                    </fieldset>
                    <fieldset class="adaptatif h-elem">
                        <legend>Risque thrombotique</legend>

                        <div class="radios">
                            <input autocomplete="off" type="radio" id="modere-t" name="risque-thrombotique" value="1" checked>
                            <label for="modere-t">Modéré </label>
                        </div>

                        <div class="radios">

                            <input autocomplete="off" type="radio" id="eleve-t" name="risque-thrombotique" value="2">
                            <label for="eleve-t">Élevé </label>
                        </div>
                    </fieldset>
                    <div class="adaptatif h-elem">
                        <label for="fonction-renale">Fonction rénale</label>
                        <select name="fonction-renale" id="renale">
                            <option data-placeholder="true"></option>
                            <option value="1"> ≥ 50 mL/min</option>
                            <option value="2"> ≥ 30 mL/min</option>
                            <option value="3"> 30-49 mL/min</option>
                        </select>
                    </div>
                    <input type="submit" value="Chercher" name="submit" />
                </form>
            </div>
        </div>
    </div>
</body>

</html>