<?php

if (!function_exists('is_nav_active')) {
    /**
     * Determine if a navigation link should be active
     * 
     * @param string $route The route to check
     * @param bool $exact Whether to use exact matching
     * @return bool
     */
    function is_nav_active($route, $exact = true) {
        $currentUri = uri_string();
        
        // Remove leading slash from route for consistent comparison
        $route = ltrim($route, '/');
        
        // Special case for "aktivitas" which should be active even if we're on the exact route
        if ($route === 'aktivitas' && ($currentUri === 'aktivitas' || strpos($currentUri, 'aktivitas/') === 0)) {
            return true;
        }
        
        // Debug to check current URI
        log_message('debug', 'Checking nav active: Current URI = ' . $currentUri . ', Route = ' . $route . ', Exact = ' . ($exact ? 'true' : 'false'));
        
        if ($exact) {
            return $currentUri === $route;
        }
        
        // For non-exact matching, check if current URI starts with route
        // but exclude conflicting routes
        if ($currentUri === $route) {
            return true;
        }
        
        // Check for sub-routes but prevent conflicts
        if (strpos($currentUri, $route . '/') === 0) {
            // Special handling for conflicting routes
            switch ($route) {
                case 'kerja-sama':
                    // Don't activate "kerja-sama" if we're on "peta-kerja-sama"
                    return strpos($currentUri, 'peta-kerja-sama') === false;
                
                case 'kontak':
                    // Activate "kontak" for kontak sub-pages
                    return true;
                
                default:
                    return true;
            }
        }
        
        return false;
    }
}

if (!function_exists('is_kerja_sama_section_active')) {
    /**
     * Check if any Kerja Sama section is active
     * 
     * @return bool
     */
    function is_kerja_sama_section_active() {
        $currentUri = uri_string();
        $kerjaSamaSections = [
            'kerja-sama',
            'kerja-sama/data',
            'kerja-sama/implementasi', 
            'kerja-sama/akan-berakhir',
            'kerja-sama/progress',
            'kerja-sama/pengajuan'
        ];
        
        foreach ($kerjaSamaSections as $section) {
            if ($currentUri === $section || strpos($currentUri, $section . '/') === 0) {
                // Exclude peta-kerja-sama
                if (strpos($currentUri, 'peta-kerja-sama') === false) {
                    return true;
                }
            }
        }
        
        return false;
    }
}

if (!function_exists('get_kerja_sama_submenu')) {
    /**
     * Get Kerja Sama submenu items
     * 
     * @return array
     */
    function get_kerja_sama_submenu() {
        return [
            [
                'title' => 'Data Kerja Sama',
                'url' => base_url('kerja-sama/data'),
                'icon' => 'fas fa-database',
                'description' => 'Data lengkap kerja sama perpustakaan'
            ],
            [
                'title' => 'Implementasi Kerja Sama',
                'url' => base_url('kerja-sama/implementasi'),
                'icon' => 'fas fa-handshake',
                'description' => 'Status implementasi kerja sama aktif'
            ],
            [
                'title' => 'Kerja Sama yang Akan Berakhir',
                'url' => base_url('kerja-sama/akan-berakhir'),
                'icon' => 'fas fa-clock',
                'description' => 'Daftar kerja sama yang akan berakhir'
            ],
            [
                'title' => 'Progress',
                'url' => base_url('kerja-sama/progress'),
                'icon' => 'fas fa-chart-line',
                'description' => 'Progress dan statistik kerja sama'
            ],
            [
                'title' => 'Pengajuan',
                'url' => base_url('kerja-sama/pengajuan'),
                'icon' => 'fas fa-file-alt',
                'description' => 'Form pengajuan kerja sama baru'
            ]
        ];
    }
}

if (!function_exists('get_current_kerja_sama_section')) {
    /**
     * Get current active Kerja Sama section
     * 
     * @return string|null
     */
    function get_current_kerja_sama_section() {
        $currentUri = uri_string();
        
        if (strpos($currentUri, 'kerja-sama/') === 0) {
            $parts = explode('/', $currentUri);
            if (isset($parts[1])) {
                return $parts[1];
            }
        }
        
        return null;
    }
}

if (!function_exists('get_nav_class')) {
    /**
     * Get the CSS class for navigation links
     * 
     * @param string $route The route to check
     * @param string $baseClass Base CSS class
     * @param string $activeClass Active CSS class
     * @param bool $exact Whether to use exact matching
     * @return string
     */
    function get_nav_class($route, $baseClass = 'nav-link', $activeClass = 'active', $exact = true) {
        $classes = [$baseClass];
        
        if (is_nav_active($route, $exact)) {
            $classes[] = $activeClass;
        }
        
        return implode(' ', $classes);
    }
}

if (!function_exists('get_kerja_sama_nav_class')) {
    /**
     * Get CSS class for Kerja Sama navigation with dropdown support
     * 
     * @param string $baseClass
     * @param string $activeClass
     * @return string
     */
    function get_kerja_sama_nav_class($baseClass = 'nav-link dropdown-toggle', $activeClass = 'active') {
        $classes = [$baseClass];
        
        if (is_kerja_sama_section_active()) {
            $classes[] = $activeClass;
        }
        
        return implode(' ', $classes);
    }
}

if (!function_exists('get_breadcrumb_segments')) {
    /**
     * Get breadcrumb segments from current URI
     * 
     * @return array
     */
    function get_breadcrumb_segments() {
        $uri = uri_string();
        
        if (empty($uri)) {
            return [['title' => 'Beranda', 'url' => base_url('/')]];
        }
        
        $segments = explode('/', $uri);
        $breadcrumbs = [['title' => 'Beranda', 'url' => base_url('/')]];
        $currentPath = '';
        
        foreach ($segments as $index => $segment) {
            $currentPath .= ($currentPath ? '/' : '') . $segment;
            
            // Convert segment to readable title
            $title = ucwords(str_replace(['-', '_'], ' ', $segment));
            
            // Special cases for better titles
            switch ($segment) {
                case 'kerja-sama':
                    $title = 'Kerja Sama';
                    break;
                case 'peta-kerja-sama':
                    $title = 'Peta Kerja Sama';
                    break;
                case 'tentang':
                    $title = 'Tentang';
                    break;
                case 'aktivitas':
                    $title = 'Aktivitas';
                    break;
                case 'kontak':
                    $title = 'Kontak';
                    break;
                case 'data':
                    if ($segments[$index - 1] === 'kerja-sama') {
                        $title = 'Data Kerja Sama';
                    }
                    break;
                case 'implementasi':
                    if ($segments[$index - 1] === 'kerja-sama') {
                        $title = 'Implementasi Kerja Sama';
                    }
                    break;
                case 'akan-berakhir':
                    if ($segments[$index - 1] === 'kerja-sama') {
                        $title = 'Kerja Sama yang Akan Berakhir';
                    }
                    break;
                case 'progress':
                    if ($segments[$index - 1] === 'kerja-sama') {
                        $title = 'Progress';
                    }
                    break;
                case 'pengajuan':
                    if ($segments[$index - 1] === 'kerja-sama') {
                        $title = 'Pengajuan';
                    }
                    break;
            }
            
            $breadcrumbs[] = [
                'title' => $title,
                'url' => base_url($currentPath)
            ];
        }
        
        return $breadcrumbs;
    }
}