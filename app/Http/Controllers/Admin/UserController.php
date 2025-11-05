<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        if ($request->ajax()) {
            $users = User::with('roles')->get(); // eager load roles

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('roles', function ($user) {
                    return $user->roles->pluck('name')->implode(', ');
                })->addColumn('roles', function ($user) {
    $roles = $user->roles->pluck('name')->implode(', ');
    return $roles ?: 'N/A';
})
                ->addColumn('email', function ($user) {
                    return $user->email;
                })
                ->addColumn('mobile', function ($user) {
                    return $user->phone ?? 'N/A';
                })
                ->editColumn('status', function ($user) {
                    if($user->status == 0){
                        $status = "Inactive";
                    }else{

                        $status = "Active";
                    }
                    return $status;
                })
                ->addColumn('created_at', function ($user) {
                    return $user->created_at;
                })
                ->addColumn('actions', function ($user) {
                    $editUrl = route('users.edit', $user->id);
                    $deleteUrl = route('users.destroy', $user->id);
                
                    $actions = '<div class="d-flex align-items-center">';
                
                        $actions .= '<a class="btn btn-icon me-1 edit-user" href="' . $editUrl . '">
                                        <i class="icon-base ti tabler-edit icon-22px"></i>
                                    </a>';
                
                    if (auth()->user()->can('users delete')) {
                        $actions .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this user?\');">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-danger">
                                            <i class="icon-base ti tabler-trash icon-22px"></i>
                                        </button>
                                    </form>';
                    }
                
                    $actions .= '</div>';
                
                    return $actions;
                })
                ->rawColumns(['roles', 'actions'])
                ->make(true);
        }

        return view('admin.users.index', compact('roles'));
    }


    public function create()
    {
        $roles = Role::all();
    $profiles = Profile::whereNull('user_id')
                        ->get(['id', 'staff_no', 'officer_name'])
                        ->toArray();
        return view('admin.users.create', compact('roles', 'profiles'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name'   => 'required|string|max:255',
        'email'  => 'required|email|unique:users,email',
        'mobile' => 'nullable|string|max:15',
        'roles'  => 'required|array',
        'roles.*'=> 'exists:roles,id',
    ]);

    // Create user
    $user = User::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'phone'    => $validated['mobile'],
        'password' => Hash::make('password123'),
        'status'   => 1,
    ]);
    $profile =  Profile::find($request->profile_id);
    $profile->update(['user_id' => $user->id]);

    // ✅ Fetch role names from IDs
    $roleNames = Role::whereIn('id', $validated['roles'])->pluck('name')->toArray();

    // Assign multiple roles
    $user->assignRole($roleNames);

    return redirect()->back()->with('success', 'User created and roles assigned.');
}

    public function edit(User $User)
    {
        $roles = Role::all();
        $user = $User;
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'mobile' => ['nullable', 'string', 'max:15'],
                'password' => ['nullable', 'confirmed', 'min:6'],
                'image' => ['nullable', 'image', 'max:2048'],
                'status' => ['required', 'boolean'],
                'roles' => ['required', 'array'],
                'roles.*' => ['exists:roles,name'],
            ]);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->mobile;
            $user->status = $request->status;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                    Storage::disk('public')->delete($user->profile);
                }
                // Upload new image
                $user->profile = $request->file('image')->store('profile-photos', 'public');
            }

            $user->save();

            // 🔹 Sync roles
            $user->syncRoles($request->roles);

            return redirect()->back()->with('success', 'User updated successfully.');
        } catch (\Throwable $e) {
            // Log error for debugging
            dd($e->getMessage());
            \Log::error('User update failed: '.$e->getMessage(), [
                'user_id' => $user->id,
                'stack'   => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong while updating the user. Please try again.');
        }
    }


}
