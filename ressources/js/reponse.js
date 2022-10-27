document.addEventListener("DOMContentLoaded", function () {
    timeline(document.querySelectorAll('.timeline'), {
        mode: 'horizontal',
        visibleItems: 4
    });
});