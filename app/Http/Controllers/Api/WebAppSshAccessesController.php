<?php

namespace App\Http\Controllers\Api;

use App\Models\WebApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\SshAccessResource;
use App\Http\Resources\SshAccessCollection;

class WebAppSshAccessesController extends Controller
{
    public function index(Request $request, WebApp $webApp): SshAccessCollection
    {
        $this->authorize('view', $webApp);

        $search = $request->get('search', '');

        $sshAccesses = $webApp
            ->sshAccesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new SshAccessCollection($sshAccesses);
    }

    public function store(Request $request, WebApp $webApp): SshAccessResource
    {
        $this->authorize('create', SshAccess::class);

        $validated = $request->validate([
            'username' => ['required', 'max:255', 'string'],
            'password' => ['required'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $sshAccess = $webApp->sshAccesses()->create($validated);

        return new SshAccessResource($sshAccess);
    }
}
