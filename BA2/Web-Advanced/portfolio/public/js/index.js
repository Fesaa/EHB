const BASE_URL = "https://ameliah.art/cubepanion_api/"
const STATUS_MSG = document.getElementById("status_msg")
const HOLDER = document.getElementById("holder")

function loadGames() {
    const url = BASE_URL + "leaderboard_api/games/false"

    fetch(url)
        .catch(err => {
            console.log("An error occured fetching games...", err)
            STATUS_MSG.innerText = "We encountered an error loading the required data."
        })
        .then(res => {
            if (res.status != 200) {
                STATUS_MSG.innerText = "Backend API returned non 200 code. Can't load the required data.'"
                return
            }

            const games = res.json
            console.log(games)
            for (const game of games) {
                const d = document.createElement("div")
                d.innerText = game.display_name
                HOLDER.append(d)
            }
        })
}


loadGames()
