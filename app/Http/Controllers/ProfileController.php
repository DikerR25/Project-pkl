<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/photos', $image->hashName());

            DB::table('users')->where('users.id', $id)->update([
                'image' => 'photos' . $image->hashName(), // Simpan path relatif ke gambar
            ]);

            return back()->with('message', 'Your profile image has been updated');
        }
        // $user->update($data);
        return back()->with('failed', 'Failed to update profile');
    }
}
