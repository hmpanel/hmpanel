<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DomainStoreRequest;
use App\Http\Requests\DomainUpdateRequest;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Domain::class);

        $search = $request->get('search', '');

        $domains = Domain::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.domains.index', compact('domains', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Domain::class);

        return view('app.domains.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DomainStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Domain::class);

        $validated = $request->validated();

        $domain = Domain::create($validated);

        return redirect()
            ->route('domains.edit', $domain)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Domain $domain): View
    {
        $this->authorize('view', $domain);

        return view('app.domains.show', compact('domain'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Domain $domain): View
    {
        $this->authorize('update', $domain);

        return view('app.domains.edit', compact('domain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DomainUpdateRequest $request,
        Domain $domain
    ): RedirectResponse {
        $this->authorize('update', $domain);

        $validated = $request->validated();

        $domain->update($validated);

        return redirect()
            ->route('domains.edit', $domain)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Domain $domain): RedirectResponse
    {
        $this->authorize('delete', $domain);

        $domain->delete();

        return redirect()
            ->route('domains.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
