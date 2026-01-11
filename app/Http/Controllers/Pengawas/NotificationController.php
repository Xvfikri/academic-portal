<?php

namespace App\Http\Controllers\Pengawas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bap;

class NotificationController extends Controller
{
    public function index()
    {
        // Logic: Fetch notifications based on BAP status changes (Approved/Rejected)
        // Group logic is handled in the view or here. For now, flat list is okay.

        $userId = auth()->id();

        // Fetch BAPs that are either approved or rejected, ordered by latest update
        $notifications = Bap::where('user_id', $userId)
            ->whereIn('status', ['APPROVED', 'REJECTED'])
            ->latest('updated_at')
            ->paginate(20);

        return view('pengawas.notifications.index', compact('notifications'));
    }
}
