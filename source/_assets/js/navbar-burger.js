const addEventListenerToNavbarBurger = () => {
    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach(element => {
            element.addEventListener('click', () => {
                console.log('click', element);
                // Get the target from the "data-target" attribute
                const target = element.dataset.target;
                const $target = document.getElementById(target);
                // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                element.classList.toggle('is-active');
                $target.classList.toggle('is-active');
            });
        });
    }
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", addEventListenerToNavbarBurger);
} else {  // `DOMContentLoaded` already fired
    addEventListenerToNavbarBurger();
}