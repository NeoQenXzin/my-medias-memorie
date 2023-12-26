const linkAdd = document.getElementById('link-add')
const linkGestionCrud = document.getElementById('link-gestion-crud')
const linkMesMedias = document.getElementById('link-mes-medias')

linkAdd.addEventListener('click', () => location.href = 'index.php')
linkGestionCrud.addEventListener('click', () => location.href = 'gestion_livres.php')
linkMesMedias.addEventListener('click', () => location.href = 'my-med.php')


document.addEventListener('DOMContentLoaded', function () {
    const linkHome = document.getElementById('link-home');
    const linkAdd = document.getElementById('link-add');
    const linkGestionCrud = document.getElementById('link-gestion-crud');

    const currentPage = window.location.pathname;

    if (currentPage.includes('index.php')) {
        linkAdd.classList.add('active');
    } else if (currentPage.includes('my-med.php')) {
        linkMesMedias.classList.add('active');
    } else if (currentPage.includes('gestion_livres.php')) {
        linkGestionCrud.classList.add('active');
    }
});


//navbar responsive
// document.addEventListener('DOMContentLoaded', function () {
//     const menuIcon = document.querySelector('.menu-icon');
//     const nav = document.querySelector('.nav');

//     menuIcon.addEventListener('click', function () {
//         nav.classList.toggle('active');
//     });

//     // Fermer le menu lorsque vous cliquez sur un lien
//     document.querySelectorAll('.nav li:not(.logo)').forEach(function (link) {
//         link.addEventListener('click', function () {
//             nav.classList.remove('active');
//         });
//     });
// });
