

export function showNavbar(toggleId, navId, headerId, bodyId) {
    const toggle = document.getElementById(toggleId),
      nav = document.getElementById(navId),
      headerpd = document.getElementById(headerId),
      body = document.getElementById(bodyId);

    if (toggle && nav && headerpd) {
      // show navbar
      nav.classList.toggle("open");
      // change icon
      toggle.classList.toggle("bx-x");

      headerpd.classList.toggle("body-pd");

      body.classList.toggle("body-pd");
    }
}
