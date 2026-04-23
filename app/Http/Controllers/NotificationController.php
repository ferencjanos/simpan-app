<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('notifications');
    }

    public function read($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Update status disposisi jika ada
        if (isset($notification->data['disposisi_id'])) {
            $disposisi = \App\Models\Disposisi::find($notification->data['disposisi_id']);
            if ($disposisi && $disposisi->status == 'belum dibaca') {
                $disposisi->update(['status' => 'sudah dibaca']);
            }
        }

        return redirect()->route('notifications.index')->with('success', 'Notifikasi ditandai sudah dibaca!');
    }

    public function readAll()
    {
        $notifications = Auth::user()->unreadNotifications;

        foreach ($notifications as $notification) {
            if (isset($notification->data['disposisi_id'])) {
                $disposisi = \App\Models\Disposisi::find($notification->data['disposisi_id']);
                if ($disposisi && $disposisi->status == 'belum dibaca') {
                    $disposisi->update(['status' => 'sudah dibaca']);
                }
            }
        }

        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('notifications.index')->with('success', 'Semua notifikasi ditandai sudah dibaca!');
    }
}