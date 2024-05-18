<?php

namespace App\Http\Controllers\Api;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\DomainResource;
use App\Http\Resources\DomainCollection;
use App\Http\Requests\DomainStoreRequest;
use App\Http\Requests\DomainUpdateRequest;

class DomainController extends Controller
{
    public function index(Request $request): DomainCollection
    {
        $this->authorize('view-any', Domain::class);

        $search = $request->get('search', '');

        $domains = Domain::search($search)
            ->latest()
            ->paginate();

        return new DomainCollection($domains);
    }

    public function store(DomainStoreRequest $request): DomainResource
    {
        $this->authorize('create', Domain::class);

        $validated = $request->validated();

        $domain = Domain::create($validated);

        return new DomainResource($domain);
    }

    public function show(Request $request, Domain $domain): DomainResource
    {
        $this->authorize('view', $domain);

        return new DomainResource($domain);
    }

    public function update(
        DomainUpdateRequest $request,
        Domain $domain
    ): DomainResource {
        $this->authorize('update', $domain);

        $validated = $request->validated();

        $domain->update($validated);

        return new DomainResource($domain);
    }

    public function destroy(Request $request, Domain $domain): Response
    {
        $this->authorize('delete', $domain);

        $domain->delete();

        return response()->noContent();
    }
}
