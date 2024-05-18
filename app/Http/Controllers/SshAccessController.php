<?php

namespace App\Http\Controllers;

use App\Models\WebApp;
use App\Models\SshAccess;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SshAccessStoreRequest;
use App\Http\Requests\SshAccessUpdateRequest;

class SshAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', SshAccess::class);

        $search = $request->get('search', '');

        $sshAccesses = SshAccess::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.ssh_accesses.index', compact('sshAccesses', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', SshAccess::class);

        $webApps = WebApp::pluck('name', 'id');

        return view('app.ssh_accesses.create', compact('webApps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SshAccessStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', SshAccess::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $sshAccess = SshAccess::create($validated);

        return redirect()
            ->route('ssh-accesses.edit', $sshAccess)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SshAccess $sshAccess): View
    {
        $this->authorize('view', $sshAccess);

        return view('app.ssh_accesses.show', compact('sshAccess'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, SshAccess $sshAccess): View
    {
        $this->authorize('update', $sshAccess);

        $webApps = WebApp::pluck('name', 'id');

        return view('app.ssh_accesses.edit', compact('sshAccess', 'webApps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SshAccessUpdateRequest $request,
        SshAccess $sshAccess
    ): RedirectResponse {
        $this->authorize('update', $sshAccess);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $sshAccess->update($validated);

        return redirect()
            ->route('ssh-accesses.edit', $sshAccess)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        SshAccess $sshAccess
    ): RedirectResponse {
        $this->authorize('delete', $sshAccess);

        $sshAccess->delete();

        return redirect()
            ->route('ssh-accesses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
