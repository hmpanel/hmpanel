<?php

namespace App\Http\Controllers;

use App\Models\Database;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DatabaseStoreRequest;
use App\Http\Requests\DatabaseUpdateRequest;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Database::class);

        $search = $request->get('search', '');

        $databases = Database::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.databases.index', compact('databases', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Database::class);

        return view('app.databases.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DatabaseStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Database::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $database = Database::create($validated);

        return redirect()
            ->route('databases.edit', $database)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Database $database): View
    {
        $this->authorize('view', $database);

        return view('app.databases.show', compact('database'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Database $database): View
    {
        $this->authorize('update', $database);

        return view('app.databases.edit', compact('database'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DatabaseUpdateRequest $request,
        Database $database
    ): RedirectResponse {
        $this->authorize('update', $database);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $database->update($validated);

        return redirect()
            ->route('databases.edit', $database)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Database $database
    ): RedirectResponse {
        $this->authorize('delete', $database);

        $database->delete();

        return redirect()
            ->route('databases.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
