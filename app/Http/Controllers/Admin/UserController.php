<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('status', 'pending')->get();
        $approvedUsers = User::where('status', 'approved')->get();

        return view('admin.users.index', compact('pendingUsers', 'approvedUsers'));
    }

    public function approve(User $user)
    {
        logger("Before: " . $user->status);
        $user->status = 'approved';
        $user->save();
        logger("After: " . $user->fresh()->status);
        
        return back()->with('success', 'User approved!');
    }

    public function promote(User $user)
    {
        $user->update(['role' => 'admin']);
        return back()->with('success', 'User promoted to admin');
    }

    public function demote(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot demote yourself.');
        }

        if ($user->role === 'admin') {
            $user->update(['role' => 'user']);
             return back()->with('success', 'User has been demoted to regular user.');
        }

        return back()->with('info', 'User is already a regular user.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User removed!');
    }
}
