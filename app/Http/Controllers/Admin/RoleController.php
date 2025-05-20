<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles',
            'permissions' => 'nullable|array'
        ]);

        $role = Role::create($data);

        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol creado',
            'text' => "El rol se ha creado correctamente."
        ]);

        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array'
        ]);

        $role->update($data);

        if (isset($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        } else {
            $role->permissions()->detach();
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol actualizado',
            'text' => "El rol se ha actualizado correctamente."
        ]);

        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        session()->flash('swal', [

            'icon' => 'success',
            'title' => 'Rol eliminado',
            'text' => 'El rol se ha eliminado correctamente'
        ]);

        return redirect()->route('admin.roles.index');
    }
}
