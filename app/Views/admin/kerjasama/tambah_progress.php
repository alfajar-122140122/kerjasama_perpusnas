<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>
Tambah Progress Kerjasama
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0 text-gray-800">Admin / Tambah Progress Kerjasama</h2>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form id="tambahProgressForm" action="<?= base_url('admin/kerjasama/progress/store') ?>" method="POST">
                        <div class="mb-3">
                            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nama_mitra" class="form-label">Nama Mitra <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_mitra" name="nama_mitra" placeholder="Masukkan nama mitra" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
                            <select class="form-select" id="jenis" name="jenis" required>
                                <option value="" selected disabled>Pilih jenis</option>
                                <option value="Baru">Baru</option>
                                <option value="Perpanjangan">Perpanjangan</option>
                                <option value="Dokumentasi">Dokumentasi</option>
                                <option value="Finishing">Finishing</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="progress" class="form-label">Progress <span class="text-danger">*</span></label>
                            <select class="form-select" id="progress" name="progress" required>
                                <option value="" selected disabled>Pilih progress</option>
                                <option value="Dokumentasi">Dokumentasi</option>
                                <option value="Finishing">Finishing</option>
                                <option value="Review">Review</option>
                                <option value="Approval">Approval</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="published" selected>Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="kerjasama_id" class="form-label">Kerjasama (Opsional)</label>
                            <select class="form-select" id="kerjasama_id" name="kerjasama_id">
                                <option value="" selected>Pilih kerjasama terkait (opsional)</option>
                                <!-- This will be populated via AJAX -->
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('admin/kerjasama/progress') ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load kerjasama options for the dropdown
    fetch('<?= base_url('admin/kerjasama/get-all') ?>')
        .then(response => response.json())
        .then(data => {
            if (data.status && data.data) {
                const selectElement = document.getElementById('kerjasama_id');
                data.data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.nama_mitra;
                    selectElement.appendChild(option);
                });
            }
        })
        .catch(error => console.error('Error loading kerjasama data:', error));
    
    // Form submission handler
    document.getElementById('tambahProgressForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                alert('Data progress kerjasama berhasil disimpan');
                window.location.href = '<?= base_url('admin/kerjasama/progress') ?>';
            } else {
                alert('Gagal menyimpan data: ' + (data.message || 'Terjadi kesalahan'));
                
                // Display validation errors if any
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        const input = document.querySelector(`[name="${key}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedback = document.createElement('div');
                            feedback.className = 'invalid-feedback';
                            feedback.textContent = data.errors[key];
                            input.parentNode.appendChild(feedback);
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data');
        });
    });
    
    // Clear validation on input
    document.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const feedback = this.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.remove();
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
