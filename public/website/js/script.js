// App.js
// Application initialization
document.addEventListener("DOMContentLoaded", () => {
    console.log("Initializing application services");

    // Initialize services
    const navigationService = new NavigationService();
    const mobileMenuService = new MobileMenuService();
    const notificationService = new NotificationService();

    // Initialize carousel with RTL support
    const carouselService = new CarouselService(".owl-carousel", {
        rtl: document.documentElement.lang !== "en",
    });
});
