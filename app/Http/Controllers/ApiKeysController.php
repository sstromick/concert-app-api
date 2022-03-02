<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Http\Requests\ApiKey\ApiKeyStoreRequest;
use App\Http\Requests\ApiKey\ApiKeyUpdateRequest;

class ApiKeysController extends Controller {
    public function index() {
        $apiKeys = ApiKey::getFilteredApiKeys();
        return $this->showAll($apiKeys);
    }

    public function store(ApiKeyStoreRequest $request) {
        $attributes = $request->validated();
        $api_key = ApiKey::create($attributes);
        return $this->showOne($api_key, 'Api Key created', 201);
    }

    public function show(ApiKey $key) {
        return $this->showOne($key);
    }

    public function update(ApiKeyUpdateRequest $request, ApiKey $key) {
        $attributes = $request->validated();
        $key->update($attributes);
        return $this->showOne($key, 'Api Key updated');
    }

    public function destroy(ApiKey $key) {
        $key->delete();
        return $this->showOne($key, 'Api Key deleted');
    }
}
