<?php

namespace App\Http\Controllers\Api;

use App\Models\WebApp;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\WebAppResource;
use App\Http\Resources\WebAppCollection;
use App\Http\Requests\WebAppStoreRequest;
use App\Http\Requests\WebAppUpdateRequest;

class WebAppController extends Controller
{
    public function index(Request $request): WebAppCollection
    {
        $this->authorize('view-any', WebApp::class);

        $search = $request->get('search', '');

        $webApps = WebApp::search($search)
            ->latest()
            ->paginate();

        return new WebAppCollection($webApps);
    }

    public function store(WebAppStoreRequest $request): WebAppResource
    {
        $this->authorize('create', WebApp::class);

        $validated = $request->validated();

        $webApp = WebApp::create($validated);

        return new WebAppResource($webApp);
    }

    public function show(Request $request, WebApp $webApp): WebAppResource
    {
        $this->authorize('view', $webApp);

        return new WebAppResource($webApp);
    }

    public function update(
        WebAppUpdateRequest $request,
        WebApp $webApp
    ): WebAppResource {
        $this->authorize('update', $webApp);

        $validated = $request->validated();

        $webApp->update($validated);

        return new WebAppResource($webApp);
    }

    public function destroy(Request $request, WebApp $webApp): Response
    {
        $this->authorize('delete', $webApp);

        $webApp->delete();

        return response()->noContent();
    }
}
