<?php
/**
 * Simple Pagination Component
 * 
 * Cara Penggunaan:
 * <?= view('components/pagination_simple', [
 *     'current_page' => $current_page,
 *     'total_pages' => $total_pages,
 *     'links_count' => 5, // Opsional, default 5
 * ]) ?>
 */

// Parameter dengan nilai default
$current_page = $current_page ?? 1;
$total_pages = $total_pages ?? 1;
$links_count = $links_count ?? 5;

// Hitung range halaman yang akan ditampilkan
$half = floor($links_count / 2);
$start_page = max(1, $current_page - $half);
$end_page = min($total_pages, $start_page + $links_count - 1);

// Jika end_page terlalu kecil, sesuaikan start_page
if ($end_page - $start_page + 1 < $links_count && $start_page > 1) {
    $start_page = max(1, $end_page - $links_count + 1);
}

// Dapatkan URL saat ini tanpa parameter page
$current_url = current_url();
$query_params = $_GET;
unset($query_params['page']);
$query_string = http_build_query($query_params);
$base_url = $current_url . ($query_string ? "?{$query_string}&" : "?");
?>

<div class="d-flex justify-content-between align-items-center my-3">
    <div class="text-muted small">
        Halaman <?= $current_page ?> dari <?= $total_pages ?>
    </div>
    
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm mb-0">
            <!-- Tombol Previous -->
            <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= ($current_page <= 1) ? '#' : $base_url . 'page=' . ($current_page - 1) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            
            <!-- Nomor Halaman -->
            <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
                    <a class="page-link" href="<?= ($i == $current_page) ? '#' : $base_url . 'page=' . $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
            
            <!-- Tombol Next -->
            <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= ($current_page >= $total_pages) ? '#' : $base_url . 'page=' . ($current_page + 1) ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>