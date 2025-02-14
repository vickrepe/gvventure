(function (Drupal, once) {
  Drupal.behaviors.glideProductos = {
    attach: function (context, settings) {
      once("glideInit", ".glide", context).forEach(function (element) {
        new Glide(element, {
          type: "slider",
          startAt: 0,
          perView: 3,
          swipeThreshold: false,
          dragThreshold: false,
          gap: 24,
          rewind: false,
          breakpoints: {
            600: {
              perView: 1,
            },
          },
        }).mount();
      });
    },
  };

  Drupal.behaviors.bootstrapCarousels = {
    attach: function (context, settings) {
      const carousels = once("bootstrap-carousel", ".carousel", context);

      carousels.forEach((carousel) => {
        const indicators = carousel.querySelectorAll(
          ".carousel-indicators button"
        );
        const slides = carousel.querySelectorAll(
          ".carousel-inner .carousel-item"
        );

        if (slides.length > 0 && indicators.length > 0) {
          slides.forEach((slide, index) => {
            slide.classList.toggle("active", index === 0);
          });

          indicators.forEach((indicator, index) => {
            indicator.classList.toggle("active", index === 0);
            indicator.setAttribute(
              "aria-current",
              index === 0 ? "true" : "false"
            );
          });
        }

        new bootstrap.Carousel(carousel, {
          interval: false,
          wrap: true,
        });
      });
    },
  };
})(Drupal, once);
