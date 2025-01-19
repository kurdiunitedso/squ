// Single Responsibility Principle: Handles navigation-related functionality
class NavigationService {
    constructor() {
        this.navbar = document.querySelector(".navbar");
        this.navbarToggler = document.querySelector(".navbar-toggler");
        this.logoDefault = document.querySelector(".logo-default");
        this.logoScrolled = document.querySelector(".logo-scrolled");
        this.navLinks = document.querySelectorAll(".nav-link");

        this.init();
    }

    init() {
        // console.log("Initializing NavigationService");
        this.setupEventListeners();
        this.setInitialState();
        this.setActiveNavItem();
    }

    setupEventListeners() {
        // console.log("Setting up navigation event listeners");
        this.navbarToggler.addEventListener("click", () =>
            this.handleNavbarToggle()
        );
        window.addEventListener("scroll", () => this.handleScroll());
    }

    setInitialState() {
        // console.log("Setting initial navigation state");
        this.navbar.classList.add("navbar-top");
    }

    handleNavbarToggle() {
        // console.log("Handling navbar toggle");
        const isExpanded =
            this.navbarToggler.getAttribute("aria-expanded") === "true";

        if (isExpanded) {
            this.applyExpandedState();
        } else {
            this.applyCollapsedState();
        }
    }

    handleScroll() {
        // console.log("Handling scroll event");
        const scrollThreshold = 100;

        if (window.scrollY < scrollThreshold) {
            this.applyCollapsedState();
        } else {
            this.applyExpandedState();
        }
    }

    applyExpandedState() {
        // console.log("Applying expanded navigation state");
        this.navbar.classList.remove("navbar-top");
        this.navbar.classList.add("navbar-down");
        this.logoScrolled.classList.remove("d-none");
        this.logoDefault.classList.add("d-none");
        this.navbarToggler.classList.remove("bg-white");
    }

    applyCollapsedState() {
        // console.log("Applying collapsed navigation state");
        this.navbar.classList.add("navbar-top");
        this.navbar.classList.remove("navbar-down");
        this.logoDefault.classList.remove("d-none");
        this.logoScrolled.classList.add("d-none");
        this.navbarToggler.classList.add("bg-white");
    }

    setActiveNavItem() {
        // console.log("Setting active navigation item");
        const currentPath = window.location.pathname;
        this.navLinks.forEach((link) => {
            if (link.getAttribute("href") === currentPath) {
                link.classList.add("active");
            }
        });
    }
}
