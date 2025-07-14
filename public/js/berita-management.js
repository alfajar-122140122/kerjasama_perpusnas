// Berita Management JavaScript

// Global variables to track filter state
let currentStatusFilter = 'all';
let currentSearchText = '';

document.addEventListener('DOMContentLoaded', function() {
    // Get base URL for AJAX calls
    const base_url = document.querySelector('meta[name="base-url"]')?.getAttribute('content') || '';
    window.base_url = base_url;
    console.log('Base URL:', base_url);
    
    // Note: CKEditor is initialized in the view file
    // We'll use the globally available variables addEditor and editEditor
    
    // Search functionality
    const searchInput = document.getElementById('searchBerita');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentSearchText = this.value.toLowerCase();
            applyFilters();
        });
    }
    
    // Setup image previews
    const gambarInput = document.getElementById('gambar');
    const imagePreview = document.getElementById('imagePreview');
    if (gambarInput && imagePreview) {
        gambarInput.addEventListener('change', function() {
            previewImage(this, imagePreview);
        });
    }
    
    const editGambar = document.getElementById('edit_gambar');
    const editImagePreview = document.getElementById('editImagePreview');
    if (editGambar && editImagePreview) {
        editGambar.addEventListener('change', function() {
            previewImage(this, editImagePreview);
        });
    }
    
    // Handle form submissions with AJAX
    const addBeritaForm = document.getElementById('addBeritaForm');
    if (addBeritaForm) {
        addBeritaForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get CKEditor content if available
            if (window.addEditor) {
                const isiBeritaInput = document.getElementById('isi_berita');
                isiBeritaInput.value = addEditor.getData();
            }
            
            // Submit form with fetch API
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.status) {
                    showAlert('success', result.message);
                    
                    // Reset form and close modal
                    this.reset();
                    if (window.addEditor) {
                        window.addEditor.setData('');
                    }
                    document.getElementById('imagePreview').style.display = 'none';
                    
                    const addModal = bootstrap.Modal.getInstance(document.getElementById('addBeritaModal'));
                    if (addModal) {
                        addModal.hide();
                    }
                    
                    // Reload the page to update the table
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showAlert('error', result.message);
                }
            })
            .catch(error => {
                showAlert('error', 'Terjadi kesalahan: ' + error);
            });
        });
    }
    
    // Edit form submission
    const editBeritaForm = document.getElementById('editBeritaForm');
    if (editBeritaForm) {
        editBeritaForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get CKEditor content if available
            try {
                if (typeof editEditor !== 'undefined' && editEditor && typeof editEditor.getData === 'function') {
                    const editIsiBeritaInput = document.getElementById('edit_isi_berita');
                    if (editIsiBeritaInput) {
                        editIsiBeritaInput.value = editEditor.getData();
                    }
                }
            } catch (error) {
                console.error('Error getting editor content:', error);
            }
            
            // Submit form with fetch API
            const formData = new FormData(this);
            const id = document.getElementById('edit_id_berita').value;
            const updateUrl = `${base_url}/admin/berita/update/${id}`;
            
            console.log('Submitting to URL:', updateUrl);
            
            fetch(updateUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.status) {
                    showAlert('success', result.message);
                    
                    // Close modal and reload
                    const editModal = bootstrap.Modal.getInstance(document.getElementById('editBeritaModal'));
                    if (editModal) {
                        editModal.hide();
                    }
                    
                    // Reload the page to update the table
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showAlert('error', result.message);
                }
            })
            .catch(error => {
                showAlert('error', 'Terjadi kesalahan: ' + error);
            });
        });
    }
});

// Combined filter function
function applyFilters() {
    const rows = document.querySelectorAll('.berita-row');
    
    rows.forEach(row => {
        // Start by assuming we'll show the row
        let showRow = true;
        
        // Apply status filter
        if (currentStatusFilter !== 'all') {
            const statusBadge = row.querySelector('.badge');
            const rowStatus = statusBadge.textContent.toLowerCase();
            
            if (!rowStatus.includes(currentStatusFilter)) {
                showRow = false;
            }
        }
        
        // Apply search text filter (but only if the row passed the status filter)
        if (showRow && currentSearchText !== '') {
            const title = row.querySelector('.berita-title').textContent.toLowerCase();
            const excerpt = row.querySelector('.berita-excerpt').textContent.toLowerCase();
            
            if (!title.includes(currentSearchText) && !excerpt.includes(currentSearchText)) {
                showRow = false;
            }
        }
        
        // Show or hide the row based on combined filters
        row.style.display = showRow ? '' : 'none';
    });
    
    // Check if there are any visible rows
    const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
    const noResultsMessage = document.getElementById('noFilterResults');
    
    // If no rows are visible after filtering, show a message
    if (visibleRows.length === 0) {
        if (!noResultsMessage) {
            const tableContainer = document.querySelector('.card');
            const message = document.createElement('div');
            message.id = 'noFilterResults';
            message.className = 'alert alert-info m-3 text-center';
            message.textContent = 'Tidak ada berita yang sesuai dengan filter';
            tableContainer.appendChild(message);
        }
    } else {
        // Hide the message if there are visible rows
        if (noResultsMessage) {
            noResultsMessage.remove();
        }
    }
}

// Filter by status
function filterByStatus(status) {
    currentStatusFilter = status;
    
    // Update filter button text
    const filterButton = document.querySelector('.dropdown-toggle');
    if (filterButton) {
        const statusText = status === 'all' ? 'Semua Status' : 
                          status === 'published' ? 'Published' : 'Draft';
        filterButton.innerHTML = `<i class="fas fa-filter"></i> ${statusText}`;
    }
    
    // Apply combined filters
    applyFilters();
}

// Reset all filters
function resetFilters() {
    currentStatusFilter = 'all';
    currentSearchText = '';
    
    // Reset search input
    const searchInput = document.getElementById('searchBerita');
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Reset filter button text
    const filterButton = document.querySelector('.dropdown-toggle');
    if (filterButton) {
        filterButton.innerHTML = '<i class="fas fa-filter"></i> Semua Status';
    }
    
    // Show all rows
    document.querySelectorAll('.berita-row').forEach(row => {
        row.style.display = '';
    });
    
    // Remove any no results message
    const noResultsMessage = document.getElementById('noFilterResults');
    if (noResultsMessage) {
        noResultsMessage.remove();
    }
}

// Preview image function
function previewImage(input, previewElement) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewElement.style.display = 'block';
            const img = previewElement.querySelector('img');
            if (img) {
                img.src = e.target.result;
            } else {
                const newImg = document.createElement('img');
                newImg.src = e.target.result;
                newImg.classList.add('img-thumbnail');
                newImg.style.maxWidth = '100%';
                newImg.style.height = '200px';
                newImg.style.objectFit = 'cover';
                previewElement.appendChild(newImg);
            }
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// View berita function
function viewBerita(id) {
    fetch(`${base_url}/admin/berita/get/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.status) {
            const berita = result.data;
            
            // Populate the view modal
            document.getElementById('viewBeritaTitle').textContent = berita.judul;
            document.getElementById('viewBeritaContent').innerHTML = berita.isi_berita;
            
            // Set status badge
            const statusElement = document.getElementById('viewBeritaStatus');
            if (statusElement) {
                statusElement.textContent = berita.status === 'published' ? 'Published' : 'Draft';
                statusElement.className = berita.status === 'published' ? 
                    'badge bg-success' : 'badge bg-warning text-dark';
            }
            
            // Set dates
            document.getElementById('viewBeritaDate').textContent = berita.formatted_tanggal_publikasi || '-';
            document.getElementById('viewBeritaCreated').textContent = berita.formatted_created_at || '-';
            document.getElementById('viewBeritaUpdated').textContent = berita.formatted_updated_at || '-';
            
            // Show author if available
            const authorElement = document.getElementById('viewBeritaAuthor');
            if (authorElement) {
                authorElement.textContent = berita.author_name || '-';
            }
            
            // Show image if available
            const imageContainer = document.getElementById('viewBeritaImage');
            if (imageContainer) {
                if (berita.gambar && berita.image_exists) {
                    imageContainer.innerHTML = `<img src="${base_url}/uploads/berita/${berita.gambar}" class="img-fluid rounded" alt="Berita Image">`;
                } else {
                    imageContainer.innerHTML = `<div class="alert alert-info mb-0">Tidak ada gambar</div>`;
                }
            }
            
            // Open the modal
            const viewModal = new bootstrap.Modal(document.getElementById('viewBeritaModal'));
            viewModal.show();
        } else {
            showAlert('error', result.message);
        }
    })
    .catch(error => {
        showAlert('error', 'Terjadi kesalahan: ' + error);
    });
}

// Edit berita function
function editBerita(id) {
    fetch(`${base_url}/admin/berita/get/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.status) {
            const berita = result.data;
            
            // Populate the edit form
            document.getElementById('edit_id_berita').value = berita.id_berita;
            document.getElementById('edit_judul').value = berita.judul;
            
            // Set CKEditor content if available
            try {
                // Store the content for when the editor is ready
                window.pendingEditorContent = berita.isi_berita || '';
                
                // Set content directly to textarea (will be overwritten by CKEditor when initialized)
                const editIsiBeritaElement = document.getElementById('edit_isi_berita');
                if (editIsiBeritaElement) {
                    editIsiBeritaElement.value = window.pendingEditorContent;
                } else {
                    console.error('Element with ID "edit_isi_berita" not found');
                }
            } catch (error) {
                console.error('Error setting editor content:', error);
            }
            
            document.getElementById('edit_status').value = berita.status;
            document.getElementById('edit_tanggal_publikasi').value = berita.iso_tanggal_publikasi;
            
            // Show current image if available
            const currentImageContainer = document.getElementById('currentImage');
            if (berita.gambar && berita.image_exists) {
                currentImageContainer.innerHTML = `
                    <div class="mb-2">Gambar Saat Ini:</div>
                    <img src="${base_url}/uploads/berita/${berita.gambar}" alt="Current Image" 
                         class="img-thumbnail" style="max-width: 100%; height: 200px; object-fit: cover;">
                    <div class="form-text mt-1">Unggah gambar baru untuk mengganti</div>
                `;
            } else {
                currentImageContainer.innerHTML = `
                    <div class="alert alert-info">Belum ada gambar</div>
                `;
            }
            
            // Reset file input and preview
            document.getElementById('edit_gambar').value = '';
            document.getElementById('editImagePreview').style.display = 'none';
            
            // Set the form action URL
            const editForm = document.getElementById('editBeritaForm');
            if (editForm) {
                const actionUrl = `${base_url}/admin/berita/update/${berita.id_berita}`;
                console.log('Setting form action to:', actionUrl);
                editForm.action = actionUrl;
            }
            
            // Open the modal
            const editModal = new bootstrap.Modal(document.getElementById('editBeritaModal'));
            editModal.show();
        } else {
            showAlert('error', result.message);
        }
    })
    .catch(error => {
        showAlert('error', 'Terjadi kesalahan: ' + error);
    });
}

// Delete berita function
function deleteBerita(id) {
    if (window.Swal) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus berita ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                performDelete(id);
            }
        });
    } else {
        if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
            performDelete(id);
        }
    }
}

// Perform delete operation
function performDelete(id) {
    // Try DELETE method first, with fallback to POST
    fetch(`${base_url}/admin/berita/delete/${id}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .catch(error => {
        // If DELETE fails, try POST as fallback
        console.log("DELETE request failed, trying POST as fallback", error);
        return fetch(`${base_url}/admin/berita/delete/${id}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        });
    })
    .then(response => response.json())
    .then(result => {
        if (result.status) {
            showAlert('success', result.message);
            
            // Remove row from table
            const row = document.querySelector(`tr[data-berita-id="${id}"]`);
            if (row) {
                row.remove();
            } else {
                // If can't find the row, reload the page
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        } else {
            showAlert('error', result.message);
        }
    })
    .catch(error => {
        showAlert('error', 'Terjadi kesalahan: ' + error);
    });
}

// Show alert message
function showAlert(type, message) {
    if (window.Swal) {
        Swal.fire({
            icon: type === 'success' ? 'success' : 'error',
            title: type === 'success' ? 'Berhasil' : 'Error',
            text: message,
            timer: 3000,
            timerProgressBar: true
        });
    } else {
        alert(message);
    }
}
