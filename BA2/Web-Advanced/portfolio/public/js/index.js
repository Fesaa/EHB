import loadGames from "./games.js"
import loadLeaderboard from "./leaderboard.js"
import createForm from "./player.js"



function setNameSetter() {
    const d = document.getElementById("name-setter")
    d.innerHTML = ""

    const form = document.createElement("form")
    form.classList.add("player-form")

    const text = document.createElement("input")
    text.type = "text"
    text.classList.add("player-text")

    const submit = document.createElement("input")
    submit.value = "Set your name"
    submit.type = "submit"
    submit.classList.add("player-submit")
    submit.addEventListener("click", async (e) => {
        e.preventDefault()
        localStorage.setItem("cubepanion:player-name", text.value)
    })

    form.appendChild(text)
    form.appendChild(submit)

    d.append(form)
}


function main() {
    setNameSetter()

    loadGames(loadLeaderboard)
        .then(() => createForm())
}

document.getElementById("title").addEventListener("click", main)

main()
