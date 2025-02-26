document.addEventListener('DOMContentLoaded', function () {
    let currentPage = 1;
    let itemsPerPage = 10;
    let totalOrders = 0;
    let orderData = [];

    // Initialize table
    function initializeTable() {
        loadOrders();
        setupEventListeners();
    }

    // Load orders
    function loadOrders() {
        document.getElementById('loading-spinner').style.display = 'block';
    
        fetch('https://stagingapi.b2cdelivery.tn/api-token-auth/', {
            headers: {
                'X-WP-Nonce': direxAjax.nonce, // Add nonce here
            },
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                orderData = data;
                totalOrders = data.length;
                renderTable(data);
                updatePagination();
                setupActionButtons();
            })
            .catch(error => {
                console.error('Error loading orders:', error);
                document.getElementById('orderTableBody').innerHTML = `<tr><td colspan="8">Error loading orders. Please try again.</td></tr>`;
            })
            .finally(() => {
                document.getElementById('loading-spinner').style.display = 'none';
            });
    }

    // Render table
    function renderTable(data) {
        const tbody = document.getElementById('orderTableBody');
        tbody.innerHTML = '';

        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const pageData = data.slice(start, end);

        pageData.forEach(item => {
            const row = `
                <tr>
                    <td><input type="checkbox" class="select-product" data-id="${item.id}"></td>
                    <td>${item.name}</td>
                    <td>${item.id}</td>
                    <td>${item.price}</td>
                    <td>${item.stock}</td>
                    <td>${item.type}</td>
                    <td><span class="status-badge ${item.status.toLowerCase()}">${item.status}</span></td>
                    <td class="action-cell">
                        <button class="button edit-btn" data-id="${item.id}">Edit</button>
                        <button class="button delete-btn" data-id="${item.id}">Delete</button>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }

    // Set up event listeners for action buttons
    function setupActionButtons() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', handleEdit);
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', handleDelete);
        });

        document.querySelectorAll('.select-product').forEach(checkbox => {
            checkbox.addEventListener('change', handleSelectProduct);
        });
        document.getElementById('selectAll').addEventListener('change', handleSelectAll);
    }

    // Handle edit button click
    function handleEdit(event) {
        const orderId = event.target.dataset.id;
        console.log('Edit button clicked for order ID:', orderId);
        // Implement edit logic here
    }

    // Handle delete button click
    function handleDelete(event) {
        const orderId = event.target.dataset.id;
        console.log('Delete button clicked for order ID:', orderId);
        // Implement delete logic here
        fetch(`https://stagingapi.b2cdelivery.tn/api-token-auth/${orderId}`, {
            method: 'DELETE',
        })
            .then(response => response.json())
            .then(data => {
                console.log('Order deleted:', data);
                loadOrders();
            })
            .catch(error => {
                console.error('Error deleting order:', error);
            });
    }

    // Handle select product
    function handleSelectProduct(event) {
        const orderId = event.target.dataset.id;
        console.log('Product selected:', orderId);
        // Implement selection logic here
    }
    function handleSelectAll(event) {
        const isChecked = event.target.checked;
        document.querySelectorAll('.select-product').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    }

    // Handle pagination
    function updatePagination() {
        const totalPages = Math.ceil(totalOrders / itemsPerPage);
        const paginationContainer = document.querySelector('.pagination-links');
        paginationContainer.innerHTML = `
            <button class="button prev-page" ${currentPage === 1 ? 'disabled' : ''}>Previous</button>
            <span class="paging-input">
                <span class="current-page">${currentPage}</span>
                of
                <span class="total-pages">${totalPages}</span>
            </span>
            <button class="button next-page" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>
        `;

        document.querySelector('.prev-page').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable(orderData);
                updatePagination();
            }
        });

        document.querySelector('.next-page').addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderTable(orderData);
                updatePagination();
            }
        });
    }

    // Event listeners for filter, search, and records per page
    function setupEventListeners() {
        document.getElementById('filterBtn').addEventListener('click', handleFilter);
        document.getElementById('exportBtn').addEventListener('click', handleExport);
        document.getElementById('syncBtn').addEventListener('click', handleSync);
        document.getElementById('addProductBtn').addEventListener('click', handleAddProduct);
        document.getElementById('recordsPerPage').addEventListener('change', handleRecordsPerPage);
        document.getElementById('searchInput').addEventListener('input', handleSearch);
    }

    // Handlers
    function handleFilter() {
        // Implement filter logic
        console.log('Filter clicked');
    }

    function handleExport() {
        console.log('Export clicked');
        const table = document.querySelector('.orders-table');
        const tableHtml = table.outerHTML;
        const newWindow = window.open('', '', 'height=600,width=800');
        newWindow.document.write('<html><head><title>Order Management</title>');
        newWindow.document.write('</head><body>');
        newWindow.document.write(tableHtml);
        newWindow.document.write('</body></html>');
        newWindow.document.close();
        newWindow.print();
    }


    function handleSync() {
        console.log('Sync clicked');
        // Implement sync logic
    }

    function handleAddProduct() {
        console.log('Add product clicked');
        // Implement add product logic
    }

    function handleRecordsPerPage(e) {
        itemsPerPage = parseInt(e.target.value, 10);
        currentPage = 1;
        renderTable(orderData);
        updatePagination();
    }

    function handleSearch(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredData = orderData.filter(item => {
            return (
                item.name.toLowerCase().includes(searchTerm) ||
                item.id.toLowerCase().includes(searchTerm) ||
                item.type.toLowerCase().includes(searchTerm)
            );
        });
        renderTable(filteredData);
        updatePagination();
    }

    // Initialize
    initializeTable();
});