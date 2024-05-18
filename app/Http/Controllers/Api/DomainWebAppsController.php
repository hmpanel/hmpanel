<?php

namespace App\Http\Controllers\Api;

use App\Models\Domain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WebAppResource;
use App\Http\Resources\WebAppCollection;

class DomainWebAppsController extends Controller
{
    public function index(Request $request, Domain $domain): WebAppCollection
    {
        $this->authorize('view', $domain);

        $search = $request->get('search', '');

        $webApps = $domain
            ->webApps()
            ->search($search)
            ->latest()
            ->paginate();

        return new WebAppCollection($webApps);
    }

    public function store(Request $request, Domain $domain): WebAppResource
    {
        $this->authorize('create', WebApp::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'path' => ['required', 'max:255', 'string'],
        ]);

        $webApp = $domain->webApps()->create($validated);

        return new WebAppResource($webApp);
    }
}
