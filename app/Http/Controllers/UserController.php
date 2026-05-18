<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function index(Request $request): Response
    {
        $this->authorize('viewAny', User::class);

        return Inertia::render('User/Index', [
            'users' => $this->userRepository->paginate(),
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', User::class);

        return Inertia::render('User/Create', [
            'roles' => array_column(UserRole::cases(), 'value'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', Rule::enum(UserRole::class)],
        ]);

        $this->userRepository->create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user): Response
    {
        $this->authorize('update', $user);

        return Inertia::render('User/Edit', [
            'user' => $user,
            'roles' => array_column(UserRole::cases(), 'value'),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'role' => ['required', Rule::enum(UserRole::class)],
            'password' => ['nullable', Rules\Password::defaults()],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $this->userRepository->update($user->id, $validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        $this->userRepository->delete($user->id);

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
