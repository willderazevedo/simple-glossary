(() => {
  const wrapperClass = glossaryData.class || "glossary-wrapper";

  const containers = document.querySelectorAll(`.${wrapperClass}`);

  if (!containers.length) return false;

  containers.forEach((container) => {
    let content = container.innerHTML;

    glossaryData.terms.forEach((glossary) => {
      let expression = `\\b${glossary.title}(?=[^<>]*(?:<|<|$))`;

      let regex = new RegExp(expression, "gmi");

      if (regex.exec(content) == null) return;

      content = content.replace(
        regex,
        `
          <a 
            class="term-link"
            ${glossary.category ? `title="${glossary.category}"` : ""}
            data-bs-toggle="popover"
            data-bs-content='${he.encode(glossary.content)}'
          >
            ${glossary.title.trim()}
          </a>
        `,
      );

      content = content.replace(/\s+(?=,)/gm, "");
      content = content.replace(/\s+(?=\.)/gm, "");
    });

    container.innerHTML = content;
  });

  document.querySelectorAll(".term-link").forEach((element) => {
    new bootstrap.Popover(element, {
      html: true,
      sanitize: false,
      animation: false,
      placement: "top",
      trigger: "hover",
      customClass: "term-popover",
      container: jQuery(element),
    });

    element.addEventListener("show.bs.popover", function () {
      setTimeout(() => {
        let popover = jQuery(element).find(".popover");

        let position = popover.data("popper-placement");

        if (position === "right") {
          popover.css({ "margin-left": "-7px" });
        }

        if (position === "left") {
          popover.css({ "margin-right": "-7px" });
        }

        if (position === "top") {
          popover.css({ "margin-bottom": "-10px" });
        }

        if (position === "bottom") {
          popover.css({ "margin-top": "-10px" });
        }
      });
    });
  });
})();
