// Berita Management JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchBerita');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterTable();
        });
    }
});

// Filter by status
function filterByStatus(status) {
    const rows = document.querySelectorAll('.berita-row');
    
    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = '';
        } else {
            const statusBadge = row.querySelector('.badge');
            const rowStatus = statusBadge.textContent.toLowerCase();
            
            if (rowStatus === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
    
    // Update filter button text
    const filterButton = document.querySelector('.dropdown-toggle');
    if (filterButton) {
        const statusText = status === 'all' ? 'Semua Status' : 
                          status === 'published' ? 'Published' : 'Draft';
        filterButton.innerHTML = `<i class="fas fa-filter"></i> ${statusText}`;
    }
}

// Filter table based on search input
function filterTable() {
    const searchValue = document.getElementById('searchBerita').value.toLowerCase();
    const rows = document.querySelectorAll('.berita-row');
    
    rows.forEach(row => {
        const title = row.querySelector('.berita-title').textContent.toLowerCase();
        const excerpt = row.querySelector('.berita-excerpt').textContent.toLowerCase();
        
        if (title.includes(searchValue) || excerpt.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// View berita function
function viewBerita(id) {
    // This would typically load berita details in a modal
    console.log('View berita with ID:', id);
    // You can implement modal loading here
}

// Edit berita function
function editBerita(id) {
    // This would typically load berita data for editing
    console.log('Edit berita with ID:', id);
    // You can implement edit modal loading here
}

// Delete berita function
function deleteBerita(id) {
    if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
        // This would typically send a delete request
        console.log('Delete berita with ID:', id);
        
        // For demo purposes, just remove the row
        const row = document.querySelector(`[data-berita-id="${id}"]`);
        if (row) {
            row.remove();
        }
    }
}

// Reset filters
function resetFilters() {
    document.getElementById('searchBerita').value = '';
    filterByStatus('all');
    filterTable();
}
