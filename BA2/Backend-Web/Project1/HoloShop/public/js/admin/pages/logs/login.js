const filterEmail = document.getElementById('loginlogs-filter-email');
const filterIp = document.getElementById('loginlogs-filter-ip');
const filterUserAgent = document.getElementById('loginlogs-filter-user-agent');
const filterOutcome = document.getElementById('loginlogs-filter-outcome');
const filterTime = document.getElementById('loginlogs-filter-time');

const rows = document.getElementsByTagName('tr') ;

function filterRows(val, index) {
    for (let i = 2; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('th');
        const cell = cells[index];
        if (cell) {
            if (cell.innerText.includes(val)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
}

filterEmail.addEventListener('change', function () {
    filterRows(this.value, 0);
})
filterIp.addEventListener('change', function () {
    filterRows(this.value, 1);
})
filterUserAgent.addEventListener('change', function () {
    filterRows(this.value, 2);
})
filterOutcome.addEventListener('change', function () {
    filterRows(this.value, 3);
})
filterTime.addEventListener('change', function () {
    filterRows(this.value, 4);
})
