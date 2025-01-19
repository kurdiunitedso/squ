// Single Responsibility Principle: Handles notification-related functionality
class NotificationService {
    constructor() {
        this.initializeToastr();
    }

    initializeToastr() {
        console.log("Initializing Toastr notifications");
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-bottom-right",
            preventDuplicates: true,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        };
    }

    show(type, message, title = "") {
        console.log(`Showing ${type} notification: ${message}`);
        toastr[type](message, title);
    }
}
