<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Request $request)
    {
        return view('profiles.edit')->with([
            'user' => $request->user()
        ]);
    }

    public function update(ProfileRequest $request)
    {
        return DB::transaction(function () use ($request) {


            $user = $request->user();

            $user->fill($request->validated());

            //* verificar si el correo cambio
            if ($user->isDirty('email')) {
                // isDirty => verifica si el campo cambio, retorna true o false

                $user->email_verified_at = null;

                $user->sendEmailVerificationNotification();
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            if ($request->hasFile('image')) {
                // comprobar si el usuario tiene imagen y eliminarla
                if ($user->image != null) {
                    // nombre del filesystem y la ruta de la imagen
                    Storage::disk('images')->delete($user->image->path);
                    // eliminar relacion de la imagen en la db
                    $user->image->delete();
                }

                $user->image()->create([
                    'path' => $request->file('image')->store('users', 'images')
                ]);
            }

            return redirect()->route('profile.edit')->withSuccess('Your profile has been updated');
        }, 5);
    }
}
