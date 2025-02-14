(function (Drupal) {
  "use strict";

  Drupal.behaviors.tooltip = {
    attach: function () {
      document.querySelectorAll("[data-infotooltip]").forEach((icon) => {
        if (!icon.dataset.processed) {
          icon.dataset.processed = true;
          icon.addEventListener("click", function (e) {
            if (!icon.classList.contains("show-tooltip")) {
              icon.classList.add("show-tooltip");
            }
          });
        }
      });

      if (!document.body.dataset.processed) {
        document.body.dataset.processed = true;
        document.addEventListener("click", function (e) {
          if (!e.target.matches(".input-info__icon")) {
            const tooltip = document.querySelector(".show-tooltip");
            if (tooltip) {
              tooltip.classList.remove("show-tooltip");
            }
          }
        });
      }
    },
  };
})(Drupal);
