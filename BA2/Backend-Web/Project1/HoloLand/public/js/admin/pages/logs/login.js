const filterEmail = document.getElementById('loginlogs-filter-email');
const filterIp = document.getElementById('loginlogs-filter-ip');
const filterUserAgent = document.getElementById('loginlogs-filter-user-agent');
const filterOutcome = document.getElementById('loginlogs-filter-outcome');
const filterTime = document.getElementById('loginlogs-filter-time');

const rows = document.getElementsByTagName('tr') ;

function filterRows() {
    for (let i = 2; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('th');
        if (cells) {
            if (cells[0].innerText.toLowerCase().includes(filterEmail.value.toLowerCase())
                && cells[1].innerText.toLowerCase().includes(filterIp.value.toLowerCase())
                && cells[2].innerText.toLowerCase().includes(filterUserAgent.value.toLowerCase())
                && cells[3].innerText.toLowerCase().includes(filterOutcome.value.toLowerCase())
                && cells[4].innerText.toLowerCase().includes(filterTime.value.toLowerCase())) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
}

filterEmail.addEventListener('change', function () {
    filterRows();
})
filterIp.addEventListener('change', function () {
    filterRows();
})
filterUserAgent.addEventListener('change', function () {
    filterRows();
})
filterOutcome.addEventListener('change', function () {
    filterRows();
})
filterTime.addEventListener('change', function () {
    filterRows();
})
