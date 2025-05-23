<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\DocumentCollaborationController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\CodeReviewController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectCommentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/projects', function () {
    return view('projects');
})->name('projects');

Route::get('/forums', function () {
    return view('forums');
})->name('forums');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/search', [DashboardController::class, 'search'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.search');

Route::get('/network', function () {
    return view('network');
})->name('network');

Route::get('/network/join', function () {
    return view('network.join');
})->name('network.join');

Route::post('/network/join', function () {
    // Validate the request
    $validated = request()->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'company' => 'nullable|string|max:255',
        'position' => 'nullable|string|max:255',
        'industry' => 'nullable|string|max:255',
        'interests' => 'nullable|array',
    ]);

    // TODO: Store the data in the database
    // For now, we'll just redirect back with a success message
    return redirect()->route('network.join')
        ->with('success', 'Thank you for joining our network! We will contact you soon.');
})->name('network.join.store');

Route::middleware('auth')->group(function () {
    // Location Routes
    Route::get('/nearby-users', [LocationController::class, 'nearbyUsers'])->name('location.nearby');
    Route::post('/update-location', [LocationController::class, 'updateLocation'])->name('location.update');
    Route::get('/location-search', [LocationController::class, 'searchByLocation'])->name('location.search');
    Route::get('/countries', [LocationController::class, 'getCountries'])->name('location.countries');
    Route::get('/states/{country}', [LocationController::class, 'getStates'])->name('location.states');
    Route::get('/cities/{state}', [LocationController::class, 'getCities'])->name('location.cities');

    // Collaborations Routes
    Route::get('/collaborations', [ProjectController::class, 'collaborations'])->name('collaborations.index');

    // Skill Routes
    Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');
    Route::get('/skills/search', [SkillController::class, 'search'])->name('skills.search');
    Route::get('/skills/{skill}/users', [SkillController::class, 'matchUsers'])->name('skills.users');
    Route::get('/skills/{skill}/projects', [SkillController::class, 'matchProjects'])->name('skills.projects');

    // Project Routes
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::patch('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::post('/projects/{project}/collaborate', [ProjectController::class, 'collaborate'])->name('projects.collaborate');
    Route::post('/projects/{project}/manage-collaboration', [ProjectController::class, 'manageCollaboration'])->name('projects.manage-collaboration');
    Route::delete('/projects/{project}/collaborators/{collaborator}', [ProjectController::class, 'removeCollaborator'])->name('projects.remove-collaborator');
    Route::post('/projects/{project}/messages', [ProjectController::class, 'storeMessage'])->name('projects.messages.store');
    Route::get('/projects/{project}/messages', [ProjectController::class, 'getMessages'])->name('projects.messages.index');

    // Forum Routes
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::get('/forum/{post}', [ForumController::class, 'show'])->name('forum.show');
    Route::get('/forum/{post}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::put('/forum/{post}', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{post}', [ForumController::class, 'destroy'])->name('forum.destroy');
    Route::get('/forum/category/{category}', [ForumController::class, 'category'])->name('forum.category');
    Route::post('/forum/{post}/comments', [ForumController::class, 'storeComment'])->name('forum.comments.store');
    Route::delete('/forum/{post}/comments/{comment}', [ForumController::class, 'destroyComment'])->name('forum.comments.destroy');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture.update');
    Route::delete('/profile/picture', [ProfileController::class, 'destroyPicture'])->name('profile.picture.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::prefix('notifications')->name('notifications.')->middleware('auth')->group(function () {
        Route::get('/', [NotificationsController::class, 'index'])->name('index');
        Route::post('/{id}/read', [NotificationsController::class, 'markAsRead'])->name('read');
        Route::post('/mark-all-read', [NotificationsController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{id}', [NotificationsController::class, 'destroy'])->name('destroy');
        Route::delete('/clear-all', [NotificationsController::class, 'clearAll'])->name('clear-all');
    });

    // Test notification route (temporary)
    Route::get('/test-notification', function() {
        auth()->user()->notify(new \App\Notifications\ProjectUpdateNotification(
            (object)['id' => 1, 'title' => 'Test Project'],
            'update',
            'This is a test notification'
        ));
        return redirect()->back()->with('success', 'Test notification sent!');
    });

    Route::get('/test-project-notification', function () {
        // Create a test project
        $project = \App\Models\Project::create([
            'title' => 'Test Project',
            'description' => 'This is a test project to verify notifications',
            'user_id' => auth()->id(),
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addMonths(1),
            'skills_required' => ['PHP', 'Laravel']
        ]);

        // Get a random user (not the current user) to be a collaborator
        $collaborator = \App\Models\User::where('id', '!=', auth()->id())
            ->inRandomOrder()
            ->first();

        if ($collaborator) {
            $project->collaborators()->attach($collaborator->id);
            $project->notifyCollaborators('Welcome to the test project! This is a notification test.');
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Test project created with notifications.');
    });

    // Messages Routes
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessagesController::class, 'create'])->name('messages.create');
    Route::get('/messages/search', [MessagesController::class, 'search'])->name('messages.search');
    Route::get('/messages/{user}', [MessagesController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessagesController::class, 'store'])->name('messages.store');
    Route::post('/messages/{message}/read', [MessagesController::class, 'markAsRead'])->name('messages.read');

    // Document collaboration routes
    Route::resource('projects.documents', DocumentCollaborationController::class);
    Route::post('projects/{project}/documents/{document}/remove-editor', [DocumentCollaborationController::class, 'removeEditor'])
        ->name('projects.documents.remove-editor');

    // Chat room routes
    Route::resource('projects.chat-rooms', ChatRoomController::class);
    Route::post('projects/{project}/chat-rooms/{chatRoom}/messages', [ChatRoomController::class, 'storeMessage'])
        ->name('projects.chat-rooms.messages.store');

    // Code review routes
    Route::resource('projects.code-reviews', CodeReviewController::class);
    Route::post('projects/{project}/code-reviews/{codeReview}/comments', [CodeReviewController::class, 'storeComment'])
        ->name('projects.code-reviews.comments.store');
    Route::post('projects/{project}/code-reviews/{codeReview}/react', [CodeReviewController::class, 'react'])
        ->name('projects.code-reviews.react');

    // Project Comments
    Route::post('/projects/{project}/comments', [ProjectCommentController::class, 'store'])
        ->name('projects.comments.store')
        ->middleware('auth');

    Route::delete('/projects/{project}/comments/{comment}', [ProjectCommentController::class, 'destroy'])
        ->name('projects.comments.destroy')
        ->middleware('auth');
});

// About Us and Network Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/network', [PageController::class, 'network'])->name('network');

require __DIR__.'/auth.php';
