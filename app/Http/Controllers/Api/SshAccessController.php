<?php

namespace App\Http\Controllers\Api;

use App\Models\SshAccess;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\SshAccessResource;
use App\Http\Resources\SshAccessCollection;
use App\Http\Requests\SshAccessStoreRequest;
use App\Http\Requests\SshAccessUpdateRequest;

class SshAccessController extends Controller
{
    public function index(Request $request): SshAccessCollection
    {
        $this->authorize('view-any', SshAccess::class);

        $search = $request->get('search', '');

        $sshAccesses = SshAccess::search($search)
            ->latest()
            ->paginate();

        return new SshAccessCollection($sshAccesses);
    }

    public function store(SshAccessStoreRequest $request): SshAccessResource
    {
        $this->authorize('create', SshAccess::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $sshAccess = SshAccess::create($validated);

        return new SshAccessResource($sshAccess);
    }

    public function show(
        Request $request,
        SshAccess $sshAccess
    ): SshAccessResource {
        $this->authorize('view', $sshAccess);

        return new SshAccessResource($sshAccess);
    }

    public function update(
        SshAccessUpdateRequest $request,
        SshAccess $sshAccess
    ): SshAccessResource {
        $this->authorize('update', $sshAccess);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $sshAccess->update($validated);

        return new SshAccessResource($sshAccess);
    }

    public function destroy(Request $request, SshAccess $sshAccess): Response
    {
        $this->authorize('delete', $sshAccess);

        $sshAccess->delete();

        return response()->noContent();
    }
}
