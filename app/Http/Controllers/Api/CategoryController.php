<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Http\Resources\Categories\CategoryResource;
use App\Helper\ApiResponse;

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $categories = $this->service->index();
        return ApiResponse::success(CategoryResource::collection($categories));
    }
}
