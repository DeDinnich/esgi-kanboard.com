<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectInvitation;
use App\Mail\ProjectInvitationMail;
use Illuminate\Support\Facades\Mail;

class ProjectInvitationController extends Controller
{
        public function invite(Request $request, Project $project)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('error', 'Aucun utilisateur trouvé avec cet email.');
        }

        $token = Str::uuid();
        ProjectInvitation::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'token' => $token,
        ]);

        Mail::to($user)->send(new ProjectInvitationMail($project, $token));

        return back()->with('success', 'Utilisateur trouvé, un email d’invitation lui a été envoyé.');
    }

    public function accept(string $token)
    {
        $invitation = ProjectInvitation::where('token', $token)->firstOrFail();
        $invitation->project->collaborateurs()->syncWithoutDetaching([$invitation->user_id]);
        $invitation->delete();

        return redirect()->route('login')->with('success', 'Vous avez bel et bien rejoint le projet "' . $invitation->project->nom . '".');
    }
}
