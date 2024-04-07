const BASE_URL = "https://ameliah.art/cubepanion/"
const STATUS_MSG = document.getElementById("status_msg")
const HOLDER = document.getElementById("holder")

function createForm() {
    const form = document.createElement("form")
    form.classList.add("player-form")

    const text = document.createElement("input")
    text.type = "text"
    text.classList.add("player-text")

    const submit = document.createElement("input")
    submit.value = "Search player"
    submit.type = "submit"
    submit.classList.add("player-submit")
    submit.addEventListener("click", async (e) => {
        e.preventDefault()

        const valid = /^[a-zA-Z0-9_]{3,16}$/.test(text.value)
        if (!valid) {
            HOLDER.innerHTML = ""
            STATUS_MSG.innerText = "Player must only container letters, numbers, and underscore and be between 3 and 16 in length."
            createForm()
            return
        }

        await loadPlayerLeaderboards(text.value)
    })

    form.appendChild(text)
    form.appendChild(submit)

    HOLDER.appendChild(form)
}

async function loadPlayerLeaderboards(name) {
    const url = BASE_URL + "leaderboard/player/" + name

    try {
        const res = await fetch(url)

        const table = document.createElement("table")
        table.classList.add("leaderboard-table")

        const header = document.createElement("tr")
        header.innerHTML = `
            <th>Game</th>
            <th>Position</th>
            <th>Score</th>
            `

        table.append(header)

        const rows = await res.json()
        for (const entry of rows) {
            const tr = document.createElement("tr")
            tr.innerHTML = `
                <td class="leaderboard-entry-position">${entry.game}</td>
                <td class="leaderboard-entry-name">${entry.position}</td>
                <td class="leaderboard-entry-score">${entry.score}</td>
                `

            table.append(tr)
        }

        HOLDER.innerHTML = ""
        HOLDER.append(table)

    } catch (err) {
        console.log(err)
    }

}


export default createForm;
