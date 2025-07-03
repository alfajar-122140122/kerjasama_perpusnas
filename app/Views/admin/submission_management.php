<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen Permohonan Kerjasama<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen Permohonan Kerjasama<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <h2 class="page-title">Manajemen Permohonan Kerjasama</h2>
            <p class="text-muted mb-4">Kelola permohonan kerjasama dari mitra Perpustakaan Nasional</p>
        </div>
    </div>

    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Permohonan</div>
                            <div class="h5 mb-0" id="totalPermohonan"><?= $statistics['total'] ?></div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Menunggu Review</div>
                            <div class="h5 mb-0" id="permohonanPending"><?= $statistics['pending'] ?></div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0" id="permohonanApproved"><?= $statistics['approved'] ?></div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0" id="permohonanRejected"><?= $statistics['rejected'] ?></div>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Permohonan Kerjasama</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="submissionTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Nama Mitra</th>
                            <th>Jenis</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($permohonan as $row): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                            <td><?= $row['nama_mitra'] ?></td>
                            <td><?= $row['jenis_kerjasama'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['telepon'] ?></td>
                            <td>
                                <?php
                                switch ($row['status']) {
                                    case 'pending':
                                        echo '<span class="badge badge-warning">Menunggu Review</span>';
                                        break;
                                    case 'approved':
                                        echo '<span class="badge badge-success">Disetujui</span>';
                                        break;
                                    case 'rejected':
                                        echo '<span class="badge badge-danger">Ditolak</span>';
                                        break;
                                    default:
                                        echo '<span class="badge badge-secondary">Unknown</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info view-btn" data-id="<?= $row['id'] ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php if($row['status'] == 'pending'): ?>
                                <button class="btn btn-sm btn-success approve-btn" data-id="<?= $row['id'] ?>">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-danger reject-btn" data-id="<?= $row['id'] ?>">
                                    <i class="fas fa-times"></i>
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Permohonan Kerjasama</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th width="40%">Nama Mitra</th>
                                <td id="detail-nama-mitra"></td>
                            </tr>
                            <tr>
                                <th>Jenis Kerjasama</th>
                                <td id="detail-jenis"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td id="detail-email"></td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td id="detail-telepon"></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td id="detail-alamat"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th width="40%">Tanggal Pengajuan</th>
                                <td id="detail-tanggal"></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="detail-status"></td>
                            </tr>
                            <tr>
                                <th>Ditinjau Oleh</th>
                                <td id="detail-reviewer"></td>
                            </tr>
                            <tr>
                                <th>Tanggal Review</th>
                                <td id="detail-tanggal-review"></td>
                            </tr>
                            <tr>
                                <th>Dokumen</th>
                                <td id="detail-dokumen"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Deskripsi Kerjasama</h6>
                            </div>
                            <div class="card-body">
                                <p id="detail-deskripsi"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" id="catatan-section" style="display: none;">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Catatan Review</h6>
                            </div>
                            <div class="card-body">
                                <p id="detail-catatan"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <div id="action-buttons"></div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Setujui Permohonan Kerjasama</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="approveForm">
                <div class="modal-body">
                    <input type="hidden" id="approve_id" name="id">
                    <div class="form-group">
                        <label for="catatan_approve">Catatan (opsional)</label>
                        <textarea class="form-control" id="catatan_approve" name="catatan" rows="3"></textarea>
                        <small class="text-muted">Catatan ini akan dikirimkan ke email pemohon</small>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="send_notification" name="send_notification" checked>
                            <label class="custom-control-label" for="send_notification">Kirim notifikasi email ke pemohon</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Permohonan Kerjasama</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectForm">
                <div class="modal-body">
                    <input type="hidden" id="reject_id" name="id">
                    <div class="form-group">
                        <label for="alasan_penolakan">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alasan_penolakan" name="catatan" rows="3" required></textarea>
                        <small class="text-muted">Alasan penolakan akan dikirimkan ke email pemohon</small>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="send_notification_reject" name="send_notification" checked>
                            <label class="custom-control-label" for="send_notification_reject">Kirim notifikasi email ke pemohon</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#submissionTable').DataTable({
        responsive: true
    });
    
    // View Detail Button
    $('.view-btn').click(function() {
        const id = $(this).data('id');
        
        $.ajax({
            url: '<?= site_url('admin/submission-management/detail/') ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    
                    // Fill detail modal
                    $('#detail-nama-mitra').text(data.nama_mitra);
                    $('#detail-jenis').text(data.jenis_kerjasama);
                    $('#detail-email').text(data.email);
                    $('#detail-telepon').text(data.telepon);
                    $('#detail-alamat').text(data.alamat);
                    $('#detail-tanggal').text(formatDate(data.created_at));
                    $('#detail-deskripsi').text(data.deskripsi);
                    
                    // Status badge
                    let statusBadge = '';
                    switch (data.status) {
                        case 'pending':
                            statusBadge = '<span class="badge badge-warning">Menunggu Review</span>';
                            break;
                        case 'approved':
                            statusBadge = '<span class="badge badge-success">Disetujui</span>';
                            break;
                        case 'rejected':
                            statusBadge = '<span class="badge badge-danger">Ditolak</span>';
                            break;
                        default:
                            statusBadge = '<span class="badge badge-secondary">Unknown</span>';
                    }
                    $('#detail-status').html(statusBadge);
                    
                    // Reviewer info
                    if (data.reviewed_by) {
                        $('#detail-reviewer').text(data.reviewer_name);
                        $('#detail-tanggal-review').text(formatDate(data.reviewed_at));
                    } else {
                        $('#detail-reviewer').text('-');
                        $('#detail-tanggal-review').text('-');
                    }
                    
                    // Document link
                    if (data.file_dokumen) {
                        $('#detail-dokumen').html(`
                            <a href="<?= base_url('uploads/permohonan/') ?>${data.file_dokumen}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fa fa-file-pdf"></i> Lihat Dokumen
                            </a>
                        `);
                    } else {
                        $('#detail-dokumen').text('Tidak ada dokumen');
                    }
                    
                    // Show catatan if exists
                    if (data.catatan) {
                        $('#detail-catatan').text(data.catatan);
                        $('#catatan-section').show();
                    } else {
                        $('#catatan-section').hide();
                    }
                    
                    // Action buttons based on status
                    let actionButtons = '';
                    if (data.status === 'pending') {
                        actionButtons = `
                            <button type="button" class="btn btn-success approve-detail-btn" data-id="${data.id}">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                            <button type="button" class="btn btn-danger reject-detail-btn" data-id="${data.id}">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        `;
                    }
                    $('#action-buttons').html(actionButtons);
                    
                    // Show modal
                    $('#detailModal').modal('show');
                    
                    // Add event listeners for action buttons
                    $('.approve-detail-btn').click(function() {
                        const id = $(this).data('id');
                        $('#approve_id').val(id);
                        $('#detailModal').modal('hide');
                        $('#approveModal').modal('show');
                    });
                    
                    $('.reject-detail-btn').click(function() {
                        const id = $(this).data('id');
                        $('#reject_id').val(id);
                        $('#detailModal').modal('hide');
                        $('#rejectModal').modal('show');
                    });
                    
                } else {
                    showAlert('error', 'Gagal memuat data permohonan');
                }
            },
            error: function() {
                showAlert('error', 'Terjadi kesalahan server');
            }
        });
    });
    
    // Approve Button (from table)
    $('.approve-btn').click(function() {
        const id = $(this).data('id');
        $('#approve_id').val(id);
        $('#approveModal').modal('show');
    });
    
    // Reject Button (from table)
    $('.reject-btn').click(function() {
        const id = $(this).data('id');
        $('#reject_id').val(id);
        $('#rejectModal').modal('show');
    });
    
    // Approve Form Submission
    $('#approveForm').submit(function(e) {
        e.preventDefault();
        
        const id = $('#approve_id').val();
        const formData = $(this).serialize();
        
        $.ajax({
            url: '<?= site_url('admin/submission-management/approve/') ?>' + id,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#approveModal').modal('hide');
                    showAlert('success', response.message);
                    setTimeout(function() {
                        location.reload();
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
    
    // Reject Form Submission
    $('#rejectForm').submit(function(e) {
        e.preventDefault();
        
        const id = $('#reject_id').val();
        const formData = $(this).serialize();
        
        $.ajax({
            url: '<?= site_url('admin/submission-management/reject/') ?>' + id,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#rejectModal').modal('hide');
                    showAlert('success', response.message);
                    setTimeout(function() {
                        location.reload();
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
    
    // Helper function to format date
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }).replace(',', ' -');
    }
    
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
