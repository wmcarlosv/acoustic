<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ChallengeController;
use App\Http\Controllers\Admin\SongSectionController;
use App\Http\Controllers\Admin\SongController;
use App\Http\Controllers\Admin\ReportReasonController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\AppUserController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\NotificationTemplateController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ProblemController;
use App\Http\Controllers\Admin\AdminLanguageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdvertisementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/login', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/home', function () {
    return redirect('admin/login');
})->name('login');

Route::get('/', function () {
    return redirect('admin/login');
})->name('login');


Route::post('admin/privacy_save', [SettingsController::class, 'privacy_save'])->middleware('auth');

Route::middleware(['XssSanitizer'])->group(function () {
    Route::any('installer', [LoginController::class, 'installer']);
    Route::get('/admin/login', [LoginController::class, 'admin_login'])->name('login');
    Route::post('/admin/login/check', [LoginController::class, 'admin_login_check']);
    Route::post('/saveEnvData', [LoginController::class, 'saveEnvData']);
    Route::post('/saveAdminData', [LoginController::class, 'saveAdminData']);
    Route::prefix('admin')->middleware(['auth'])->group(function()
    {
        Route::get('/clear-cache', function() {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            return redirect()->back()->withStatus(__('Cache Cleared Successfully.'));
        });
    
        Route::get('/logout', [LoginController::class, 'logout']);
        Route::get('/dashboard', [DashboardController::class, 'admin_dashboard']);
        Route::get('/comment/reports', [CommentController::class, 'reports_index']);
        Route::get('/user/reports', [AppUserController::class, 'reports_index']);
        Route::get('/video/reports', [VideoController::class, 'reports_index']);
        Route::get('/video/unapproved', [VideoController::class, 'unapproved_index']);
        Route::post('/changeOrderLanguage', [LanguageController::class, 'changeOrderLanguage']);
        Route::post('/changeOrderSongSection', [SongSectionController::class, 'changeOrderSongSection']);
    
        // Chart
        Route::get('/platform', [DashboardController::class, 'platform']);
        Route::get('/guest_user', [DashboardController::class, 'guest_user']);
        Route::get('/user_registerd_chart', [DashboardController::class, 'user_registerd_chart']);
        Route::post('/user_statistics', [DashboardController::class, 'user_statistics']);
        Route::post('/video_statistics', [DashboardController::class, 'video_statistics']);
        // Profile
        Route::post('/profile/changepassword/{id}', [ProfileController::class, 'changepassword']);
    
        Route::resources([
                'role' => RoleController::class,
                'banner' => BannerController::class,
                'challenge' => ChallengeController::class,
                'song_section' => SongSectionController::class,
                'songs' => SongController::class,
                'report-reason' => ReportReasonController::class,
                'comment' => CommentController::class,
                'user' => AppUserController::class,
                'language' => LanguageController::class,
                'video' => VideoController::class,
                'notification' => NotificationTemplateController::class,
                'problem_report' => ProblemController::class,
                'settings/language' => AdminLanguageController::class,
                'profile' => ProfileController::class,
                'admin-user' => AdminUserController::class,
                'advertisements' => AdvertisementController::class,
        ]);
    
        Route::post('/video/approve/{id}', [VideoController::class, 'approve_video']);
        Route::post('/user/status/{id}', [AppUserController::class, 'change_status']);
    
        // settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/general_setting', [SettingsController::class, 'general_setting']);
        Route::post('/settings/video_setting', [SettingsController::class, 'video_setting']);
        Route::post('/settings/push_notification', [SettingsController::class, 'push_notification']);
        Route::post('/settings/email_settings', [SettingsController::class, 'email_settings']);
        Route::post('/settings/verification_settings', [SettingsController::class, 'verification_settings']);
        Route::post('/settings/app_info', [SettingsController::class, 'app_info']);
        Route::post('/settings/license', [SettingsController::class, 'license']);
    
        Route::get('/settings/advertisement', [SettingsController::class, 'advertisement'])->name('advertisement');
        Route::post('/settings/admob-update', [SettingsController::class, 'admobUpdate']);
    
        Route::get('/privacy', [SettingsController::class, 'privacy'])->name('privacy');
    
        // Report
        Route::get('/report', [ReportController::class, 'index'])->name('report');
        Route::get('/report/most-viewed-video', [ReportController::class, 'most_viewed_video']);
        Route::post('/report/most-viewed-video', [ReportController::class, 'most_viewed_video']);
        
        Route::get('/report/most-liked-video', [ReportController::class, 'most_liked_video']);
        Route::post('/report/most-liked-video', [ReportController::class, 'most_liked_video']);
    
        Route::get('/report/most-used-song', [ReportController::class, 'most_used_song']);
        Route::post('/report/most-used-song', [ReportController::class, 'most_used_song']);
    
        Route::get('/report/most-used-audio', [ReportController::class, 'most_used_audio']);
        Route::post('/report/most-used-audio', [ReportController::class, 'most_used_audio']);
    
        Route::get('/report/most-used-tag', [ReportController::class, 'most_used_tag']);
        Route::post('/report/most-used-tag', [ReportController::class, 'most_used_tag']);
    
        Route::get('/report/most-used-challenge', [ReportController::class, 'most_used_challenge']);
        Route::post('/report/most-used-challenge', [ReportController::class, 'most_used_challenge']);
    
    });
});
