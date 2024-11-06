<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Services\MenuService;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function __construct(private MenuService $menuService)
    {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->menuService->select()
        ]);
    }

    public function getMenu(): JsonResponse
    {
        return response()->json([
            'data' => $this->menuService->select(true)
        ]);
    }
}
