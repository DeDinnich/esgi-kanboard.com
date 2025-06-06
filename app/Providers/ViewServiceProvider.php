<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('partials.dashboard.aside', function ($view) {
            $user = Auth::user();

            if (! $user) {
                return;
            }

            $owned = $user->projectsOwned()->latest()->get();
            $collab = $user->projectCollaborations()->latest()->get();
            $projects = $owned->merge($collab)->unique('id')->sortByDesc('created_at')->values();

            $archivedOwned = $user->projectsOwned()->onlyTrashed()->latest()->get();
            $archivedCollab = $user->projectCollaborations()->onlyTrashed()->latest()->get();
            $archived = $archivedOwned->merge($archivedCollab)->unique('id')->sortByDesc('created_at')->values();

            $view->with('projects', $projects)
                 ->with('archivedProjects', $archived);
        });
    }
}
