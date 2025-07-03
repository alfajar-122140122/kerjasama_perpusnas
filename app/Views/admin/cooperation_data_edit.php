<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Edit Data Kerjasama<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Edit Data Kerjasama<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <h2 class="page-title">Edit Data Kerjasama</h2>
            <p class="text-muted mb-4">Edit data kerjasama Perpustakaan Nasional</p>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Kerjasama</h6>
                </div>
                <div class="card-body">
                    <form id="editKerjasamaForm" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $kerjasama['id'] ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama_mitra">Nama Mitra <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_mitra" name="nama_mitra" value="<?= $kerjasama['nama_mitra'] ?>" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="jenis_kerjasama">Jenis Kerjasama <span class="text-danger">*</span></label>
                                    <select class="form-control" id="jenis_kerjasama" name="jenis_kerjasama" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="MOU" <?= ($kerjasama['jenis_kerjasama'] == 'MOU') ? 'selected' : '' ?>>MOU (Memorandum of Understanding)</option>
                                        <option value="PKS" <?= ($kerjasama['jenis_kerjasama'] == 'PKS') ? 'selected' : '' ?>>PKS (Perjanjian Kerja Sama)</option>
                                        <option value="NKB" <?= ($kerjasama['jenis_kerjasama'] == 'NKB') ? 'selected' : '' ?>>NKB (Nota Kesepahaman Bersama)</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="kategori">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control" id="kategori" name="kategori" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Pendidikan" <?= ($kerjasama['kategori'] == 'Pendidikan') ? 'selected' : '' ?>>Pendidikan</option>
                                        <option value="Penelitian" <?= ($kerjasama['kategori'] == 'Penelitian') ? 'selected' : '' ?>>Penelitian</option>
                                        <option value="Pengembangan Teknologi" <?= ($kerjasama['kategori'] == 'Pengembangan Teknologi') ? 'selected' : '' ?>>Pengembangan Teknologi</option>
                                        <option value="Pengabdian Masyarakat" <?= ($kerjasama['kategori'] == 'Pengabdian Masyarakat') ? 'selected' : '' ?>>Pengabdian Masyarakat</option>
                                        <option value="Lainnya" <?= ($kerjasama['kategori'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="nomor_kerjasama">Nomor Kerjasama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nomor_kerjasama" name="nomor_kerjasama" value="<?= $kerjasama['nomor_kerjasama'] ?>" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= $kerjasama['tanggal_mulai'] ?>" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="tanggal_akhir">Tanggal Berakhir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?= $kerjasama['tanggal_akhir'] ?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="ruang_lingkup">Ruang Lingkup <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="ruang_lingkup" name="ruang_lingkup" rows="3" required><?= $kerjasama['ruang_lingkup'] ?></textarea>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="tujuan">Tujuan Kerjasama <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="tujuan" name="tujuan" rows="3" required><?= $kerjasama['tujuan'] ?></textarea>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="pejabat_penandatangan">Pejabat Penandatangan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pejabat_penandatangan" name="pejabat_penandatangan" value="<?= $kerjasama['pejabat_penandatangan'] ?>" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" <?= ($kerjasama['status'] == 'active') ? 'selected' : '' ?>>Aktif</option>
                                        <option value="inactive" <?= ($kerjasama['status'] == 'inactive') ? 'selected' : '' ?>>Tidak Aktif</option>
                                        <option value="expired" <?= ($kerjasama['status'] == 'expired') ? 'selected' : '' ?>>Kedaluwarsa</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="file_kerjasama">File Dokumen Kerjasama</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file_kerjasama" name="file_kerjasama" accept=".pdf">
                                            <label class="custom-file-label" for="file_kerjasama">Pilih file</label>
                                        </div>
                                    </div>
                                    <small class="text-muted">Format: PDF. Maks: 10MB</small>
                                    <?php if(!empty($kerjasama['file_dokumen'])): ?>
                                    <div class="mt-2">
                                        <span class="text-primary">File saat ini: </span>
                                        <a href="<?= base_url('uploads/kerjasama/' . $kerjasama['file_dokumen']) ?>" target="_blank">
                                            <i class="fa fa-file-pdf"></i> <?= $kerjasama['file_dokumen'] ?>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Lokasi Mitra</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" value="<?= $kerjasama['latitude'] ?>">
                                        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" value="<?= $kerjasama['longitude'] ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button" id="pickLocationBtn">
                                                <i class="fa fa-map-marker-alt"></i> Pilih Lokasi
                                            </button>
                                        </div>
                                    </div>
                                    <div id="mapPicker" style="height: 200px; display: none;"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="<?= site_url('admin/cooperation-data') ?>" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // File input change event
    $('#file_kerjasama').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
        
        // Validate file size
        const fileSize = this.files[0].size / 1024 / 1024; // in MB
        if (fileSize > 10) {
            alert('Ukuran file terlalu besar. Maksimal 10MB');
            $(this).val('');
            $(this).next('.custom-file-label').html('Pilih file');
        }
    });
    
    // Datepicker validation
    $('#tanggal_mulai, #tanggal_akhir').on('change', function() {
        const startDate = new Date($('#tanggal_mulai').val());
        const endDate = new Date($('#tanggal_akhir').val());
        
        if (endDate <= startDate) {
            alert('Tanggal berakhir harus setelah tanggal mulai');
            $('#tanggal_akhir').val('');
        }
    });
    
    // Map picker
    let map, marker;
    $('#pickLocationBtn').click(function() {
        $('#mapPicker').toggle();
        
        if ($('#mapPicker').is(':visible')) {
            if (!map) {
                setTimeout(function() {
                    initMap();
                }, 300);
            }
        }
    });
    
    function initMap() {
        const lat = parseFloat($('#latitude').val()) || -2.548926;
        const lng = parseFloat($('#longitude').val()) || 118.0148634;
        
        map = L.map('mapPicker').setView([lat, lng], 5);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);
        
        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            $('#latitude').val(position.lat.toFixed(6));
            $('#longitude').val(position.lng.toFixed(6));
        });
        
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            $('#latitude').val(e.latlng.lat.toFixed(6));
            $('#longitude').val(e.latlng.lng.toFixed(6));
        });
        
        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    }
    
    // Form submission
    $('#editKerjasamaForm').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: '<?= site_url('admin/cooperation-data/update/') ?>' + formData.get('id'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    setTimeout(function() {
                        window.location.href = '<?= site_url('admin/cooperation-data') ?>';
                    }, 1500);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function() {
                showAlert('error', 'Terjadi kesalahan server');
            }
        });
    });
    
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertIcon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
        
        $('#alertContainer').html(`
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fa ${alertIcon} mr-1"></i> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `);
        
        // Auto-close alert after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    }
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
