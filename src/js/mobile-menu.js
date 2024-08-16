document.addEventListener("turbo:load", function () {

    const toggles = document.querySelectorAll('.mobile-menu-toggle');
    toggles.forEach(toggle => {

        toggle.addEventListener('click', function (e) {
            console.log('mobile-menu-toggle');
            e.preventDefault();
            document.querySelector('#page').classList.toggle('mobile-menu-open');
        });
    });

    document.body.addEventListener('click', function (e) {
        if (!e.target.closest('.mobile-menu-toggle') && !e.target.closest('#mobile-menu-container')) {
            document.querySelector('#page').classList.remove('mobile-menu-open');
        }
    });

});