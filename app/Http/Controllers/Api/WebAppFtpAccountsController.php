<?php

namespace App\Http\Controllers\Api;

use App\Models\WebApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\FtpAccountResource;
use App\Http\Resources\FtpAccountCollection;

class WebAppFtpAccountsController extends Controller
{
    public function index(
        Request $request,
        WebApp $webApp
    ): FtpAccountCollection {
        $this->authorize('view', $webApp);

        $search = $request->get('search', '');

        $ftpAccounts = $webApp
            ->ftpAccounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new FtpAccountCollection($ftpAccounts);
    }

    public function store(Request $request, WebApp $webApp): FtpAccountResource
    {
        $this->authorize('create', FtpAccount::class);

        $validated = $request->validate([
            'username' => ['required', 'max:255', 'string'],
            'password' => ['required'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $ftpAccount = $webApp->ftpAccounts()->create($validated);

        return new FtpAccountResource($ftpAccount);
    }
}
