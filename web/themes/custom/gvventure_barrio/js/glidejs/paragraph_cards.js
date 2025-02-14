(function (Drupal, once) {
  Drupal.behaviors.glideCards = {
    attach: function (context, settings) {
      // Use `once` to apply behavior only once per element
      once(
        "glideInit",
        ".paragraph--type--cards-descripcion .glide",
        context
      ).forEach(function (element) {
        new Glide(element, {
          type: "slider",
          startAt: 0,
          perView: 3,
          swipeThreshold: true,
          dragThreshold: true,
          destroy: true,
          breakpoints: {
            992: {
              perView: 2,
            },
            576: {
              perView: 1,
            },
          },
          gap: 0,
          rewind: false,
          bound: true,
        }).mount();
      });
    },
  };
})(Drupal, once);
