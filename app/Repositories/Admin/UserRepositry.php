<?php
namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Models\Consultant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserRepositry
{
    public function getAllUsers()
    {
        return Admin::where('type', null)->get();
    }

    public function store(Request $request)
    {
        // Create admin
        $admin = Admin::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role
        $role = Role::find($request->role_id);
        $admin->assignRole($role);

        // If role is consultant (ID 1), store consultant data
        if ($role->id == 1) {
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('consultants/avatars', 'public');
            }

            Consultant::create([
                "fullname"=>$admin->full_name,
                'account_id' => $admin->id,
                'specialty_id' => $request->specialty_id,
                'phone_number' => $request->phone_number,
                'identity_number' => $request->identity_number,
                'experience_years' => $request->experience_years,
                'certificates' => $request->certificates,
                'avatar' => $avatarPath,
                'email'=>$admin->email
            ]);
        }
    }

    public function update(Request $request , $id)
    {
        // Create admin

        $admin = Admin::find($id);


        $admin->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
        ]);


        if(!empty($request->password)){
            $admin->password = Hash::make($request->password);
            $admin->save();
        }
        // Assign role
        $role = Role::find($request->role_id);
        $admin->assignRole($role);

        // If role is consultant (ID 1), store consultant data
        if ($role->id == 1) {

            if($admin->consultant){
            $avatarPath = $admin->consultant->avatar;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('consultants/avatars', 'public');
            }

            $admin->consultant()->update([
                "fullname"=>$admin->full_name,
                'account_id' => $admin->id,
                'specialty_id' => $request->specialty_id,
                'phone_number' => $request->phone_number,
                'identity_number' => $request->identity_number,
                'experience_years' => $request->experience_years,
                'certificates' => $request->certificates,
                'avatar' => $avatarPath,
                'email'=>$admin->email
            ]);
        }
        else{
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('consultants/avatars', 'public');
            }

            Consultant::create([
                "fullname"=>$admin->full_name,
                'account_id' => $admin->id,
                'specialty_id' => $request->specialty_id,
                'phone_number' => $request->phone_number,
                'identity_number' => $request->identity_number,
                'experience_years' => $request->experience_years,
                'certificates' => $request->certificates,
                'avatar' => $avatarPath,
                'email'=>$admin->email
            ]);

        }
        }

        return $admin;
    }
}
