/* OEFENING 1*/
console.log("Hello World, this script has been loaded.")


/* OEFENING 2*/
els = document.getElementsByTagName("header")
var head = null
if (els != null && els.length > 0) {
    head = els[0]
}

download_a = document.getElementById("download")
if (download_a != null) {
    download_a.addEventListener("click", function() {
        download_a.textContent = "Login first"
        download_a.style = "font-weight: bold; color: white;"
    })
}

/* OEFENING 3*/
//  Header met navigatie verdwijnt bij naar beneden scrollen 
// en verschijnt weer na omhoog scrollen

old_scrollY = 0
nav_els = document.getElementsByTagName("nav")
if (nav_els != null && nav_els.length > 0) {
    nav = nav_els[0]
    window.addEventListener("scroll", function() {
        if (this.window.scrollY < 0 || this.window.scrollY > window.screen.height) {
            old_scrollY = window.scrollY
            return
        }
        if (window.scrollY < old_scrollY) {
            nav.classList.add("hidden")
        } else {
            nav.classList.remove("hidden")
        }
        old_scrollY = window.scrollY
    })
}

/*
Nodige event: window.scroll (it is een event van het window-object ipv document)

Voeg zodra er gescrolled wordt een klasse 'hidden' toe aan de navigatie
Verwijder deze klasse zodra er omhoog gescolled wordt.
Definieer de hidden klasse in je CSS en geef ze display:hidden

window.pageYoffset

geeft het aantal pixels terug dat het document op een bepaald moment gescrolled is in verticale richting

*/






