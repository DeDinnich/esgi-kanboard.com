<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\ProjectInvitationController;
use App\Http\Controllers\ListController;

Route::view('/', 'pages.landing.index')->name('home');
Route::view('/about', 'pages.landing.about')->name('about');
Route::get('/prices', [LandingController::class, 'prices'])->name('prices');

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::post('/stripe/pay', [PaymentController::class, 'pay'])->name('stripe.pay');
Route::post('/stripe/confirm', [PaymentController::class, 'confirm'])->name('stripe.confirm');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/email/verify-purchase/{user}', [AuthController::class, 'verify'])->name('verify-purchase-email');

Route::get('/password/ask-email', [AuthController::class, 'showAskEmail'])->name('password.ask');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/projects/invite/accept/{token}', [ProjectInvitationController::class, 'accept'])->name('projects.invite.accept');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/projects/create', [DashController::class, 'storeProject'])->name('projects.store');
    Route::get('/project/{project}/kanban', [KanbanController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/list', [ListController::class, 'show'])->name('projects.showList');

    Route::put('/columns/{column}/rename', [KanbanController::class, 'renameColumn'])->name('columns.rename');
    Route::put('/columns/{column}/move', [KanbanController::class, 'moveColumn'])->name('columns.move');
    Route::delete('/columns/{column}', [KanbanController::class, 'deleteColumn'])->name('columns.delete');
    Route::post('/columns/{column}/tasks', [KanbanController::class, 'createTask'])->name('tasks.store');
    Route::post('/columns/create', [KanbanController::class, 'storeColumn'])->name('columns.store');
    Route::delete('/tasks/{task}', [KanbanController::class, 'destroyTask'])->name('tasks.destroy');
    Route::put('/tasks/{task}', [KanbanController::class, 'updateTask'])->name('tasks.update');
    Route::post('/projects/{project}/invite', [ProjectInvitationController::class, 'invite'])->name('projects.invite');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Users
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{user}/password', [AdminController::class, 'updateUserPassword'])->name('admin.users.password');
    Route::get('/admin/users/search', [AdminController::class, 'searchUsers'])->name('admin.users.search');
    Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/admin/users/{id}/restore', [AdminController::class, 'restoreUser'])->name('admin.users.restore');
    Route::delete('/admin/users/{id}/force', [AdminController::class, 'forceDeleteUser'])->name('admin.users.forceDelete');

    // Subscriptions
    Route::get('/admin/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');
    Route::get('/admin/subscriptions/create', [AdminController::class, 'createSubscription'])->name('admin.subscriptions.create');
    Route::post('/admin/subscriptions', [AdminController::class, 'storeSubscription'])->name('admin.subscriptions.store');
    Route::get('/admin/subscriptions/{subscription}/edit', [AdminController::class, 'editSubscription'])->name('admin.subscriptions.edit');
    Route::put('/admin/subscriptions/{subscription}', [AdminController::class, 'updateSubscription'])->name('admin.subscriptions.update');
    Route::delete('/admin/subscriptions/{subscription}', [AdminController::class, 'deleteSubscription'])->name('admin.subscriptions.delete');
    Route::delete('/admin/subscriptions/{id}/force', [AdminController::class, 'forceDeleteSubscription'])->name('admin.subscriptions.forceDelete');

    // Projects
    Route::get('/admin/projects', [AdminController::class, 'projects'])->name('admin.projects');
    Route::get('/admin/projects/create', [AdminController::class, 'createProject'])->name('admin.projects.create');
    Route::post('/admin/projects', [AdminController::class, 'storeProject'])->name('admin.projects.store');
    Route::get('/admin/projects/{project}/edit', [AdminController::class, 'editProject'])->name('admin.projects.edit');
    Route::put('/admin/projects/{project}', [AdminController::class, 'updateProject'])->name('admin.projects.update');
    Route::delete('/admin/projects/{project}', [AdminController::class, 'deleteProject'])->name('admin.projects.delete');
    Route::post('/admin/projects/{id}/restore', [AdminController::class, 'restoreProject'])->name('admin.projects.restore');
    Route::delete('/admin/projects/{id}/force', [AdminController::class, 'forceDeleteProject'])->name('admin.projects.forceDelete');

    // Columns
    Route::get('/admin/columns', [AdminController::class, 'columns'])->name('admin.columns');
    Route::get('/admin/columns/create', [AdminController::class, 'createColumn'])->name('admin.columns.create');
    Route::post('/admin/columns', [AdminController::class, 'storeColumn'])->name('admin.columns.store');
    Route::get('/admin/columns/{column}/edit', [AdminController::class, 'editColumn'])->name('admin.columns.edit');
    Route::put('/admin/columns/{column}', [AdminController::class, 'updateColumn'])->name('admin.columns.update');
    Route::delete('/admin/columns/{column}', [AdminController::class, 'deleteColumn'])->name('admin.columns.delete');
    Route::post('/admin/columns/{id}/restore', [AdminController::class, 'restoreColumn'])->name('admin.columns.restore');
    Route::delete('/admin/columns/{id}/force', [AdminController::class, 'forceDeleteColumn'])->name('admin.columns.forceDelete');

    // Tasks
    Route::get('/admin/tasks', [AdminController::class, 'tasks'])->name('admin.tasks');
    Route::get('/admin/tasks/create', [AdminController::class, 'createTask'])->name('admin.tasks.create');
    Route::post('/admin/tasks', [AdminController::class, 'storeTask'])->name('admin.tasks.store');
    Route::get('/admin/tasks/{task}/edit', [AdminController::class, 'editTask'])->name('admin.tasks.edit');
    Route::put('/admin/tasks/{task}', [AdminController::class, 'updateTask'])->name('admin.tasks.update');
    Route::delete('/admin/tasks/{task}', [AdminController::class, 'deleteTask'])->name('admin.tasks.delete');
    Route::post('/admin/tasks/{id}/restore', [AdminController::class, 'restoreTask'])->name('admin.tasks.restore');
    Route::delete('/admin/tasks/{id}/force', [AdminController::class, 'forceDeleteTask'])->name('admin.tasks.forceDelete');

    // Project Collaborators
    Route::get('/admin/project-collaborators', [AdminController::class, 'projectCollaborators'])->name('admin.project_collaborators');
    Route::delete('/admin/project-collaborators/{projectCollaborateur}', [AdminController::class, 'destroyProjectCollaborator'])->name('admin.project_collaborators.delete');

    // Task Collaborators
    Route::get('/admin/task-collaborators', [AdminController::class, 'taskCollaborators'])->name('admin.task_collaborators');
    Route::delete('/admin/task-collaborators/{taskCollaborateur}', [AdminController::class, 'destroyTaskCollaborator'])->name('admin.task_collaborators.delete');
});
