document.addEventListener('click', function (event) {
    if (!event.target.matches('.theme-switcher')) return;
    event.preventDefault;
    htmlTag = document.getElementById('theme')
    themeLabel = document.getElementById('theme-label')
    currentTheme = htmlTag.dataset.theme;
    themeLabel.innerText = currentTheme === 'dark' ? 'Mode nuit 🌕' : 'Mode jour 🌞'
    htmlTag.dataset.theme = currentTheme === 'dark' ? 'light' : 'dark'

},false);

function areDatesValid() {
    let dateJour = document.getElementById('date_jour').value;
    let dateIntervention = document.getElementById('date_intervention').value;
    if (dateIntervention < dateJour) {
        window.FlashMessage.error("La date d'intervention doit être postérieure à la date du jour.");
        return false;
    }
    return true;
}

function checkRenale() {
    let risqueHemo = document.querySelector('input[name="risque-hemorragique"]:checked').dataset.weak
    let selectRenale = document.getElementById("renale");
    if (risqueHemo != 1 && !selectRenale.value) {
        window.FlashMessage.error("Veuillez choisir une option rénale.");
        return false
    }
    return true
}
function checkTraitement() {
    let selectTraitement = document.getElementById("traitement");
    if (!selectTraitement.value) {
        window.FlashMessage.error("Veuillez choisir un traitement.");
        return false
    }
    return true
}

document.addEventListener("DOMContentLoaded", function () {
    const elementsAdaptatif = document.getElementsByClassName("adaptatif");
    const risquesHemo = document.querySelectorAll('input[name="risque-hemorragique"]');
    risquesHemo.forEach(risque => {
        risque.addEventListener('click', function () {
            for (let elem of elementsAdaptatif) {
                elem.classList.remove("h-elem");
                elem.classList.add("s-elem")
                if (risque.dataset.weak == 1) {
                    elem.classList.add("h-elem");
                    elem.classList.remove("s-elem")
                }
            }
        });
    });

    onsubmit = (event) => {
        if (!areDatesValid() || !checkTraitement() || !checkRenale()) {
            event.preventDefault();
            return;
        }
        return true;
    };
});