<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User have been logged out successfully!',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    } //end method

    public function profile()
    {
        $id = Auth::id();
        $adminData = User::find($id);
        return view('admin.admin_profile_view', compact('adminData'));
    } //end method

    public function editProfile()
    {
        $id = Auth::id();
        $editData = User::find($id);
        return view('admin.admin_profile_edit', compact('editData'));
    } //end method

    public function storeProfile(Request $request): \Illuminate\Http\RedirectResponse
    {
        $id = Auth::id();
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            @unlink(public_path('upload/admin_images/' . $data->profile_image));
            $imageName = date('YmdHi').$image->getClientOriginalName();
            $image->move(public_path('upload/admin_images'), $imageName);
            $data['profile_image'] = $imageName;
        }
        $data->save();

        if ($data->save() === true){
            $notification = array(
                'message' => 'Admin Profile Updated Successfully',
                'alert-type' => 'success'
            );
        }else{
            $notification = array(
                'message' => 'Admin Profile Not Updated',
                'alert-type' => 'error'
            );
        }
        return redirect()->route('admin.profile')->with($notification);
    } //end method

    public function changePassword()
    {
        return view('admin.admin_change_password');
    }

    public function updatePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirmation_password' => 'required|same:new_password',
        ]);

        $hashPassword = Auth::user()->password;
        if (Hash::check($request->old_password, $hashPassword)) {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->new_password);
            $user->save();

            session()->flash('message', 'Password Changed Successfully');
            return redirect()->back();
        }

        session()->flash('message', 'Old Password is not match');
        return redirect()->back();
    } //end method
}
