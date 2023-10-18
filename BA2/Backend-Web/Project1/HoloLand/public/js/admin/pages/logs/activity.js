const filterName = document.getElementById('activitylogs-filter-user');
const filterUrl = document.getElementById('activitylogs-filter-url');
const filterTime = document.getElementById('activitylogs-filter-time');

const rows = document.getElementsByTagName('tr') ;

function filterRows(val, index) {
    for (let i = 2; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('th');
        if (cells) {
            if (cells[0].innerText.toLowerCase().includes(filterName.value.toLowerCase())
                && cells[1].innerText.toLowerCase().includes(filterUrl.value.toLowerCase())
                && cells[2].innerText.toLowerCase().includes(filterTime.value.toLowerCase())) {
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
