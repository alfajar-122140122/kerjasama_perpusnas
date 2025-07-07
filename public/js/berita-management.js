/**
 * Berita Management JavaScript
 * Handles news CRUD operations, modals, image preview, and form validation
 */

class BeritaManager {
    constructor() {
        this.currentPage = 1;
        this.rowsPerPage = 10;
        this.searchTerm = '';
        this.sortColumn = 'tanggal_publikasi';
        this.sortDirection = 'desc';
        this.selectedImageFile = null;
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadBeritaData();
        this.initializeDataTable();
    }

    bindEvents() {
        // Search functionality
        document.getElementById('searchBerita')?.addEventListener('input', (e) => {
            this.searchTerm = e.target.value.toLowerCase();
            this.filterAndDisplayData();
        });

        // Status filter
        document.getElementById('filterStatus')?.addEventListener('change', (e) => {
            this.filterAndDisplayData();
        });

        // Month filter
        document.getElementById('filterMonth')?.addEventListener('change', (e) => {
            this.filterAndDisplayData();
        });

        // Form submissions
        document.getElementById('addBeritaForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleAddNews();
        });

        document.getElementById('editBeritaForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleEditNews();
        });

        // Image preview
        document.getElementById('gambar')?.addEventListener('change', (e) => {
            this.handleImagePreview(e, 'imagePreview');
        });

        document.getElementById('edit_gambar')?.addEventListener('change', (e) => {
            this.handleImagePreview(e, 'editImagePreview');
        });

        // Modal events
        document.getElementById('addBeritaModal')?.addEventListener('hidden.bs.modal', () => {
            this.resetAddForm();
        });

        document.getElementById('editBeritaModal')?.addEventListener('hidden.bs.modal', () => {
            this.resetEditForm();
        });
    }

    async loadBeritaData() {
        try {
            this.showLoading(true);
            
            // For now, using sample data. In real implementation, this would be an AJAX call
            const sampleData = this.generateSampleData();
            
            this.displayBeritaData(sampleData);
            
        } catch (error) {
            console.error('Error loading berita data:', error);
            this.showError('Gagal memuat data berita. Silakan coba lagi.');
        } finally {
            this.showLoading(false);
        }
    }

    generateSampleData() {
        return [
            {
                id_berita: 1,
                judul: 'Peluncuran Program Digitalisasi Perpustakaan Nasional 2025',
                isi_berita: 'Perpustakaan Nasional meluncurkan program digitalisasi besar-besaran untuk meningkatkan akses informasi bagi seluruh masyarakat Indonesia. Program ini diharapkan dapat mempermudah akses ke koleksi digital perpustakaan.',
                gambar: 'berita1.jpg',
                tanggal_publikasi: '2025-01-15 10:00:00',
                status: 'published',
                created_by_user_id: 1,
                author_name: 'Admin System',
                created_at: '2025-01-15 09:30:00',
                updated_at: '2025-01-15 09:30:00'
            },
            {
                id_berita: 2,
                judul: 'Kerjasama Perpustakaan Nasional dengan Universitas Terkemuka',
                isi_berita: 'Perpustakaan Nasional menjalin kerjasama strategis dengan berbagai universitas terkemuka untuk meningkatkan literasi dan akses informasi akademik di Indonesia.',
                gambar: 'berita2.jpg',
                tanggal_publikasi: '2025-01-10 14:30:00',
                status: 'published',
                created_by_user_id: 1,
                author_name: 'Admin System',
                created_at: '2025-01-10 14:00:00',
                updated_at: '2025-01-10 14:00:00'
            },
            {
                id_berita: 3,
                judul: 'Workshop Literasi Digital untuk Masyarakat',
                isi_berita: 'Perpustakaan Nasional mengadakan workshop literasi digital gratis untuk meningkatkan kemampuan masyarakat dalam menggunakan teknologi informasi dan komunikasi.',
                gambar: null,
                tanggal_publikasi: null,
                status: 'draft',
                created_by_user_id: 1,
                author_name: 'Admin System',
                created_at: '2025-01-05 16:00:00',
                updated_at: '2025-01-05 16:00:00'
            }
        ];
    }

    displayBeritaData(data) {
        const table = document.getElementById('beritaTable');
        if (!table) return;

        const tbody = table.querySelector('tbody');
        if (!tbody) return;

        tbody.innerHTML = '';

        if (data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada data berita</p>
                    </td>
                </tr>
            `;
            return;
        }

        data.forEach((berita, index) => {
            const row = document.createElement('tr');
            row.className = 'berita-row';
            row.setAttribute('data-berita-id', berita.id_berita);
            
            const publishDate = berita.tanggal_publikasi ? new Date(berita.tanggal_publikasi) : null;
            const createdDate = new Date(berita.created_at);
            const formattedPublishDate = publishDate ? publishDate.toLocaleDateString('id-ID') : 'Belum dipublikasi';
            const formattedCreatedDate = createdDate.toLocaleDateString('id-ID');

            row.innerHTML = `
                <td>
                    <input type="checkbox" class="form-check-input berita-checkbox" value="${berita.id_berita}">
                </td>
                <td>
                    <div class="berita-image">
                        ${berita.gambar ? 
                            `<img src="${base_url}uploads/berita/${berita.gambar}" alt="Berita Image" class="img-thumbnail">` :
                            '<div class="no-image"><span>No Image</span></div>'
                        }
                    </div>
                </td>
                <td>
                    <div class="berita-content">
                        <h6 class="berita-title mb-1">${berita.judul}</h6>
                        <small class="text-muted berita-excerpt">
                            ${berita.isi_berita.substring(0, 100)}...
                        </small>
                    </div>
                </td>
                <td>
                    <span class="badge bg-${berita.status === 'published' ? 'success' : 'warning'} berita-status">
                        ${berita.status.charAt(0).toUpperCase() + berita.status.slice(1)}
                    </span>
                </td>
                <td>
                    <small class="text-muted berita-publish-date">
                        ${formattedPublishDate}
                    </small>
                </td>
                <td>
                    <small class="text-muted berita-created-date">
                        ${formattedCreatedDate}
                    </small>
                </td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-info" onclick="viewBerita(${berita.id_berita})" title="Lihat Detail">
                            Lihat
                        </button>
                        <button class="btn btn-sm btn-outline-warning" onclick="editBerita(${berita.id_berita})" title="Edit Berita">
                            Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteBerita(${berita.id_berita})" title="Hapus Berita">
                            Hapus
                        </button>
                    </div>
                </td>
            `;

            tbody.appendChild(row);
        });
    }

    filterAndDisplayData() {
        // In real implementation, this would filter the actual data
        const data = this.generateSampleData();
        
        let filteredData = data.filter(berita => {
            // Search filter
            const searchMatch = this.searchTerm === '' || 
                berita.judul.toLowerCase().includes(this.searchTerm) ||
                berita.isi_berita.toLowerCase().includes(this.searchTerm);

            // Status filter
            const statusFilter = document.getElementById('filterStatus')?.value || '';
            const statusMatch = statusFilter === '' || berita.status === statusFilter;

            // Month filter
            const monthFilter = document.getElementById('filterMonth')?.value || '';
            let monthMatch = true;
            if (monthFilter && berita.tanggal_publikasi) {
                const beritaMonth = berita.tanggal_publikasi.substring(0, 7); // YYYY-MM
                monthMatch = beritaMonth === monthFilter;
            }

            return searchMatch && statusMatch && monthMatch;
        });
        
        this.displayBeritaData(filteredData);
    }

    openAddModal() {
        const modal = new bootstrap.Modal(document.getElementById('addBeritaModal'));
        modal.show();
    }

    viewNews(id) {
        // Get news data - in real implementation, this would be an AJAX call
        const berita = this.generateSampleData().find(b => b.id_berita === id);
        
        if (!berita) return;

        // Store current view ID for edit function
        this.currentViewId = id;

        // Populate view modal
        document.getElementById('viewBeritaTitle').textContent = berita.judul;
        document.getElementById('viewBeritaContent').innerHTML = berita.isi_berita.replace(/\n/g, '<br>');
        document.getElementById('viewBeritaDate').textContent = new Date(berita.tanggal_publikasi || berita.created_at).toLocaleDateString('id-ID');
        document.getElementById('viewBeritaAuthor').textContent = berita.author_name || 'Admin';
        
        // Update status badge
        const statusElement = document.getElementById('viewBeritaStatus');
        if (statusElement) {
            statusElement.textContent = berita.status === 'published' ? 'Dipublikasi' : 'Draft';
            statusElement.className = `badge bg-${berita.status === 'published' ? 'success' : 'warning'}`;
        }
        
        const imageContainer = document.getElementById('viewBeritaImage');
        if (berita.gambar) {
            imageContainer.innerHTML = `<img src="${base_url}uploads/berita/${berita.gambar}" alt="News Image" class="img-fluid rounded">`;
        } else {
            imageContainer.innerHTML = '<p class="text-muted">Tidak ada gambar</p>';
        }

        const modal = new bootstrap.Modal(document.getElementById('viewBeritaModal'));
        modal.show();
    }

    editNews(id) {
        // Get news data - in real implementation, this would be an AJAX call
        const berita = this.generateSampleData().find(b => b.id_berita === id);
        
        if (!berita) return;

        // Populate edit form
        document.getElementById('edit_berita_id').value = berita.id_berita;
        document.getElementById('edit_judul').value = berita.judul;
        document.getElementById('edit_isi_berita').value = berita.isi_berita;
        document.getElementById('edit_tanggal_publikasi').value = berita.tanggal_publikasi ? berita.tanggal_publikasi.replace(' ', 'T') : '';
        document.getElementById('edit_status').value = berita.status || 'draft';
        
        // Show current image if exists
        const currentImageDiv = document.getElementById('currentImage');
        if (berita.gambar) {
            currentImageDiv.innerHTML = `
                <p class="mb-2">Gambar saat ini:</p>
                <img src="${base_url}uploads/berita/${berita.gambar}" alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
            `;
            currentImageDiv.style.display = 'block';
        } else {
            currentImageDiv.style.display = 'none';
        }

        const modal = new bootstrap.Modal(document.getElementById('editBeritaModal'));
        modal.show();
    }

    async deleteNews(id) {
        const result = await Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus berita ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        });

        if (result.isConfirmed) {
            try {
                // In real implementation, this would be an AJAX call to delete the news
                // const response = await fetch(`${base_url}admin/berita/delete/${id}`, {
                //     method: 'DELETE',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         'X-Requested-With': 'XMLHttpRequest'
                //     }
                // });

                await Swal.fire({
                    title: 'Berhasil!',
                    text: 'Berita berhasil dihapus.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });

                this.loadBeritaData();
            } catch (error) {
                console.error('Error deleting news:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal menghapus berita. Silakan coba lagi.',
                    icon: 'error'
                });
            }
        }
    }

    async handleAddNews() {
        if (!this.validateForm('addBeritaForm')) {
            return;
        }

        try {
            const formData = new FormData();
            formData.append('judul', document.getElementById('judul').value);
            
            // Get content from CKEditor
            let isiBerita = document.getElementById('isi_berita').value;
            if (window.addEditor) {
                isiBerita = window.addEditor.getData();
            }
            formData.append('isi_berita', isiBerita);
            
            formData.append('tanggal_publikasi', document.getElementById('tanggal_publikasi').value);
            formData.append('status', document.getElementById('status').value);
            
            const imageFile = document.getElementById('gambar').files[0];
            if (imageFile) {
                formData.append('gambar', imageFile);
            }

            // In real implementation, this would be an AJAX call
            // const response = await fetch(`${base_url}admin/berita/create`, {
            //     method: 'POST',
            //     body: formData,
            //     headers: {
            //         'X-Requested-With': 'XMLHttpRequest'
            //     }
            // });

            await Swal.fire({
                title: 'Berhasil!',
                text: 'Berita berhasil ditambahkan.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });

            const modal = bootstrap.Modal.getInstance(document.getElementById('addBeritaModal'));
            modal.hide();
            
            this.loadBeritaData();
        } catch (error) {
            console.error('Error adding news:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Gagal menambahkan berita. Silakan coba lagi.',
                icon: 'error'
            });
        }
    }

    async handleEditNews() {
        if (!this.validateForm('editBeritaForm')) {
            return;
        }

        try {
            const formData = new FormData();
            const newsId = document.getElementById('edit_berita_id').value;
            
            formData.append('judul', document.getElementById('edit_judul').value);
            
            // Get content from CKEditor
            let isiBerita = document.getElementById('edit_isi_berita').value;
            if (window.editEditor) {
                isiBerita = window.editEditor.getData();
            }
            formData.append('isi_berita', isiBerita);
            
            formData.append('tanggal_publikasi', document.getElementById('edit_tanggal_publikasi').value);
            formData.append('status', document.getElementById('edit_status').value);
            
            const imageFile = document.getElementById('edit_gambar').files[0];
            if (imageFile) {
                formData.append('gambar', imageFile);
            }

            // In real implementation, this would be an AJAX call
            // const response = await fetch(`${base_url}admin/berita/update/${newsId}`, {
            //     method: 'POST',
            //     body: formData,
            //     headers: {
            //         'X-Requested-With': 'XMLHttpRequest'
            //     }
            // });

            await Swal.fire({
                title: 'Berhasil!',
                text: 'Berita berhasil diperbarui.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });

            const modal = bootstrap.Modal.getInstance(document.getElementById('editBeritaModal'));
            modal.hide();
            
            this.loadBeritaData();
        } catch (error) {
            console.error('Error updating news:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Gagal memperbarui berita. Silakan coba lagi.',
                icon: 'error'
            });
        }
    }

    validateForm(formId) {
        const form = document.getElementById(formId);
        if (!form) return false;

        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');

        requiredFields.forEach(field => {
            this.clearFieldError(field);
            
            if (!field.value.trim()) {
                this.showFieldError(field, 'Field ini wajib diisi');
                isValid = false;
            }
        });

        // Validate title length
        const titleField = form.querySelector('[name="judul"]');
        if (titleField && titleField.value.length > 255) {
            this.showFieldError(titleField, 'Judul maksimal 255 karakter');
            isValid = false;
        }

        // Validate image file
        const imageField = form.querySelector('input[type="file"]');
        if (imageField && imageField.files[0]) {
            const file = imageField.files[0];
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (!allowedTypes.includes(file.type)) {
                this.showFieldError(imageField, 'Format file harus JPG, PNG, atau GIF');
                isValid = false;
            }

            if (file.size > maxSize) {
                this.showFieldError(imageField, 'Ukuran file maksimal 5MB');
                isValid = false;
            }
        }

        return isValid;
    }

    showFieldError(field, message) {
        field.classList.add('is-invalid');
        
        let errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            field.parentNode.appendChild(errorDiv);
        }
        
        errorDiv.textContent = message;
    }

    clearFieldError(field) {
        field.classList.remove('is-invalid');
        const errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    handleImagePreview(event, previewId) {
        const file = event.target.files[0];
        const preview = document.getElementById(previewId);
        
        if (!preview) return;

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">`;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    resetAddForm() {
        const form = document.getElementById('addBeritaForm');
        if (form) {
            form.reset();
            form.querySelectorAll('.is-invalid').forEach(field => {
                field.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(error => {
                error.remove();
            });
        }
        
        const preview = document.getElementById('imagePreview');
        if (preview) {
            preview.style.display = 'none';
        }
    }

    resetEditForm() {
        const form = document.getElementById('editBeritaForm');
        if (form) {
            form.reset();
            form.querySelectorAll('.is-invalid').forEach(field => {
                field.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(error => {
                error.remove();
            });
        }
        
        const preview = document.getElementById('editImagePreview');
        if (preview) {
            preview.style.display = 'none';
        }
        
        const currentImage = document.getElementById('currentImage');
        if (currentImage) {
            currentImage.style.display = 'none';
        }
    }

    showLoading(show) {
        const loadingElement = document.getElementById('loadingSpinner');
        if (loadingElement) {
            loadingElement.style.display = show ? 'block' : 'none';
        }
    }

    showError(message) {
        Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error'
        });
    }

    initializeDataTable() {
        // Set initial date for new news
        const today = new Date().toISOString().slice(0, 16); // Format for datetime-local
        const newsDateField = document.getElementById('tanggal_publikasi');
        if (newsDateField) {
            newsDateField.value = today;
        }
    }
}

// Initialize the news manager when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the berita page
    if (document.getElementById('beritaTable')) {
        window.beritaManager = new BeritaManager();
    }
});

// Global functions for HTML onclick events
function viewBerita(id) {
    if (window.beritaManager) {
        window.beritaManager.viewNews(id);
    }
}

function editBerita(id) {
    if (window.beritaManager) {
        window.beritaManager.editNews(id);
    }
}

function deleteBerita(id) {
    if (window.beritaManager) {
        window.beritaManager.deleteNews(id);
    }
}

function resetFilters() {
    // Reset all filter fields
    document.getElementById('searchBerita').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('filterMonth').value = '';
    
    // Trigger filter update
    if (window.beritaManager) {
        window.beritaManager.searchTerm = '';
        window.beritaManager.filterAndDisplayData();
    }
}

function editBeritaFromView() {
    // Close view modal and open edit modal
    const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewBeritaModal'));
    if (viewModal) {
        viewModal.hide();
    }
    
    // Wait for modal to close then open edit modal
    setTimeout(() => {
        if (window.beritaManager && window.beritaManager.currentViewId) {
            window.beritaManager.editNews(window.beritaManager.currentViewId);
        }
    }, 300);
}

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = BeritaManager;
}
