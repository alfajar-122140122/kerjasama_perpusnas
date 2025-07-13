<?php

// This is a debug file to check navigation classes
echo "Current URI: " . uri_string() . "<br>";
echo "is_nav_active('aktivitas', false): " . (is_nav_active('aktivitas', false) ? "true" : "false") . "<br>";
echo "get_nav_class('aktivitas', 'nav-link', 'active', false): " . get_nav_class('aktivitas', 'nav-link', 'active', false) . "<br>";
