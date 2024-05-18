<?php

namespace App\Http\Controllers;

use App\Models\WebApp;
use Illuminate\View\View;
use App\Models\FtpAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\FtpAccountStoreRequest;
use App\Http\Requests\FtpAccountUpdateRequest;

class FtpAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', FtpAccount::class);

        $search = $request->get('search', '');

        $ftpAccounts = FtpAccount::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.ftp_accounts.index', compact('ftpAccounts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', FtpAccount::class);

        $webApps = WebApp::pluck('name', 'id');

        return view('app.ftp_accounts.create', compact('webApps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FtpAccountStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', FtpAccount::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $ftpAccount = FtpAccount::create($validated);

        return redirect()
            ->route('ftp-accounts.edit', $ftpAccount)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, FtpAccount $ftpAccount): View
    {
        $this->authorize('view', $ftpAccount);

        return view('app.ftp_accounts.show', compact('ftpAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, FtpAccount $ftpAccount): View
    {
        $this->authorize('update', $ftpAccount);

        $webApps = WebApp::pluck('name', 'id');

        return view('app.ftp_accounts.edit', compact('ftpAccount', 'webApps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        FtpAccountUpdateRequest $request,
        FtpAccount $ftpAccount
    ): RedirectResponse {
        $this->authorize('update', $ftpAccount);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $ftpAccount->update($validated);

        return redirect()
            ->route('ftp-accounts.edit', $ftpAccount)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        FtpAccount $ftpAccount
    ): RedirectResponse {
        $this->authorize('delete', $ftpAccount);

        $ftpAccount->delete();

        return redirect()
            ->route('ftp-accounts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
