<?php
<!-- Advanced Search Component -->
<div class="card mb-4" id="advancedSearchCard" style="display: none;">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Pencarian Lanjutan</h6>
    </div>
    <div class="card-body">
        <form id="advancedSearchForm">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="search_field" class="form-label">Cari dalam</label>
                        <select class="form-select" id="search_field" name="search_field">
                            <option value="all">Semua Field</option>
                            <option value="nama_mitra">Nama Mitra</option>
                            <option value="jenis">Jenis Kerjasama</option>
                            <option value="ruang_lingkup">Ruang Lingkup</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="date_from" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="date_from" name="date_from">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="date_to" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="date_to" name="date_to">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="progress_filter" class="form-label">Status Progress</label>
                        <select class="form-select" id="progress_filter" name="progress">
                            <option value="">Semua Status</option>
                            <option value="draft">Draft</option>
                            <option value="aktif">Aktif</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                    <button type="button" class="btn btn-secondary me-2" onclick="resetAdvancedSearch()">
                        <i class="fas fa-undo me-1"></i>Reset
                    </button>
                    <button type="button" class="btn btn-outline-primary me-2" onclick="exportData()">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleAdvancedSearch()">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function toggleAdvancedSearch() {
    const card = document.getElementById('advancedSearchCard');
    const isVisible = card.style.display !== 'none';
    card.style.display = isVisible ? 'none' : 'block';
    
    // Update toggle button text
    const toggleBtn = document.querySelector('[onclick="toggleAdvancedSearch()"]');
    if (toggleBtn && !toggleBtn.innerHTML.includes('Tutup')) {
        toggleBtn.innerHTML = isVisible ? 
            '<i class="fas fa-search-plus me-1"></i>Pencarian Lanjutan' : 
            '<i class="fas fa-times me-1"></i>Tutup';
    }
}

function resetAdvancedSearch() {
    document.getElementById('advancedSearchForm').reset();
    // Trigger search with empty filters
    if (typeof loadKerjasamaTable === 'function') {
        loadKerjasamaTable();
    }
}

function exportData() {
    // Show export options modal
    showExportModal();
}

function showExportModal() {
    const modalHtml = `
        <div class="modal fade" id="exportModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Export Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Format Export</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="export_format" id="export_excel" value="excel" checked>
                                <label class="form-check-label" for="export_excel">
                                    <i class="fas fa-file-excel text-success me-2"></i>Excel (.xlsx)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="export_format" id="export_pdf" value="pdf">
                                <label class="form-check-label" for="export_pdf">
                                    <i class="fas fa-file-pdf text-danger me-2"></i>PDF (.pdf)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="export_format" id="export_csv" value="csv">
                                <label class="form-check-label" for="export_csv">
                                    <i class="fas fa-file-csv text-info me-2"></i>CSV (.csv)
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="include_filters" checked>
                                <label class="form-check-label" for="include_filters">
                                    Gunakan filter yang sedang aktif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="processExport()">
                            <i class="fas fa-download me-2"></i>Download
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('exportModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('exportModal'));
    modal.show();
}

function processExport() {
    const format = document.querySelector('input[name="export_format"]:checked').value;
    const includeFilters = document.getElementById('include_filters').checked;
    
    // Show loading
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    btn.disabled = true;
    
    // Simulate export process
    setTimeout(() => {
        // In real implementation, make actual export API call
        showAlert('success', `Data berhasil diexport dalam format ${format.toUpperCase()}`);
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
        modal.hide();
        
        // Reset button
        btn.innerHTML = originalText;
        btn.disabled = false;
    }, 2000);
}
</script>