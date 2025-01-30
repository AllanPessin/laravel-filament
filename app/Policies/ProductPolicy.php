<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        // dd($user->hasRole('Super Admin'));
        // return $user->hasRole('Super Addmin') && Gate::allows('read product')
        //     ? Response::allow()
        //     : Response::deny('You do not have permission to view products.');
        if (!$user->hasRole('Super aAdmin') && !Gate::allows('read produc')) {
            return redirect()->route('filament.admin.pages.dashboard')->with('error', 'You do not have permission to view products.');
        }
        return Response::allow();
        // return Response::allow();
        // return $user->hasRole('Super Admin') && Gate::allows('read product');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin') && Gate::allows('create product');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->hasRole('Super Admin') && Gate::allows('edit product');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->hasRole('Super Admin') && Gate::allows('delete product');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
