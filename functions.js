let currentCategory = 'all';
let currentPage = 1;
const rowsPerPage = 5;

document.getElementById('categoryFilter').addEventListener('change', function() {
    currentCategory = this.value;
    currentPage = 1;
    fetchData();
});

document.getElementById('prevPage').addEventListener('click', function() {
    if (currentPage > 1) {
        currentPage--;
        fetchData();
    }
});

document.getElementById('nextPage').addEventListener('click', function() {
    currentPage++;
    fetchData();
});

function fetchData() {
    fetch(`api.php?category=${currentCategory}&page=${currentPage}&limit=${rowsPerPage}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#dataTable tbody');
            tableBody.innerHTML = '';
            data.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="prod-name">${item.name}</td>
                    <td>${item.category}</td>
                    <td>P ${item.price}</td>
                    <td><button onclick="updateItem(${item.id}, '${item.category}')" class="update-btn">&#10227;</button></td>
                    <td><button onclick="transferItemToArchive(${item.id}, '${item.category}', '${item.name}', ${item.quantity}, ${item.price})" class="archive-btn">&#9851;</button></td>
                `;
                tableBody.appendChild(row);
            });

            document.getElementById('pageInfo').textContent = ` ${currentPage}`;
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = data.length < rowsPerPage;
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Add an event listener for the update button
document.getElementById('dataTable').addEventListener('click', function(event) {
    if (event.target.classList.contains('update-btn')) {
        const row = event.target.closest('tr');
        const id = row.dataset.id;
        const name = row.cells[0].textContent;
        const category = row.cells[1].textContent;
        const price = row.cells[2].textContent;

        // Call a function to handle the update operation
        updateItem(id, name, category, price);
    }
});

// Function to handle the update operation
function updateItem(id, name, category, price) {
    // Implement your logic to update the item
    console.log('Updating item:', id, name, category, price);
    // You can either open a form for updating or send an AJAX request to update.php
    // Example AJAX request:
    fetch('update.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id, name, category, price })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Item updated successfully');
            // Optionally, you can update the table after successful update
            fetchData();
        } else {
            console.error('Failed to update item:', data.message);
        }
    })
    .catch(error => console.error('Error updating item:', error));
}


function transferItemToArchive(id, category, name, quantity, price) {
    const item = { id, category, name, quantity, price };
    const jsonString = JSON.stringify(item);
    console.log('Sending JSON:', jsonString); // Debugging line
    fetch('recycle.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: jsonString
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response:', data); // Debugging line
        if (data.success) {
            alert('Item archived successfully');
            fetchData();
        } else {
            alert('Failed to archive item: ' + data.message);
        }
    })
    .catch(error => console.error('Error archiving item:', error));
}


fetchData();
