<?php
/**
 * Pagination Component untuk Public
 * 
 * Cara Penggunaan:
 * <?= view('layouts/components/pagination_public') ?>
 */
?>

<div class="pagination-public-wrapper">
    <div class="pagination-public-left">
        <div class="pagination-public-rows-selector">
            <span>Tampilkan</span>
            <select id="pagination-public-rows-per-page">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>data</span>
        </div>
        
        <div class="pagination-public-info">
            <span id="pagination-public-start">1</span> - <span id="pagination-public-end">10</span> dari <span id="pagination-public-total-rows">0</span> data
        </div>
    </div>
    
    <div class="pagination-public-controls">
        <button type="button" class="pagination-public-btn" id="pagination-public-prev" disabled>
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <div class="pagination-public-pages" id="pagination-public-pages">
            <button type="button" class="pagination-public-page active" data-page="1">1</button>
        </div>
        
        <button type="button" class="pagination-public-btn" id="pagination-public-next" disabled>
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>