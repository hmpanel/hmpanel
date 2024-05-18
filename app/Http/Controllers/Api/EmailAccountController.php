<?php

namespace App\Http\Controllers\Api;

use App\Models\EmailAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EmailAccountResource;
use App\Http\Resources\EmailAccountCollection;
use App\Http\Requests\EmailAccountStoreRequest;
use App\Http\Requests\EmailAccountUpdateRequest;

class EmailAccountController extends Controller
{
    public function index(Request $request): EmailAccountCollection
    {
        $this->authorize('view-any', EmailAccount::class);

        $search = $request->get('search', '');

        $emailAccounts = EmailAccount::search($search)
            ->latest()
            ->paginate();

        return new EmailAccountCollection($emailAccounts);
    }

    public function store(
        EmailAccountStoreRequest $request
    ): EmailAccountResource {
        $this->authorize('create', EmailAccount::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $emailAccount = EmailAccount::create($validated);

        return new EmailAccountResource($emailAccount);
    }

    public function show(
        Request $request,
        EmailAccount $emailAccount
    ): EmailAccountResource {
        $this->authorize('view', $emailAccount);

        return new EmailAccountResource($emailAccount);
    }

    public function update(
        EmailAccountUpdateRequest $request,
        EmailAccount $emailAccount
    ): EmailAccountResource {
        $this->authorize('update', $emailAccount);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $emailAccount->update($validated);

        return new EmailAccountResource($emailAccount);
    }

    public function destroy(
        Request $request,
        EmailAccount $emailAccount
    ): Response {
        $this->authorize('delete', $emailAccount);

        $emailAccount->delete();

        return response()->noContent();
    }
}
