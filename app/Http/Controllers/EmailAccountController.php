<?php

namespace App\Http\Controllers;

use App\Models\WebApp;
use Illuminate\View\View;
use App\Models\EmailAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EmailAccountStoreRequest;
use App\Http\Requests\EmailAccountUpdateRequest;

class EmailAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', EmailAccount::class);

        $search = $request->get('search', '');

        $emailAccounts = EmailAccount::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.email_accounts.index',
            compact('emailAccounts', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', EmailAccount::class);

        $webApps = WebApp::pluck('name', 'id');

        return view('app.email_accounts.create', compact('webApps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmailAccountStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', EmailAccount::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $emailAccount = EmailAccount::create($validated);

        return redirect()
            ->route('email-accounts.edit', $emailAccount)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, EmailAccount $emailAccount): View
    {
        $this->authorize('view', $emailAccount);

        return view('app.email_accounts.show', compact('emailAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, EmailAccount $emailAccount): View
    {
        $this->authorize('update', $emailAccount);

        $webApps = WebApp::pluck('name', 'id');

        return view(
            'app.email_accounts.edit',
            compact('emailAccount', 'webApps')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        EmailAccountUpdateRequest $request,
        EmailAccount $emailAccount
    ): RedirectResponse {
        $this->authorize('update', $emailAccount);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $emailAccount->update($validated);

        return redirect()
            ->route('email-accounts.edit', $emailAccount)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        EmailAccount $emailAccount
    ): RedirectResponse {
        $this->authorize('delete', $emailAccount);

        $emailAccount->delete();

        return redirect()
            ->route('email-accounts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
