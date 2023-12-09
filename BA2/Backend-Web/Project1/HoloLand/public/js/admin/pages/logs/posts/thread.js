const filterUser = document.getElementById('postlogs-filter-user');
const filterThread = document.getElementById('postlogs-filter-thread');
const filterTime = document.getElementById('postlogs-filter-time');
const filterLink = document.getElementById('postlogs-filter-link');

const rows = document.getElementsByTagName('tr');


function filterRows() {
    for (let i = 2; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('th');
        if (cells) {
            if (cells[0].innerText.toLowerCase().includes(filterUser.value.toLowerCase())
                && cells[1].innerText.toLowerCase().includes(filterThread.value.toLowerCase())
                && cells[2].innerText.toLowerCase().includes(filterTime.value.toLowerCase())
                && cells[3].innerText.toLowerCase().includes(filterLink.value.toLowerCase())) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
}

filterUser.addEventListener('change', function () {
    filterRows();
})

filterThread.addEventListener('change', function () {
    filterRows();
})

filterTime.addEventListener('change', function () {
    filterRows();
})

filterLink.addEventListener('change', function () {
    filterRows();
})
