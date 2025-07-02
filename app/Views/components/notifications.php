<?php
<!-- Notification Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
    <!-- Toasts will be dynamically added here -->
</div>

<!-- Notification Bell in Header -->
<div class="dropdown no-arrow mx-1" id="notificationDropdown">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter Badge -->
        <span class="badge badge-danger badge-counter" id="notificationCounter" style="display: none;">0</span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" style="min-width: 350px;">
        <h6 class="dropdown-header">
            <i class="fas fa-bell me-2"></i>
            Notification Center
        </h6>
        <div id="notificationList">
            <!-- Notifications will be loaded here -->
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-center small text-gray-500" href="#" onclick="markAllAsRead()">
            Mark All as Read
        </a>
        <a class="dropdown-item text-center small text-gray-500" href="<?= base_url('admin/notifications') ?>">
            Show All Notifications
        </a>
    </div>
</div>

<script>
// Notification System
class NotificationSystem {
    constructor() {
        this.notifications = [];
        this.unreadCount = 0;
        this.init();
    }
    
    init() {
        this.loadNotifications();
        this.startPolling();
        this.setupEventListeners();
    }
    
    loadNotifications() {
        // Simulate loading notifications from API
        const sampleNotifications = [
            {
                id: 1,
                title: 'Kerjasama Baru',
                message: 'Kerjasama dengan Universitas Indonesia telah dimulai',
                type: 'success',
                timestamp: new Date(Date.now() - 2 * 60 * 60 * 1000), // 2 hours ago
                read: false,
                icon: 'fas fa-handshake',
                url: '/admin/kerjasama'
            },
            {
                id: 2,
                title: 'Permohonan Baru',
                message: 'Permohonan kerjasama dari Institut Teknologi Bandung',
                type: 'warning',
                timestamp: new Date(Date.now() - 5 * 60 * 60 * 1000), // 5 hours ago
                read: false,
                icon: 'fas fa-file-alt',
                url: '/admin/permohonan'
            },
            {
                id: 3,
                title: 'Berita Dipublikasi',
                message: 'Artikel "Program Digitalisasi Koleksi" telah dipublikasi',
                type: 'info',
                timestamp: new Date(Date.now() - 24 * 60 * 60 * 1000), // 1 day ago
                read: true,
                icon: 'fas fa-newspaper',
                url: '/admin/berita'
            }
        ];
        
        this.notifications = sampleNotifications;
        this.updateUI();
    }
    
    updateUI() {
        this.updateCounter();
        this.updateDropdown();
    }
    
    updateCounter() {
        this.unreadCount = this.notifications.filter(n => !n.read).length;
        const counter = document.getElementById('notificationCounter');
        
        if (this.unreadCount > 0) {
            counter.textContent = this.unreadCount > 99 ? '99+' : this.unreadCount;
            counter.style.display = 'inline-block';
        } else {
            counter.style.display = 'none';
        }
    }
    
    updateDropdown() {
        const list = document.getElementById('notificationList');
        if (!list) return;
        
        if (this.notifications.length === 0) {
            list.innerHTML = `
                <div class="text-center p-4">
                    <i class="fas fa-bell-slash text-muted fa-2x mb-2"></i>
                    <p class="text-muted mb-0">Tidak ada notifikasi</p>
                </div>
            `;
            return;
        }
        
        list.innerHTML = '';
        
        // Show latest 5 notifications
        const recentNotifications = this.notifications
            .sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp))
            .slice(0, 5);
        
        recentNotifications.forEach(notification => {
            const item = this.createNotificationItem(notification);
            list.appendChild(item);
        });
    }
    
    createNotificationItem(notification) {
        const item = document.createElement('a');
        item.className = `dropdown-item d-flex align-items-center ${notification.read ? '' : 'bg-light border-left-primary'}`;
        item.href = '#';
        item.onclick = () => this.handleNotificationClick(notification);
        
        const timeAgo = this.getTimeAgo(notification.timestamp);
        const typeColor = this.getTypeColor(notification.type);
        
        item.innerHTML = `
            <div class="mr-3">
                <div class="icon-circle bg-${typeColor}">
                    <i class="${notification.icon} text-white"></i>
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="small text-gray-500">${timeAgo}</div>
                <div class="font-weight-bold">${notification.title}</div>
                <div class="small">${notification.message}</div>
            </div>
            ${!notification.read ? '<div class="ml-2"><span class="badge badge-primary badge-pill">New</span></div>' : ''}
        `;
        
        return item;
    }
    
    getTypeColor(type) {
        const colors = {
            'success': 'success',
            'warning': 'warning',
            'info': 'info',
            'error': 'danger',
            'default': 'primary'
        };
        return colors[type] || colors.default;
    }
    
    getTimeAgo(timestamp) {
        const now = new Date();
        const diff = now - new Date(timestamp);
        const minutes = Math.floor(diff / 60000);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);
        
        if (days > 0) return `${days} hari lalu`;
        if (hours > 0) return `${hours} jam lalu`;
        if (minutes > 0) return `${minutes} menit lalu`;
        return 'Baru saja';
    }
    
    handleNotificationClick(notification) {
        // Mark as read
        if (!notification.read) {
            this.markAsRead(notification.id);
        }
        
        // Navigate to URL if provided
        if (notification.url) {
            window.location.href = notification.url;
        }
    }
    
    markAsRead(notificationId) {
        const notification = this.notifications.find(n => n.id === notificationId);
        if (notification) {
            notification.read = true;
            this.updateUI();
            
            // In real implementation, send API call to mark as read
            // this.sendMarkAsReadRequest(notificationId);
        }
    }
    
    markAllAsRead() {
        this.notifications.forEach(n => n.read = true);
        this.updateUI();
        
        // In real implementation, send API call
        // this.sendMarkAllAsReadRequest();
    }
    
    addNotification(notification) {
        notification.id = Date.now(); // Simple ID generation
        notification.timestamp = new Date();
        notification.read = false;
        
        this.notifications.unshift(notification);
        this.updateUI();
        this.showToast(notification);
    }
    
    showToast(notification) {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;
        
        const toastId = `toast-${notification.id}`;
        const typeColor = this.getTypeColor(notification.type);
        
        const toastHtml = `
            <div class="toast" id="${toastId}" role="alert" data-bs-autohide="true" data-bs-delay="5000">
                <div class="toast-header">
                    <i class="${notification.icon} text-${typeColor} me-2"></i>
                    <strong class="me-auto">${notification.title}</strong>
                    <small class="text-muted">Baru saja</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    ${notification.message}
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
        
        // Remove toast element after it's hidden
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }
    
    startPolling() {
        // Poll for new notifications every 30 seconds
        setInterval(() => {
            this.checkNewNotifications();
        }, 30000);
    }
    
    checkNewNotifications() {
        // In real implementation, make API call to check for new notifications
        // For demo, randomly add a notification
        if (Math.random() < 0.1) { // 10% chance every 30 seconds
            const sampleNotifications = [
                {
                    title: 'Kerjasama Diperbarui',
                    message: 'Status kerjasama dengan UI telah diperbarui',
                    type: 'info',
                    icon: 'fas fa-sync-alt',
                    url: '/admin/kerjasama'
                },
                {
                    title: 'Implementasi Selesai',
                    message: 'Kegiatan workshop literasi telah selesai',
                    type: 'success',
                    icon: 'fas fa-check-circle',
                    url: '/admin/implementasi'
                }
            ];
            
            const randomNotification = sampleNotifications[Math.floor(Math.random() * sampleNotifications.length)];
            this.addNotification(randomNotification);
        }
    }
    
    setupEventListeners() {
        // Listen for custom notification events
        window.addEventListener('notification:add', (event) => {
            this.addNotification(event.detail);
        });
        
        window.addEventListener('notification:markRead', (event) => {
            this.markAsRead(event.detail.id);
        });
    }
}

// Global notification functions
function markAllAsRead() {
    if (window.notificationSystem) {
        window.notificationSystem.markAllAsRead();
    }
}

function addNotification(notification) {
    if (window.notificationSystem) {
        window.notificationSystem.addNotification(notification);
    }
}

// Initialize notification system when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.notificationSystem = new NotificationSystem();
});
</script>

<style>
.icon-circle {
    height: 2.5rem;
    width: 2.5rem;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dropdown-list {
    max-height: 400px;
    overflow-y: auto;
}

.dropdown-item {
    padding: 1rem;
    border-bottom: 1px solid #e3e6f0;
}

.dropdown-item:last-child {
    border-bottom: none;
}

.badge-counter {
    position: absolute;
    top: -5px;
    right: -5px;
    font-size: 0.7rem;
    padding: 0.25rem 0.4rem;
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.toast-container {
    z-index: 9999;
}

.toast {
    min-width: 300px;
}
</style>