/**
 * MENÜ
 */
const menuItems = document.querySelectorAll("menu ul li");
const container = document.getElementById("main-content");

menuItems.forEach((menuItem, i, allitems) => {
  menuItem.addEventListener("click", (e) => {
    console.log(e);
    // entfernt "active" von allen menupunkten
    allitems.forEach((single) => single.classList.remove("active"));
    // setzt "active" Klasse
    e.currentTarget.classList.add("active");
    // die Seite wird mit der restapi geladen
    displayContent(e.currentTarget.id);
  });
});

const displayContent = (pageId) => {
  console.log("PAGE ID", pageId);

  fetch(`content/${pageId}-page.html`)
    .then((res) => res.text())
    .then((data) => {
      container.innerHTML = data;

      // lädt die Scripts aus dem HTML und aktualisiert sie
      var scripts = container.querySelectorAll("script");

      scripts.forEach((script) => {
        if (script.innerHTML) {
          eval(script.innerText);
        }
      });
    });
};

// Startet mit der ersten Seite
displayContent("restapi");
