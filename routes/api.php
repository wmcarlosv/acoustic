<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['XssSanitizer'])->group(function () {
    Route::post('/login', [UserApiController::class, 'login']);
    Route::post('/register', [UserApiController::class, 'register']);
    
    Route::post('/sendOtp', [UserApiController::class, 'sendOtp']); // Done
    Route::post('/checkOtp', [UserApiController::class, 'checkOtp']); // Done
    Route::post('/changePassword', [UserApiController::class, 'changePassword']); // Done
    
    Route::get('/guest_user', [UserApiController::class, 'guest_user']);
    
    Route::get('/settings', [UserApiController::class, 'settings']); 
    Route::get('/advertisement', [UserApiController::class, 'advertisement']); 
    
    // Banner
    Route::get('/banners', [UserApiController::class, 'banners']); // Done
    Route::get('/language', [UserApiController::class, 'language']);
    
    // Videos 
    Route::get('/trending_video', [UserApiController::class, 'trending_video']); // Done
    Route::post('/nearby_video', [UserApiController::class, 'nearby_video']); // Done
    Route::get('/single_video/{id}', [UserApiController::class, 'single_video']); // Done
    Route::get('/video_view/{id}', [UserApiController::class, 'video_view']); // Done
    Route::get('/single_video_comments/{id}', [UserApiController::class, 'single_video_comments']); //Done

    // Report reasons
    Route::get('/report_reasons/{type}', [UserApiController::class, 'report_reasons']); // Done
    Route::post('/report_problem', [UserApiController::class, 'report_problem']); // Done

    Route::get('/search/{query}', [UserApiController::class, 'search']); // Done
    Route::get('/search_default', [UserApiController::class, 'search_default']); // Done
    
    Route::get('/hashtag_videos/{hashtag}', [UserApiController::class, 'hashtag_videos']); // Done
    
    // User
    Route::get('/single_user/{id}', [UserApiController::class, 'single_user']); // Done
    Route::get('/follow_and_invite', [UserApiController::class, 'follow_and_invite']); // Done
    
    // song
    Route::get('/single_song/{id}', [UserApiController::class, 'single_song']);  // Done
    Route::get('/single_audio/{id}', [UserApiController::class, 'single_audio']); // Done
    
    Route::middleware('auth:appUserApi')->group(function()
    {
        // Following videos
        Route::get('/following_videos', [UserApiController::class, 'following_videos']); // Done
    
        // Comments
        Route::post('/create_comment', [UserApiController::class, 'create_comment']); // Done
        Route::get('/delete_comment/{id}', [UserApiController::class, 'delete_comment']); // Done
        Route::post('/report_comment', [UserApiController::class, 'report_comment']); // Done
        Route::get('/like_comment/{id}', [UserApiController::class, 'like_comment']); // Done
    
        // Video
        Route::post('/upload_video', [UserApiController::class, 'upload_video']);
        Route::post('/report_video', [UserApiController::class, 'report_video']); // Done
        Route::get('/like_video/{id}', [UserApiController::class, 'like_video']); // Done
        Route::get('/save_video/{id}', [UserApiController::class, 'save_video']); // Done
        Route::post('/edit_video', [UserApiController::class, 'edit_video']); // Done
        Route::get('/delete_video/{id}', [UserApiController::class, 'delete_video']); // Done
    
        Route::post('/search_followers', [UserApiController::class, 'search_followers']); // Done
        Route::get('/own_followers', [UserApiController::class, 'own_followers']); // Done
        Route::get('/follow_requests', [UserApiController::class, 'follow_requests']); // Done
    
        Route::get('/follow/{id}', [UserApiController::class, 'follow']); // Done
        Route::get('/unfollow/{id}', [UserApiController::class, 'unfollow']); // Done
        Route::get('/remove_follow/{id}', [UserApiController::class, 'remove_follow']); // Done
        Route::get('/accept/{id}', [UserApiController::class, 'accept']); // Done
        Route::get('/reject/{id}', [UserApiController::class, 'reject']); // Done
        Route::post('/block', [UserApiController::class, 'block']); // Done
        Route::post('/unblock', [UserApiController::class, 'unblock']); // Done
        Route::get('/users_block_list', [UserApiController::class, 'users_block_list']); // Done
        Route::get('/comments_block_list', [UserApiController::class, 'comments_block_list']); // Done
    
        // Songs
        Route::get('/select_song', [UserApiController::class, 'select_song']); // Done
        Route::get('/single_playlist/{id}', [UserApiController::class, 'single_playlist']); // Done
        Route::get('/search_song/{query}', [UserApiController::class, 'search_song']); // Done
        Route::get('/add_favorite/{id}', [UserApiController::class, 'add_favorite']); // Done
    
        Route::get('/user_suggestion/{query}', [UserApiController::class, 'user_suggestion']); // Done
        Route::get('/hashtag_suggestion/{query}', [UserApiController::class, 'hashtag_suggestion']); //Done
    
        Route::get('/not_interested/{id}', [UserApiController::class, 'not_interested']); // Done
    
        Route::post('/report_user', [UserApiController::class, 'report_user']); // Done
        Route::get('/notification', [UserApiController::class, 'notification']); // Done
    
        Route::get('/my_profile', [UserApiController::class, 'my_profile']); // Done
        Route::get('/my_profile_info', [UserApiController::class, 'my_profile_info']); // Done
        Route::post('/edit_profile', [UserApiController::class, 'edit_profile']); // Done
        
        Route::post('/notification_settings', [UserApiController::class, 'notification_settings']); // Done
        Route::post('/privacy_settings', [UserApiController::class, 'privacy_settings']); // Done
    });
});