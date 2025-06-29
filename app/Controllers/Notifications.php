<?php

namespace App\Controllers;

class Notifications extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    /**
     * Mark notification as read
     */
    public function markRead()
    {
        // Accept both FormData and JSON
        $index = $this->request->getPost('index');
        if ($index === null) {
            $input = $this->request->getJSON(true);
            $index = $input['index'] ?? null;
        }

        if ($index === null || !is_numeric($index)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Index tidak valid'
            ]);
        }

        $notifications = session()->get('notifications') ?? [];
        
        if (!isset($notifications[$index])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan'
            ]);
        }

        // Mark as read
        $notifications[$index]['read'] = true;
        session()->set('notifications', $notifications);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai sudah dibaca',
            'unread_count' => $this->getUnreadCount($notifications)
        ]);
    }

    /**
     * Delete notification
     */
    public function delete()
    {
        // Accept both FormData and JSON
        $index = $this->request->getPost('index');
        if ($index === null) {
            $input = $this->request->getJSON(true);
            $index = $input['index'] ?? null;
        }

        if ($index === null || !is_numeric($index)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Index tidak valid'
            ]);
        }

        $notifications = session()->get('notifications') ?? [];
        
        if (!isset($notifications[$index])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan'
            ]);
        }

        // Remove notification
        unset($notifications[$index]);
        $notifications = array_values($notifications); // Reindex array
        session()->set('notifications', $notifications);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus',
            'unread_count' => $this->getUnreadCount($notifications)
        ]);
    }

    /**
     * Get all notifications
     */
    public function index()
    {
        $notifications = session()->get('notifications') ?? [];

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'notifications' => $notifications,
                'count' => $this->getUnreadCount($notifications)
            ]);
        }

        // Return view for full notifications page
        return view('notifications/index', [
            'notifications' => $notifications,
            'unread_count' => $this->getUnreadCount($notifications)
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllRead()
    {
        $notifications = session()->get('notifications') ?? [];
        
        foreach ($notifications as &$notification) {
            $notification['read'] = true;
        }
        
        session()->set('notifications', $notifications);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai sudah dibaca'
        ]);
    }

    /**
     * Clear all notifications
     */
    public function clearAll()
    {
        session()->remove('notifications');

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Semua notifikasi berhasil dihapus'
        ]);
    }

    /**
     * Get unread notifications count
     */
    private function getUnreadCount($notifications)
    {
        return count(array_filter($notifications, function($notif) {
            return !($notif['read'] ?? false);
        }));
    }

    /**
     * Add notification (helper method)
     */
    public static function add($title, $message, $type = 'info', $data = null)
    {
        $notifications = session()->get('notifications') ?? [];
        
        $notification = [
            'id' => uniqid(),
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
            'read' => false,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        array_unshift($notifications, $notification); // Add to beginning
        
        // Limit to 50 notifications
        if (count($notifications) > 50) {
            $notifications = array_slice($notifications, 0, 50);
        }
        
        session()->set('notifications', $notifications);
        
        return $notification;
    }
}
