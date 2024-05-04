<?php

namespace App\Services\AccountManagement;

use App\Models\Penduduk;
use App\Models\Role;
use App\Models\User;
use App\Services\Interfaces\CRUDServiceInterface;
use App\Services\Interfaces\DatatablesInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService implements CRUDServiceInterface, DatatablesInterface
{

    public static function find(string $id): Model
    {
        return User::findOrFail($id);
    }

    public static function all(): Collection
    {
        return User::all();
    }

    public static function create(Request $request): Collection | Model
    {
        try {
            $request->merge([
                'password' => Hash::make($request->password),
                'phone' => $request->phone ?? null,
            ]);
            return User::create($request->only([
                'role_id',
                'username',
                'email',
                'password',
                'phone'
            ]));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function update(string $id, Request $request): Collection | Model
    {
        $user =  User::findOrFail($id);
        $request->merge([
            'phone' => $request->phone ?? null,
        ]);
        $user->fill($request->only([
            'role_id',
            'username',
            'email',
            'phone'
        ]));
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return $user;
    }

    public static function delete(string $id): bool
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function changeRole(string $id, string $role_name): bool
    {
        try {
            $user = User::findOrFail($id);
            $role = self::getRoleId($role_name);
            $user->role_id = $role;
            $user->save();
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function getDatatable($id = null): Collection
    {
        return Penduduk::with('user')->whereNotNull('user_id')->get();
    }

    public static function getRoleId($id): string
    {
        return Role::where('role_name', $id)->firstOrFail()->role_id;
    }
}
