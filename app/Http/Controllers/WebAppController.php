<?php

namespace App\Http\Controllers;

use App\Models\WebApp;
use App\Models\Domain;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\WebAppStoreRequest;
use App\Http\Requests\WebAppUpdateRequest;

class WebAppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', WebApp::class);

        $search = $request->get('search', '');

        $webApps = WebApp::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.web_apps.index', compact('webApps', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', WebApp::class);

        $domains = Domain::pluck('name', 'id');

        return view('app.web_apps.create', compact('domains'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebAppStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', WebApp::class);

        $validated = $request->validated();

        $webApp = WebApp::create($validated);

        return redirect()
            ->route('web-apps.edit', $webApp)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, WebApp $webApp): View
    {
        $this->authorize('view', $webApp);

        return view('app.web_apps.show', compact('webApp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, WebApp $webApp): View
    {
        $this->authorize('update', $webApp);

        $domains = Domain::pluck('name', 'id');

        return view('app.web_apps.edit', compact('webApp', 'domains'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        WebAppUpdateRequest $request,
        WebApp $webApp
    ): RedirectResponse {
        $this->authorize('update', $webApp);

        $validated = $request->validated();

        $webApp->update($validated);

        return redirect()
            ->route('web-apps.edit', $webApp)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, WebApp $webApp): RedirectResponse
    {
        $this->authorize('delete', $webApp);

        $webApp->delete();

        return redirect()
            ->route('web-apps.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
