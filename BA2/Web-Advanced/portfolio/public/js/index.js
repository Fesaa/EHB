import loadGames from "./games.js"
import loadLeaderboard from "./leaderboard.js"

function main() {
    loadGames(loadLeaderboard)
}

document.getElementById("title").addEventListener("click", main)

main()
