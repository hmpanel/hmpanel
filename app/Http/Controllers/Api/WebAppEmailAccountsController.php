<?php

namespace App\Http\Controllers\Api;

use App\Models\WebApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EmailAccountResource;
use App\Http\Resources\EmailAccountCollection;

class WebAppEmailAccountsController extends Controller
{
    public function index(
        Request $request,
        WebApp $webApp
    ): EmailAccountCollection {
        $this->authorize('view', $webApp);

        $search = $request->get('search', '');

        $emailAccounts = $webApp
            ->emailAccounts()
            ->search($search)
            ->latest()
            ->paginate();

        return new EmailAccountCollection($emailAccounts);
    }

    public function store(
        Request $request,
        WebApp $webApp
    ): EmailAccountResource {
        $this->authorize('create', EmailAccount::class);

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $emailAccount = $webApp->emailAccounts()->create($validated);

        return new EmailAccountResource($emailAccount);
    }
}
