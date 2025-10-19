$(document).ready(function() {
    loadPage('home');

    $('#link-to-home').click(function(e) {
        e.preventDefault();
        loadPage('home');
    });

    $('#link-to-notes').click(function(e) {
        e.preventDefault();
        loadPage('notes');
    });

    $('#link-to-login').click(function(e) {
        e.preventDefault();
        loadPage('login');
    });

    $('#link-to-register').click(function(e) {
        e.preventDefault();
        loadPage('register');
    });

    $('#link-to-profile').click(function(e) {
        e.preventDefault();
        loadPage('profile');
    });

    function loadPage(page) {
        $('#main-content').load(`views/${page}.html`);
    }
});