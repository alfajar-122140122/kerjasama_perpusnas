/**
 * Pagination Public Component
 * 
 * Simple table pagination for public pages with rows per page selection
 */

document.addEventListener('DOMContentLoaded', function() {
    initPublicPagination();
});

function initPublicPagination() {
    // Get all tables that need pagination
    const tables = document.querySelectorAll('.table-paginate');
    
    if (tables.length === 0) {
        // Try to find other tables that might need pagination
        const otherTables = document.querySelectorAll('.kerjasama-table, .progress-table, .akan-berakhir-table, .implementasi-table');
        
        if (otherTables.length > 0) {
            // Add pagination class to these tables
            otherTables.forEach(table => {
                table.classList.add('table-paginate');
            });
            
            // Re-run initialization
            setTimeout(initPublicPagination, 0);
            return;
        }
    }
    
    tables.forEach(function(table) {
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        // Get all rows
        const rows = tbody.querySelectorAll('tr');
        if (rows.length === 0) return;
        
        // Set default values
        let itemsPerPage = 10;
        let currentPage = 1;
        let totalVisibleRows = rows.length;
        
        // Initialize the selector for rows per page
        const rowsPerPageSelector = document.getElementById('pagination-public-rows-per-page');
        if (rowsPerPageSelector) {
            // Set initial value if present in localStorage
            const savedRowsPerPage = localStorage.getItem('pagination-public-rows-per-page');
            if (savedRowsPerPage) {
                rowsPerPageSelector.value = savedRowsPerPage;
                itemsPerPage = parseInt(savedRowsPerPage);
            }
            
            rowsPerPageSelector.addEventListener('change', function() {
                itemsPerPage = parseInt(this.value);
                // Save preference to localStorage
                localStorage.setItem('pagination-public-rows-per-page', itemsPerPage);
                currentPage = 1; // Reset to first page
                
                // Update pagination based on visible rows
                const totalPages = Math.max(1, Math.ceil(totalVisibleRows / itemsPerPage));
                updatePaginationUI(rows, currentPage, itemsPerPage, totalPages, totalVisibleRows);
            });
        }
        
        // Calculate total pages based on default items per page
        const totalPages = Math.max(1, Math.ceil(rows.length / itemsPerPage));
        
        // Initialize pagination UI
        updatePaginationUI(rows, currentPage, itemsPerPage, totalPages, rows.length);
        
        // Attach event listeners for navigation
        attachPaginationEvents(rows, () => itemsPerPage);
        
        // Handle search input if it exists
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            // Remove existing event listeners if any
            const newSearchInput = searchInput.cloneNode(true);
            searchInput.parentNode.replaceChild(newSearchInput, searchInput);
            
            newSearchInput.addEventListener('input', function() {
                totalVisibleRows = handleSearch(this.value, rows);
                const newTotalPages = Math.max(1, Math.ceil(totalVisibleRows / itemsPerPage));
                updatePaginationUI(rows, 1, itemsPerPage, newTotalPages, totalVisibleRows);
            });
            
            // Also connect search button if exists
            const searchBtn = document.querySelector('.kerjasama-search-btn, .progress-search-btn, .akan-berakhir-search-btn, .implementasi-search-btn');
            if (searchBtn) {
                searchBtn.addEventListener('click', function() {
                    totalVisibleRows = handleSearch(newSearchInput.value, rows);
                    const newTotalPages = Math.max(1, Math.ceil(totalVisibleRows / itemsPerPage));
                    updatePaginationUI(rows, 1, itemsPerPage, newTotalPages, totalVisibleRows);
                });
            }
        }
    });
}

function updatePaginationUI(rows, currentPage, itemsPerPage, totalPages, totalRows) {
    // Show the current page
    showPage(rows, currentPage, itemsPerPage);
    
    // Update pagination info
    updatePaginationInfo(currentPage, totalPages, itemsPerPage, totalRows);
    
    // Render pagination buttons
    renderPaginationButtons(currentPage, totalPages);
}

function showPage(rows, page, itemsPerPage) {
    // Calculate start and end indices
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    
    // Counter for visible rows
    let visibleCount = 0;
    let actualEnd = 0;
    
    // First, hide all rows
    for (let i = 0; i < rows.length; i++) {
        rows[i].style.display = 'none';
    }
    
    // Show only visible rows for current page
    for (let i = 0; i < rows.length; i++) {
        if (!rows[i].hasAttribute('data-filtered')) {
            if (visibleCount >= startIndex && visibleCount < endIndex) {
                rows[i].style.display = '';
                actualEnd = visibleCount + 1;
            }
            visibleCount++;
        }
    }
    
    // Update page info
    const startElem = document.getElementById('pagination-public-start');
    const endElem = document.getElementById('pagination-public-end');
    
    if (startElem && visibleCount > 0) {
        startElem.textContent = startIndex + 1;
    } else if (startElem) {
        startElem.textContent = 0;
    }
    
    if (endElem) {
        endElem.textContent = actualEnd;
    }
    
    // PAGINATION ALWAYS VISIBLE: Don't hide pagination container even if all data fits on one page
    // The previous code that was hiding pagination has been removed
}

function updatePaginationInfo(currentPage, totalPages, itemsPerPage, totalRows) {
    const totalRowsElem = document.getElementById('pagination-public-total-rows');
    if (totalRowsElem) {
        totalRowsElem.textContent = totalRows;
    }
    
    // Calculate start and end for display
    const start = totalRows === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
    const end = Math.min(start + itemsPerPage - 1, totalRows);
    
    const startElem = document.getElementById('pagination-public-start');
    const endElem = document.getElementById('pagination-public-end');
    
    if (startElem) startElem.textContent = start;
    if (endElem) endElem.textContent = end;
}

function renderPaginationButtons(currentPage, totalPages) {
    const pagesContainer = document.getElementById('pagination-public-pages');
    if (!pagesContainer) return;
    
    // Clear existing buttons
    pagesContainer.innerHTML = '';
    
    // Previous button
    const prevBtn = document.getElementById('pagination-public-prev');
    if (prevBtn) {
        prevBtn.disabled = currentPage === 1;
    }
    
    // Next button
    const nextBtn = document.getElementById('pagination-public-next');
    if (nextBtn) {
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;
    }
    
    // Generate page buttons
    if (totalPages <= 5) {
        // Show all pages
        for (let i = 1; i <= totalPages; i++) {
            addPageButton(pagesContainer, i, currentPage);
        }
        
        // If there are no pages (totalPages = 0), add a disabled "1" button
        if (totalPages === 0) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'pagination-public-page active';
            button.textContent = '1';
            button.disabled = true;
            pagesContainer.appendChild(button);
        }
    } else {
        // Show limited pages with ellipsis
        if (currentPage <= 3) {
            // Near start
            for (let i = 1; i <= 4; i++) {
                addPageButton(pagesContainer, i, currentPage);
            }
            addEllipsis(pagesContainer);
            addPageButton(pagesContainer, totalPages, currentPage);
        } else if (currentPage >= totalPages - 2) {
            // Near end
            addPageButton(pagesContainer, 1, currentPage);
            addEllipsis(pagesContainer);
            for (let i = totalPages - 3; i <= totalPages; i++) {
                addPageButton(pagesContainer, i, currentPage);
            }
        } else {
            // Middle
            addPageButton(pagesContainer, 1, currentPage);
            addEllipsis(pagesContainer);
            for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                addPageButton(pagesContainer, i, currentPage);
            }
            addEllipsis(pagesContainer);
            addPageButton(pagesContainer, totalPages, currentPage);
        }
    }
}

function addPageButton(container, pageNum, currentPage) {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'pagination-public-page' + (pageNum === currentPage ? ' active' : '');
    button.textContent = pageNum;
    button.dataset.page = pageNum;
    container.appendChild(button);
}

function addEllipsis(container) {
    const span = document.createElement('span');
    span.className = 'pagination-public-ellipsis';
    span.textContent = '...';
    container.appendChild(span);
}

function attachPaginationEvents(rows, getItemsPerPage) {
    // Previous button
    const prevBtn = document.getElementById('pagination-public-prev');
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            const currentPageElem = document.querySelector('.pagination-public-page.active');
            if (currentPageElem) {
                const currentPage = parseInt(currentPageElem.dataset.page);
                if (currentPage > 1) {
                    // Count visible rows
                    const visibleRows = countVisibleRows(rows);
                    const itemsPerPage = getItemsPerPage();
                    const totalPages = Math.ceil(visibleRows / itemsPerPage);
                    
                    // Update UI for previous page
                    updatePaginationUI(rows, currentPage - 1, itemsPerPage, totalPages, visibleRows);
                }
            }
        });
    }
    
    // Next button
    const nextBtn = document.getElementById('pagination-public-next');
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            const currentPageElem = document.querySelector('.pagination-public-page.active');
            if (currentPageElem) {
                const currentPage = parseInt(currentPageElem.dataset.page);
                
                // Count visible rows
                const visibleRows = countVisibleRows(rows);
                const itemsPerPage = getItemsPerPage();
                const totalPages = Math.ceil(visibleRows / itemsPerPage);
                
                if (currentPage < totalPages) {
                    // Update UI for next page
                    updatePaginationUI(rows, currentPage + 1, itemsPerPage, totalPages, visibleRows);
                }
            }
        });
    }
    
    // Page number buttons
    const pagesContainer = document.getElementById('pagination-public-pages');
    if (pagesContainer) {
        pagesContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('pagination-public-page')) {
                const page = parseInt(e.target.dataset.page);
                
                // Count visible rows
                const visibleRows = countVisibleRows(rows);
                const itemsPerPage = getItemsPerPage();
                const totalPages = Math.ceil(visibleRows / itemsPerPage);
                
                // Update UI for selected page
                updatePaginationUI(rows, page, itemsPerPage, totalPages, visibleRows);
            }
        });
    }
}

function countVisibleRows(rows) {
    let count = 0;
    rows.forEach(row => {
        if (!row.hasAttribute('data-filtered')) {
            count++;
        }
    });
    return count;
}

function handleSearch(searchTerm, rows) {
    searchTerm = searchTerm.toLowerCase().trim();
    
    let visibleCount = 0;
    
    // Filter rows based on search term
    rows.forEach(row => {
        // Check all cells in the row
        const text = row.textContent.toLowerCase();
        if (searchTerm === '' || text.includes(searchTerm)) {
            row.removeAttribute('data-filtered');
            visibleCount++;
        } else {
            row.setAttribute('data-filtered', 'true');
            row.style.display = 'none';
        }
    });
    
    // Show/hide empty state if needed
    const emptyState = document.getElementById('emptyState');
    if (emptyState) {
        emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
    }
    
    return visibleCount;
}