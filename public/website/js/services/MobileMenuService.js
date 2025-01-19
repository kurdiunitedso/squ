// Single Responsibility Principle: Handles mobile menu functionality
class MobileMenuService {
    constructor() {
        // Using the correct selectors from your HTML
        this.mobileMenu = document.querySelector(".navbar-toggler");
        this.navLinks = document.querySelector(".nav-links");
        this.navbarCollapse = document.querySelector(".navbar-collapse");

        if (this.validateElements()) {
            this.init();
        }
    }

    validateElements() {
        // console.log("Validating mobile menu elements");
        if (!this.mobileMenu) {
            console.error("Mobile menu button not found");
            return false;
        }
        if (!this.navLinks) {
            console.error("Nav links container not found");
            return false;
        }
        return true;
    }

    init() {
        // console.log("Initializing MobileMenuService");
        this.setupEventListeners();
    }

    setupEventListeners() {
        // console.log("Setting up mobile menu event listeners");
        try {
            this.mobileMenu.addEventListener("click", (e) =>
                this.toggleMenu(e)
            );
        } catch (error) {
            console.error(
                "Error setting up mobile menu event listeners:",
                error
            );
        }
    }

    toggleMenu(event) {
        // console.log("Toggling mobile menu");
        try {
            // Let Bootstrap handle the collapse
            // The actual toggling is handled by Bootstrap's collapse plugin
            this.mobileMenu.classList.toggle("active");

            // Additional custom classes if needed
            if (this.navbarCollapse.classList.contains("show")) {
                this.navLinks.classList.add("show");
            } else {
                this.navLinks.classList.remove("show");
            }
        } catch (error) {
            console.error("Error toggling mobile menu:", error);
        }
    }
}
