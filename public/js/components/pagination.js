/**
 * Simple Client-Side Table Pagination
 * 
 * Cara penggunaan:
 * 1. Tambahkan class 'table-paginate' pada tabel
 * 2. Tambahkan div dengan class 'pagination-container' setelah tabel
 * 3. Opsional: tambahkan atribut data-items-per-page="10" pada tabel untuk mengatur jumlah baris default per halaman
 * 4. Opsional: tambahkan atribut data-page-sizes="5,10,25,50,100" untuk kustomisasi pilihan jumlah baris
 */

document.addEventListener('DOMContentLoaded', function() {
    // Cari semua tabel dengan class 'table-paginate'
    const tables = document.querySelectorAll('table.table-paginate');
    
    tables.forEach(function(table) {
        // Inisialisasi pagination untuk setiap tabel
        initTablePagination(table);
    });
    
    function initTablePagination(table) {
        // Cari container pagination terdekat
        const paginationContainer = table.nextElementSibling;
        if (!paginationContainer || !paginationContainer.classList.contains('pagination-container')) {
            console.error('Pagination container tidak ditemukan setelah tabel');
            return;
        }
        
        // Mendapatkan semua baris (kecuali header)
        const tbody = table.querySelector('tbody');
        if (!tbody) {
            console.error('Table body tidak ditemukan');
            return;
        }
        
        const rows = tbody.querySelectorAll('tr');
        if (rows.length === 0) return;
        
        // Konfigurasi pagination
        let itemsPerPage = parseInt(table.getAttribute('data-items-per-page')) || 10;
        let totalPages = Math.ceil(rows.length / itemsPerPage);
        let currentPage = 1;
        
        // Opsi jumlah baris per halaman (default atau dari atribut)
        let pageSizesAttr = table.getAttribute('data-page-sizes');
        let pageSizes = pageSizesAttr ? pageSizesAttr.split(',').map(Number) : [5, 10, 25, 50, 100];
        
        // Buat kontrol pagination
        createPaginationControls(paginationContainer, totalPages, currentPage, itemsPerPage, pageSizes);
        
        // Tampilkan halaman pertama
        showPage(currentPage);
        
        // Fungsi untuk menampilkan halaman tertentu
        function showPage(page) {
            // Validasi halaman
            if (page < 1) page = 1;
            if (page > totalPages) page = totalPages;
            
            currentPage = page;
            
            // Tentukan baris mana yang akan ditampilkan
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            
            // Sembunyikan semua baris
            rows.forEach((row, index) => {
                if (index >= start && index < end) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update kontrol pagination
            updatePaginationControls(paginationContainer, totalPages, currentPage, itemsPerPage);
        }
        
        // Fungsi untuk mengubah jumlah item per halaman
        function changeItemsPerPage(newSize) {
            itemsPerPage = parseInt(newSize);
            totalPages = Math.ceil(rows.length / itemsPerPage);
            
            // Reset ke halaman pertama
            currentPage = 1;
            
            // Tampilkan halaman pertama dengan jumlah item baru
            showPage(currentPage);
            
            // Perbarui kontrol pagination
            createPaginationControls(paginationContainer, totalPages, currentPage, itemsPerPage, pageSizes);
        }
        
        // Fungsi untuk membuat kontrol pagination
        function createPaginationControls(container, totalPages, currentPage, itemsPerPage, pageSizes) {
            // Hapus kontrol yang sudah ada
            container.innerHTML = '';
            
            // Buat container utama
            const mainContainer = document.createElement('div');
            mainContainer.className = 'd-flex flex-wrap justify-content-between align-items-center my-3';
            
            // Buat bagian kiri (rows per page selector)
            const leftContainer = document.createElement('div');
            leftContainer.className = 'd-flex align-items-center';
            
            const rowsLabel = document.createElement('label');
            rowsLabel.className = 'me-2 small';
            rowsLabel.textContent = 'Baris per halaman:';
            
            const rowsSelect = document.createElement('select');
            rowsSelect.className = 'form-select form-select-sm';
            rowsSelect.style.width = 'auto';
            
            // Tambahkan opsi ke select
            pageSizes.forEach(size => {
                const option = document.createElement('option');
                option.value = size;
                option.textContent = size;
                if (size === itemsPerPage) {
                    option.selected = true;
                }
                rowsSelect.appendChild(option);
            });
            
            // Event listener untuk perubahan jumlah item
            rowsSelect.addEventListener('change', function() {
                changeItemsPerPage(this.value);
            });
            
            leftContainer.appendChild(rowsLabel);
            leftContainer.appendChild(rowsSelect);
            
            // Info halaman
            const pageInfo = document.createElement('div');
            pageInfo.className = 'text-muted small ms-3';
            pageInfo.textContent = `Halaman ${currentPage} dari ${totalPages} (${rows.length} data)`;
            leftContainer.appendChild(pageInfo);
            
            mainContainer.appendChild(leftContainer);
            
            // Buat bagian kanan (pagination)
            const rightContainer = document.createElement('div');
            
            // Nav pagination
            const nav = document.createElement('nav');
            nav.setAttribute('aria-label', 'Page navigation');
            
            const ul = document.createElement('ul');
            ul.className = 'pagination pagination-sm mb-0';
            
            // Tombol Previous
            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            
            const prevLink = document.createElement('a');
            prevLink.className = 'page-link';
            prevLink.href = '#';
            prevLink.setAttribute('aria-label', 'Previous');
            prevLink.innerHTML = '<span aria-hidden="true">&laquo;</span>';
            prevLink.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage > 1) showPage(currentPage - 1);
            });
            
            prevLi.appendChild(prevLink);
            ul.appendChild(prevLi);
            
            // Nomor halaman
            const maxLinks = 5;
            const half = Math.floor(maxLinks / 2);
            let startPage = Math.max(1, currentPage - half);
            let endPage = Math.min(totalPages, startPage + maxLinks - 1);
            
            if (endPage - startPage + 1 < maxLinks) {
                startPage = Math.max(1, endPage - maxLinks + 1);
            }
            
            for (let i = startPage; i <= endPage; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                
                const link = document.createElement('a');
                link.className = 'page-link';
                link.href = '#';
                link.textContent = i;
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    showPage(i);
                });
                
                li.appendChild(link);
                ul.appendChild(li);
            }
            
            // Tombol Next
            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
            
            const nextLink = document.createElement('a');
            nextLink.className = 'page-link';
            nextLink.href = '#';
            nextLink.setAttribute('aria-label', 'Next');
            nextLink.innerHTML = '<span aria-hidden="true">&raquo;</span>';
            nextLink.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage < totalPages) showPage(currentPage + 1);
            });
            
            nextLi.appendChild(nextLink);
            ul.appendChild(nextLi);
            
            nav.appendChild(ul);
            rightContainer.appendChild(nav);
            
            mainContainer.appendChild(rightContainer);
            
            container.appendChild(mainContainer);
        }
        
        // Fungsi untuk memperbarui kontrol pagination
        function updatePaginationControls(container, totalPages, currentPage, itemsPerPage) {
            const pageInfo = container.querySelector('.text-muted');
            if (pageInfo) {
                pageInfo.textContent = `Halaman ${currentPage} dari ${totalPages} (${rows.length} data)`;
            }
            
            const prevButton = container.querySelector('.page-item:first-child');
            if (prevButton) {
                if (currentPage === 1) {
                    prevButton.classList.add('disabled');
                } else {
                    prevButton.classList.remove('disabled');
                }
            }
            
            const nextButton = container.querySelector('.page-item:last-child');
            if (nextButton) {
                if (currentPage === totalPages) {
                    nextButton.classList.add('disabled');
                } else {
                    nextButton.classList.remove('disabled');
                }
            }
            
            // Update active page
            const pageItems = container.querySelectorAll('.pagination .page-item:not(:first-child):not(:last-child)');
            pageItems.forEach(item => {
                const pageNum = parseInt(item.querySelector('.page-link').textContent);
                if (pageNum === currentPage) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        }
    }
});