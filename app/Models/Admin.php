<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, HasRoles;

    protected $fillable = ['name', 'email', 'token', 'username', 'password', 'pin_code'];

    protected function password(): Attribute
    {
        return Attribute::make(
            set:fn($value) => bcrypt($value),
        );
    }

    public function AdminPermissions(): Attribute
    {
        $permissions = Permission::all();
        $adminPermissions = $this->roles->first()->permissions;
        $permissionsArr = [];
    
        foreach ($permissions as $permission) {
            $permissionName = $permission['name'];
                $permissionExists = $adminPermissions?->contains(function ($adminPermission) use ($permissionName) {
                return $adminPermission['name'] === $permissionName;
            });
    
            if ($permissionExists) {
                $permissionsArr[explode('.', $permissionName)[0]][$permissionName] = true;
            } else {
                $permissionsArr[explode('.', $permissionName)[0]][$permissionName] = false;
            }
        }
        return Attribute::make(
            get: fn () => $permissionsArr,
        );
    }
}
