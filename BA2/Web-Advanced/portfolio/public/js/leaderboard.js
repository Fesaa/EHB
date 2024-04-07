const BASE_URL = "https://ameliah.art/cubepanion/"
const STATUS_MSG = document.getElementById("status_msg")
const HOLDER = document.getElementById("holder")

let rows = []
let lastGame = ""

function leaderboardEntry(entry, scoreType) {
    const tr = document.createElement("tr")
    tr.innerHTML = `
        <td class="leaderboard-entry-position">${entry.position}</td>
        <td class="leaderboard-entry-name">${entry.player}</td>
        <td class="leaderboard-entry-score">${entry.score} ${scoreType}</td>
    `

    const playerName = localStorage.getItem("cubepanion:player-name")
    if (playerName == entry.player) {
        tr.style.background = "limegreen"
    }

    return tr
}

function leaderboardGameTitle(gameName) {
    const d = document.createElement("div")
    d.classList.add("leaderboard-game-title")
    d.innerText = gameName
    return d
}

function setRows(gameName, scoreType) {
    STATUS_MSG.innerText = ""
    const gameTitle = leaderboardGameTitle(gameName)
    HOLDER.append(gameTitle)

    const table = document.createElement("table")
    table.classList.add("leaderboard-table")

    const header = document.createElement("tr")
    header.innerHTML = `
        <th>Position</th>
        <th>Name</th>
        <th>Score</th>
    `
    table.append(header)
    for (const row of rows) {
        table.append(leaderboardEntry(row, scoreType))
    }
    HOLDER.append(table)
}

function loadLeaderboard(gameName, scoreType) {
    const url = BASE_URL + "leaderboard/game/" + gameName + "/bounded?lower=0&upper=50"
    HOLDER.innerHTML = ""
    if (gameName == lastGame && rows.length > 0) {
        setRows(gameName, scoreType)
        return
    }

    STATUS_MSG.innerText = "Loading leaderboard for " + gameName + "..."
    HOLDER.classList.add("wait-animation")

    fetch(url)
        .catch(err => {
            console.log("An error occured fetching leaderboard...", err)
            STATUS_MSG.innerText = "We encountered an error loading the required data."
        })
        .then(async res => {
            if (res.status != 200) {
                STATUS_MSG.innerText = "Backend API returned non 200 code. Can't load the required data.'"
                return
            }
            rows = await res.json()
            lastGame = gameName
            setTimeout(() => {
                HOLDER.classList.remove("wait-animation")
                setRows(gameName, scoreType)
            }, 1000)
        })
}


export default loadLeaderboard
