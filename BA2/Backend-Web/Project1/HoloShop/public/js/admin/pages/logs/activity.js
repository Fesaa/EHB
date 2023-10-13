const filterName = document.getElementById('activitylogs-filter-user');
const filterUrl = document.getElementById('activitylogs-filter-url');
const filterTime = document.getElementById('activitylogs-filter-time');

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

filterName.addEventListener('change', function () {
    filterRows(this.value, 0);
})
filterUrl.addEventListener('change', function () {
    filterRows(this.value, 1);
})
filterTime.addEventListener('change', function () {
    filterRows(this.value, 2);
})
