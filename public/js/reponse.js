document.addEventListener("DOMContentLoaded", function () {
    timeline(document.querySelectorAll('.timeline'), {
        mode: 'horizontal',
        visibleItems: 5
    });
});

document.addEventListener('click', function (event) {
    if (!event.target.matches('.theme-switcher')) return;
    event.preventDefault;
    htmlTag = document.getElementById('theme')
    themeLabel = document.getElementById('theme-label')
    currentTheme = htmlTag.dataset.theme;
    themeLabel.innerText = currentTheme === 'dark' ? 'Mode nuit 🌕' : 'Mode jour 🌞'
    htmlTag.dataset.theme = currentTheme === 'dark' ? 'light' : 'dark'

}, false);