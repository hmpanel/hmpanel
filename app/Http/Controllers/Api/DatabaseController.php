<?php

namespace App\Http\Controllers\Api;

use App\Models\Database;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DatabaseResource;
use App\Http\Resources\DatabaseCollection;
use App\Http\Requests\DatabaseStoreRequest;
use App\Http\Requests\DatabaseUpdateRequest;

class DatabaseController extends Controller
{
    public function index(Request $request): DatabaseCollection
    {
        $this->authorize('view-any', Database::class);

        $search = $request->get('search', '');

        $databases = Database::search($search)
            ->latest()
            ->paginate();

        return new DatabaseCollection($databases);
    }

    public function store(DatabaseStoreRequest $request): DatabaseResource
    {
        $this->authorize('create', Database::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $database = Database::create($validated);

        return new DatabaseResource($database);
    }

    public function show(Request $request, Database $database): DatabaseResource
    {
        $this->authorize('view', $database);

        return new DatabaseResource($database);
    }

    public function update(
        DatabaseUpdateRequest $request,
        Database $database
    ): DatabaseResource {
        $this->authorize('update', $database);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $database->update($validated);

        return new DatabaseResource($database);
    }

    public function destroy(Request $request, Database $database): Response
    {
        $this->authorize('delete', $database);

        $database->delete();

        return response()->noContent();
    }
}
