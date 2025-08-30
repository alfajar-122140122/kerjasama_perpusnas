<?= $this->extend('layouts/admin') ?>

<?= $this->section('title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('page-title') ?>Manajemen User<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/admin/user-management.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Base URL untuk JavaScript -->
<script>
    window.BASE_URL = '<?= base_url() ?>';
</script>

<!-- Alerts -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- User Management Card -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Kelola User (<?= isset($pagination) ? $pagination['totalItems'] : (isset($users) ? count($users) : 0) ?>)</h6>
            <button class="btn btn-success btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus me-2"></i>Tambah User
            </button>
        </div>
    </div>
    
    <div class="card-body p-0">
        <!-- Search and Filter -->
        <div class="row p-3 border-bottom">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari username atau email" id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-2"></i>Filter Role
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-filter="all">Semua</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="admin">Admin</a></li>
                        <li><a class="dropdown-item" href="#" data-filter="staff">Staff</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- User Table -->
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-header">
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Nama User</th>
                        <th>Hak Akses</th>
                        <th>Terakhir Aktif</th>
                        <th style="width: 120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($users) && !empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                        <?php $userId = isset($user['id']) ? $user['id'] : ''; ?>
                        <tr class="user-row" data-user-id="<?= $userId ?>" data-email="<?= esc($user['email'] ?? '') ?>">
                            <td>
                                <input type="checkbox" class="form-check-input user-checkbox" value="<?= $userId ?>">
                            </td>
                            <td>
                                <div class="user-info">
                                    <span class="user-name"><?= esc($user['username'] ?? '') ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge user-role-badge <?= ($user['role'] ?? '') === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                    <?= ucfirst(esc($user['role'] ?? '')) ?>
                                </span>
                            </td>
                            <td>
                                <span class="last-active">
                                    <?php if (isset($user['last_active']) && $user['last_active']): ?>
                                        <?php
                                        $lastActive = new DateTime($user['last_active']);
                                        $now = new DateTime();
                                        $interval = $now->diff($lastActive);
                                        
                                        if ($interval->y > 0) {
                                            echo $interval->y . ' tahun yang lalu';
                                        } elseif ($interval->m > 0) {
                                            echo $interval->m . ' bulan yang lalu';
                                        } elseif ($interval->d > 0) {
                                            echo $interval->d . ' hari yang lalu';
                                        } elseif ($interval->h > 0) {
                                            echo $interval->h . ' jam yang lalu';
                                        } elseif ($interval->i > 0) {
                                            echo $interval->i . ' menit yang lalu';
                                        } else {
                                            echo 'Baru saja';
                                        }
                                        ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-edit" 
                                            data-user-id="<?= $userId ?>"
                                            data-username="<?= esc($user['username'] ?? '') ?>"
                                            data-hak-akses="<?= esc($user['role'] ?? '') ?>"
                                            data-email="<?= esc($user['email'] ?? '') ?>"
                                            title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-delete" 
                                            data-user-id="<?= $userId ?>"
                                            data-username="<?= esc($user['username'] ?? '') ?>"
                                            title="Hapus User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="empty-state">
                                    <i class="fas fa-users fa-3x mb-3 text-muted"></i>
                                    <h5>Belum ada user</h5>
                                    <p>Tambahkan user pertama dengan klik tombol "Tambah User"</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center p-3 border-top">
            <div class="text-muted">
                <?php if(isset($pagination)): ?>
                    Menampilkan <?= $pagination['startItem'] ?>-<?= $pagination['endItem'] ?> dari <?= $pagination['totalItems'] ?> user
                <?php else: ?>
                    <?php
                    $count = isset($users) ? count($users) : 0;
                    $start = $count > 0 ? 1 : 0;
                    echo "Menampilkan {$start}-{$count} dari {$count} user";
                    ?>
                <?php endif; ?>
            </div>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <?php if(isset($pagination) && $pagination['totalPages'] > 1): ?>
                        <!-- Previous Button -->
                        <li class="page-item <?= $pagination['currentPage'] == 1 ? 'disabled' : '' ?>">
                            <?php if($pagination['currentPage'] == 1): ?>
                                <span class="page-link">Previous</span>
                            <?php else: ?>
                                <a class="page-link" href="?page=<?= $pagination['currentPage'] - 1 ?>">Previous</a>
                            <?php endif; ?>
                        </li>
                        
                        <!-- Page Numbers -->
                        <?php 
                        $startPage = max(1, $pagination['currentPage'] - 2);
                        $endPage = min($pagination['totalPages'], $pagination['currentPage'] + 2);
                        ?>
                        
                        <?php if($startPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1">1</a>
                            </li>
                            <?php if($startPage > 2): ?>
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for($i = $startPage; $i <= $endPage; $i++): ?>
                            <li class="page-item <?= $i == $pagination['currentPage'] ? 'active' : '' ?>">
                                <?php if($i == $pagination['currentPage']): ?>
                                    <span class="page-link"><?= $i ?></span>
                                <?php else: ?>
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if($endPage < $pagination['totalPages']): ?>
                            <?php if($endPage < $pagination['totalPages'] - 1): ?>
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $pagination['totalPages'] ?>"><?= $pagination['totalPages'] ?></a>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Next Button -->
                        <li class="page-item <?= $pagination['currentPage'] == $pagination['totalPages'] ? 'disabled' : '' ?>">
                            <?php if($pagination['currentPage'] == $pagination['totalPages']): ?>
                                <span class="page-link">Next</span>
                            <?php else: ?>
                                <a class="page-link" href="?page=<?= $pagination['currentPage'] + 1 ?>">Next</a>
                            <?php endif; ?>
                        </li>
                    <?php else: ?>
                        <!-- Default single page view -->
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">
                    Tambah User Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/users/add') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username *</label>
                        <input type="text" class="form-control" id="username" name="username" required minlength="3" maxlength="50" value="<?= old('username') ?>">
                        <div class="form-text">Username minimal 3 karakter</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required maxlength="100" value="<?= old('email') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required minlength="8" oninput="checkPasswordStrength(this, 'add')">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Password minimal 8 karakter</div>
                        <!-- Password Strength Bar -->
                        <div class="progress mt-2" style="height: 8px;">
                            <div class="progress-bar" id="passwordStrengthAdd" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthTextAdd" class="text-muted">Masukkan password untuk melihat kekuatan</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="hak_akses" class="form-label">Hak Akses *</label>
                        <select class="form-select" id="hak_akses" name="hak_akses" required>
                            <option value="">Pilih Hak Akses</option>
                            <option value="admin" <?= old('hak_akses') === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="staff" <?= old('hak_akses') === 'staff' ? 'selected' : '' ?>>Staff</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">
                    Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" id="edit_user_id" name="user_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username *</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required minlength="3" maxlength="50">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required maxlength="100">
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit_password" name="password" minlength="8" oninput="checkPasswordStrength(this, 'edit')">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('edit_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Password minimal 8 karakter</div>
                        <!-- Password Strength Bar -->
                        <div class="progress mt-2" style="height: 8px;">
                            <div class="progress-bar" id="passwordStrengthEdit" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="passwordStrengthTextEdit" class="text-muted">Masukkan password untuk melihat kekuatan</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_hak_akses" class="form-label">Hak Akses *</label>
                        <select class="form-select" id="edit_hak_akses" name="hak_akses" required>
                            <option value="">Pilih Hak Akses</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
a<script>
// Pagination variables
let currentPage = 1;
let currentFilter = 'all';
let currentSearch = '';
const itemsPerPage = 10;

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    setupPaginationListeners();
    // Small delay to ensure all DOM elements are ready
    setTimeout(() => {
        displayPage(1);
    }, 100);
});

function setupPaginationListeners() {
    // Search functionality with pagination
    document.getElementById('searchInput').addEventListener('keyup', function() {
        currentSearch = this.value.toLowerCase();
        currentPage = 1; // Reset to first page
        displayPage(currentPage);
    });

    // Filter functionality with pagination
    document.querySelectorAll('[data-filter]').forEach(filterBtn => {
        filterBtn.addEventListener('click', function(e) {
            e.preventDefault();
            currentFilter = this.dataset.filter;
            currentPage = 1; // Reset to first page
            displayPage(currentPage);
            
            // Update filter button text
            document.getElementById('filterDropdown').innerHTML = `<i class="fas fa-filter me-2"></i>${this.textContent}`;
        });
    });
}

// Function to get all visible rows based on current search and filter
function getFilteredRows() {
    const tableRows = document.querySelectorAll('tbody tr.user-row');
    const filteredRows = [];
    
    tableRows.forEach(row => {
        let showRow = true;
        
        // Apply search filter
        if (currentSearch) {
            const username = row.querySelector('.user-name')?.textContent.toLowerCase() || '';
            const email = row.getAttribute('data-email')?.toLowerCase() || '';
            
            if (!username.includes(currentSearch) && !email.includes(currentSearch)) {
                showRow = false;
            }
        }
        
        // Apply role filter
        if (currentFilter !== 'all' && showRow) {
            const roleElement = row.querySelector('.user-role-badge');
            const role = roleElement?.textContent.toLowerCase().trim();
            if (role !== currentFilter) {
                showRow = false;
            }
        }
        
        if (showRow) {
            filteredRows.push(row);
        }
    });
    
    return filteredRows;
}

// Function to display current page
function displayPage(page) {
    const filteredRows = getFilteredRows();
    const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
    
    // Validate page number
    if (page < 1) page = 1;
    if (page > totalPages && totalPages > 0) page = totalPages;
    if (totalPages === 0) page = 1;
    
    currentPage = page;
    
    // Hide all rows first
    const allRows = document.querySelectorAll('tbody tr');
    allRows.forEach(row => row.style.display = 'none');
    
    // Show rows for current page
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageRows = filteredRows.slice(startIndex, endIndex);
    
    pageRows.forEach(row => row.style.display = '');
    
    // Show empty state if no filtered results
    const emptyRow = document.querySelector('tbody tr:not(.user-row)');
    if (filteredRows.length === 0 && emptyRow) {
        emptyRow.style.display = '';
    }
    
    // Update pagination controls
    updatePaginationControls(totalPages, filteredRows.length);
    
    return totalPages;
}

// Function to update pagination controls
function updatePaginationControls(totalPages, totalItems) {
    const paginationContainer = document.querySelector('.pagination');
    if (!paginationContainer) return;
    
    paginationContainer.innerHTML = '';
    
    if (totalPages <= 1) {
        paginationContainer.style.display = 'none';
        return;
    }
    
    paginationContainer.style.display = 'flex';
    
    // Previous button
    const prevLi = document.createElement('li');
    prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>`;
    paginationContainer.appendChild(prevLi);
    
    // Page numbers
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);
    
    if (startPage > 1) {
        const firstLi = document.createElement('li');
        firstLi.className = 'page-item';
        firstLi.innerHTML = `<a class="page-link" href="#" data-page="1">1</a>`;
        paginationContainer.appendChild(firstLi);
        
        if (startPage > 2) {
            const dotsLi = document.createElement('li');
            dotsLi.className = 'page-item disabled';
            dotsLi.innerHTML = `<span class="page-link">...</span>`;
            paginationContainer.appendChild(dotsLi);
        }
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
        paginationContainer.appendChild(li);
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const dotsLi = document.createElement('li');
            dotsLi.className = 'page-item disabled';
            dotsLi.innerHTML = `<span class="page-link">...</span>`;
            paginationContainer.appendChild(dotsLi);
        }
        
        const lastLi = document.createElement('li');
        lastLi.className = 'page-item';
        lastLi.innerHTML = `<a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>`;
        paginationContainer.appendChild(lastLi);
    }
    
    // Next button
    const nextLi = document.createElement('li');
    nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>`;
    paginationContainer.appendChild(nextLi);
    
    // Add click events to pagination links
    paginationContainer.addEventListener('click', function(e) {
        e.preventDefault();
        if (e.target.classList.contains('page-link') && e.target.hasAttribute('data-page')) {
            const page = parseInt(e.target.getAttribute('data-page'));
            if (page !== currentPage && page >= 1 && page <= totalPages) {
                displayPage(page);
            }
        }
    });
}
</script>
<script src="<?= base_url('js/admin/user-management.js') ?>"></script>
<?= $this->endSection() ?>