import loadGames from "./games.js"
import loadLeaderboard from "./leaderboard.js"
import createForm from "./player.js"

function main() {
    loadGames(loadLeaderboard)
        .then(() => createForm())
}

document.getElementById("title").addEventListener("click", main)

main()
