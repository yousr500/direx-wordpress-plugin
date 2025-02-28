<div class="wrap">
    <h1>Order Management</h1>
    <div class="order-controls">
        <div class="filter-controls">
            <input type="text" id="searchInput" placeholder="Search...">
            <select id="recordsPerPage">
                <option value="10">Showing 10</option>
                <option value="20">Showing 20</option>
                <option value="50">Showing 50</option>
            </select>
            <button id="exportBtn" class="button"><span class="dashicons dashicons-download"></span> Export</button>
            <button id="syncBtn" class="button-primary"><span class="dashicons dashicons-update"></span> Synchronize</button>
        </div>
    </div>

    <div id="loading-spinner" style="display: none;">Loading...</div>

    <table class="wp-list-table widefat fixed striped orders-table">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>Product Name</th>
                <th>Product ID</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="orderTableBody">
            <!-- Dynamic content here -->
        </tbody>
    </table>

    <div class="tablenav bottom">
        <div class="tablenav-pages">
            <span class="pagination-links">
                <button class="button prev-page">Previous</button>
                <span class="paging-input">
                    <span class="current-page">1</span>
                    of
                    <span class="total-pages">5</span>
                </span>
                <button class="button next-page">Next</button>
            </span>
        </div>
    </div>

  
</div>