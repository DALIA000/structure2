<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Role;

class UniqueRoleName implements Rule
{
    public function passes($attribute, $value)
    {
        $Name = isset($value) ? $value: null;
        $count = Role::where(function ($query) use ($Name) {
            if ($Name !== null) {
                $d = $query->where('title->en', $Name);
            }
        })->count();

        return $count === 0;
    }

    public function message()
    {
        return 'Role with this name already exists.';
    }
}
