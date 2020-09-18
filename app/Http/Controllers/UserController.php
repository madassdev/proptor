<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Mail\TutorApprovedMail;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
        $this->middleware(['role:admin'])->except(['me', 'update']);
    }

    public function index()
    {
        return User::all();
    }

    public function me()
    {
        return auth()->user();
    }

    
    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        return $user;
    }

    
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->only('first_name', 'last_name', 'email', 'mobile', 'full_name'));

        if(auth()->user()->can('edit-user'))
        {
            $user->syncPermissions($request->permissions);
        }

        if($request->has('password'))
        {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        return response()->json(['message'=>"User successfully updated",'data'=>$user->load('permissions')]);

    }

    public function approveAgent(Agent $agent)
    {
        $agent->status = "approved";
        $agent->save();
        $agent->user->assignRole('agebt');
        
        Mail::to($agent->user)->queue(new TutorApprovedMail($agent->user));

        return response()->json(['message'=>'Agent approved successfully', 'data' => $agent]);
    }

    public function disproveAgent(Agent $agent)
    {
        $agent->status = "disproved";
        $agent->save();
        
        // Mail::to($tutor->user)->queue(new TutorApprovedMail($tutor->user));

        return response()->json(['message'=>'Agent disproved successfully', 'data' => $agent]);
    }

    public function getPermittedUsers()
    {
        $users = User::whereHas('permissions')->with('permissions')->paginate(10);
        return response()->json($users);
    }


    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message'=>"User successfully deleted"]);
    }
    
}
