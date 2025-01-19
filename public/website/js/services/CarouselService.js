// Single Responsibility Principle: Handles carousel-related functionality
class CarouselService {
    constructor(selector, options = {}) {
        this.selector = selector;
        this.options = this.mergeOptions(options);

        this.init();
    }

    init() {
        console.log("Initializing CarouselService");
        this.initializeCarousel();
    }

    mergeOptions(customOptions) {
        console.log("Merging carousel options");
        const defaultOptions = {
            autoplay: true,
            center: false,
            loop: true,
            nav: false,
            dots: false,
            autoplayTimeout: 6000,
            margin: 20,
            stagePadding: 0,
            responsive: {
                0: { items: 1, margin: 0 },
                576: { items: 2, margin: 10 },
                992: { items: 3, margin: 15 },
                1200: { items: 4, margin: 20 },
            },
        };

        return { ...defaultOptions, ...customOptions };
    }

    initializeCarousel() {
        console.log("Initializing Owl Carousel");
        $(this.selector).owlCarousel({
            ...this.options,
            onInitialized: () => {
                console.log("Carousel initialized, refreshing layout");
                setTimeout(() => {
                    this.refreshCarousel();
                }, 100);
            },
        });
    }

    refreshCarousel() {
        console.log("Refreshing carousel layout");
        $(this.selector).trigger("refresh.owl.carousel");
    }
}
