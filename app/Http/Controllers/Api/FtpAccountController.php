<?php

namespace App\Http\Controllers\Api;

use App\Models\FtpAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\FtpAccountResource;
use App\Http\Resources\FtpAccountCollection;
use App\Http\Requests\FtpAccountStoreRequest;
use App\Http\Requests\FtpAccountUpdateRequest;

class FtpAccountController extends Controller
{
    public function index(Request $request): FtpAccountCollection
    {
        $this->authorize('view-any', FtpAccount::class);

        $search = $request->get('search', '');

        $ftpAccounts = FtpAccount::search($search)
            ->latest()
            ->paginate();

        return new FtpAccountCollection($ftpAccounts);
    }

    public function store(FtpAccountStoreRequest $request): FtpAccountResource
    {
        $this->authorize('create', FtpAccount::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $ftpAccount = FtpAccount::create($validated);

        return new FtpAccountResource($ftpAccount);
    }

    public function show(
        Request $request,
        FtpAccount $ftpAccount
    ): FtpAccountResource {
        $this->authorize('view', $ftpAccount);

        return new FtpAccountResource($ftpAccount);
    }

    public function update(
        FtpAccountUpdateRequest $request,
        FtpAccount $ftpAccount
    ): FtpAccountResource {
        $this->authorize('update', $ftpAccount);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $ftpAccount->update($validated);

        return new FtpAccountResource($ftpAccount);
    }

    public function destroy(Request $request, FtpAccount $ftpAccount): Response
    {
        $this->authorize('delete', $ftpAccount);

        $ftpAccount->delete();

        return response()->noContent();
    }
}
