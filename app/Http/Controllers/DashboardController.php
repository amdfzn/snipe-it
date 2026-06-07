<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\RedirectResponse;
use \Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;


/**
 * This controller handles all actions related to the Admin Dashboard
 * for the Snipe-IT Asset Management application.
 *
 * @author A. Gianotto <snipe@snipe.net>
 * @version v1.0
 */
class DashboardController extends Controller
{
    /**
     * Check authorization and display admin dashboard, otherwise display
     * the user's checked-out assets.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     */
    public function index() : View | RedirectResponse
    {
        // Show the page
        if (auth()->user()->hasAccess('admin')) {
            $asset_stats = null;
            $counts['asset'] = \App\Models\Asset::count();
            $counts['accessory'] = \App\Models\Accessory::count();
            $counts['license'] = \App\Models\License::assetcount();
            $counts['consumable'] = \App\Models\Consumable::count();
            $counts['component'] = \App\Models\Component::count();
            $counts['user'] = \App\Models\Company::scopeCompanyables(auth()->user())->count();
            $counts['grand_total'] = $counts['asset'] + $counts['accessory'] + $counts['license'] + $counts['consumable'];

            // Tambahan untuk dashboard modern
            $counts['deployed'] = \App\Models\Asset::Deployed()->count();
            $counts['undeployable'] = \App\Models\Asset::Undeployable()->count();
            $counts['archived'] = \App\Models\Asset::Archived()->count();
            $counts['rtd'] = \App\Models\Asset::RTD()->count();

            // Aset jatuh tempo (dipinjam dengan expected_checkin)
            $due_assets = \App\Models\Asset::where('assigned_to', '!=', null)
                ->whereNotNull('expected_checkin')
                ->where('expected_checkin', '<=', now()->addDays(7))
                ->with('assignedTo')
                ->orderBy('expected_checkin', 'asc')
                ->take(5)
                ->get();

            // Aktivitas terbaru
            $recent_activity = \App\Models\Actionlog::with(['user', 'item'])
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();

            // Aset per kategori
            $assets_by_category = \App\Models\Category::withCount('assets')
                ->having('assets_count', '>', 0)
                ->orderBy('assets_count', 'desc')
                ->get();

            if ((! file_exists(storage_path().'/oauth-private.key')) || (! file_exists(storage_path().'/oauth-public.key'))) {
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('passport:install', ['--no-interaction' => true]);
            }

            return view('dashboard')
                ->with('asset_stats', $asset_stats)
                ->with('counts', $counts)
                ->with('due_assets', $due_assets)
                ->with('recent_activity', $recent_activity)
                ->with('assets_by_category', $assets_by_category);
        } else {
            Session::reflash();

            // Redirect to the profile page
            return redirect()->intended('account/view-assets');
        }
    }
}
