document.addEventListener('DOMContentLoaded', function () {
    console.log('order.js loaded');
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
        const loadingSpinner = document.getElementById('loading-spinner');
        if (loadingSpinner) {
            loadingSpinner.style.display = 'block';
        }

        fetch(`${direxAjax.ajax_url}?action=get_orders&security=${direxAjax.nonce}`, {
            method: 'GET',
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    orderData = data.data;
                    totalOrders = data.data.length;
                    renderTable(orderData);
                    updatePagination();
                    setupActionButtons();
                } else {
                    throw new Error('Failed to load orders');
                }
            })
            .catch(error => {
                console.error('Error loading orders:', error);
                const orderTableBody = document.getElementById('orderTableBody');
                if (orderTableBody) {
                    orderTableBody.innerHTML = '<tr><td colspan="8">Error loading orders. Please try again.</td></tr>';
                }
            })
            .finally(() => {
                if (loadingSpinner) {
                    loadingSpinner.style.display = 'none';
                }
            });
    }

    // Render table
    function renderTable(data) {
        const tbody = document.getElementById('orderTableBody');
        if (!tbody) return;
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
                    <td>${item.brand}</td>
                     <td>${item.category}</td>
                    <td><span class="status-badge ${item.status.toLowerCase()}">${item.status}</span></td>
                  
            `;
            tbody.innerHTML += row;
        });
    }

    // Set up event listeners for action buttons
    function setupActionButtons() {
        document.querySelectorAll('.select-product').forEach(checkbox => {
            checkbox.addEventListener('change', handleSelectProduct);
        });

        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', handleSelectAll);
        }
    }

    // Handle select product
    function handleSelectProduct(event) {
        const orderId = event.target.dataset.id;
        console.log('Product selected:', orderId);
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
        if (!paginationContainer) return;

        paginationContainer.innerHTML = `
            <button class="button prev-page" ${currentPage === 1 ? 'disabled' : ''}>Previous</button>
            <span class="paging-input">
                <span class="current-page">${currentPage}</span>
                of
                <span class="total-pages">${totalPages}</span>
            </span>
            <button class="button next-page" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>
        `;

        const prevPageButton = document.querySelector('.prev-page');
        const nextPageButton = document.querySelector('.next-page');

        if (prevPageButton) {
            prevPageButton.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable(orderData);
                    updatePagination();
                }
            });
        }

        if (nextPageButton) {
            nextPageButton.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable(orderData);
                    updatePagination();
                }
            });
        }
    }

    // Event listeners for filter, search, and records per page
    function setupEventListeners() {
        const exportBtn = document.getElementById('exportBtn');
        if (exportBtn) {
            exportBtn.addEventListener('click', handleExport);
        }

        const syncBtn = document.getElementById('syncBtn');
        if (syncBtn) {
            syncBtn.addEventListener('click', handleSync);
        }

        const recordsPerPageSelect = document.getElementById('recordsPerPage');
        if (recordsPerPageSelect) {
            recordsPerPageSelect.addEventListener('change', handleRecordsPerPage);
        }

        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', handleSearch);
        }
    }

    function handleExport() {
        console.log('Export clicked');
        const table = document.querySelector('.orders-table');
        if (!table) return;
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
        loadOrders();
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
                item.id.toString().toLowerCase().includes(searchTerm) || // Ensure id is a string
                item.brand.toLowerCase().includes(searchTerm) || 
                item.category.toLowerCase().includes(searchTerm)
            );
        });
        renderTable(filteredData);
        updatePagination();
    }

    // Initialize
    initializeTable();
});