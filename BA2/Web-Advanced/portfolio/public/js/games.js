const BASE_URL = "https://ameliah.art/cubepanion/"
const STATUS_MSG = document.getElementById("status_msg")
const HOLDER = document.getElementById("holder")

let games = []

function setGames(eventFunction) {
    STATUS_MSG.innerText = ""
    HOLDER.innerHTML = ""
    for (const game of games) {
        const dn = game.display_name
        HOLDER.append(gameHolder(dn,
            (_) => eventFunction(dn, game.score_type)))
    }
}

function gameHolder(gameName, eventFunction) {
    const d = document.createElement("div")
    d.classList.add("game-holder")
    d.innerText = gameName
    d.addEventListener("click", eventFunction)
    return d
}

async function loadGames(eventFunction) {
    const url = BASE_URL + "games/false"
    if (games.length > 0) {
        setGames(eventFunction)
        return
    }

    try {
        const res = await fetch(url)
        if (res.status != 200) {
            STATUS_MSG.innerText = "Backend API returned non 200 code. Can't load the required data.'"
            return
        }

        games = await res.json()
        games.sort()
        setGames(eventFunction)
    } catch (err) {
        console.log("An error occured fetching games...", err)
        STATUS_MSG.innerText = "We encountered an error loading the required data."
        return Promise.reject("Error loading games")
    }

    return Promise.resolve()
}

export default loadGames
