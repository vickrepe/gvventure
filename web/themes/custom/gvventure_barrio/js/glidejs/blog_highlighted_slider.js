(function (Drupal, once) {
  Drupal.behaviors.glideSlider = {
    attach: function (context, settings) {
      // Use `once` to apply behavior only once per element
      once("glideInit", ".glide", context).forEach(function (element) {
        const glide = new Glide(element, {
          type: "slider",
          startAt: 0,
          perView: 3,
          swipeThreshold: false,
          dragThreshold: false,
          breakpoints: {
            992: {
              perView: 2,
              swipeThreshold: true,
            },
            768: {
              perView: 1,
              swipeThreshold: true,
            },
          },
          gap: 24,
          rewind: false,
          bound: true,
        }).mount();

        function handleMobileView() {
          const bulletContainer = document.querySelector(
            '.glide__bullets[data-glide-el="controls[nav]"]'
          );
          const slideElements = document.querySelectorAll(".glide__slide");

          if (window.matchMedia("(max-width: 768px)").matches) {
            //DOM modifications for mobile view
            bulletContainer.innerHTML = "";
            // Create new bullets
            for (let i = 0; i < slideElements.length; i++) {
              // Create a new button element
              const bullet = document.createElement("button");
              bullet.className = "glide__bullet"; // Add active class for the first bullet
              bullet.setAttribute("data-glide-dir", `=${i}`); // Set the data-glide-dir attribute
              bulletContainer.appendChild(bullet); // Append the bullet to the container
            }
            glide.mount().update();
          } else {
            bulletContainer.innerHTML = "";
            const pages =
              slideElements.length % 3 == 0
                ? Math.floor(slideElements.length / 3)
                : Math.floor(slideElements.length / 3) + 1; // Integer division

            if (pages == 1) return;

            for (let i = 0; i < pages; i++) {
              // Create a new button element
              const bullet = document.createElement("button");
              bullet.className = "glide__bullet";
              bullet.setAttribute("data-glide-dir", `=${i * 3}`);
              bulletContainer.appendChild(bullet);
            }
            glide.mount().update();
          }
        }
        // Run on initial load
        handleMobileView();
        window.addEventListener("resize", handleMobileView);
      });
    },
  };
})(Drupal, once);
