document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    function openTab(tabId) {
        tabContents.forEach(content => {
            content.style.display = 'none';
        });
        document.getElementById(tabId).style.display = 'block';

        tabs.forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelector(`button[onclick="openTab('${tabId}')"]`).classList.add('active');
    }

    // Initialize the first tab as active
    openTab('lecturerTab');

    // Fetch timetables from the server
    fetch('path_to_your_php_file_that_generates_timetable_json.php')
        .then(response => response.json())
        .then(data => {
            populateTable('lecturerTimetable', data.lecturer);
            populateTable('classTimetable', data.class);
            populateTable('departmentTimetable', data.department);
        });

    function populateTable(tableId, timetable) {
        const tableBody = document.getElementById(tableId).querySelector('tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        timetable.forEach(entry => {
            const row = document.createElement('tr');
            Object.values(entry).forEach(value => {
                const cell = document.createElement('td');
                cell.textContent = value;
                row.appendChild(cell);
            });
            tableBody.appendChild(row);
        });
    }
});
