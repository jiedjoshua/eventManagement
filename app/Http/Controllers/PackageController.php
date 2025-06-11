<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    public function getPackages(Request $request)
{
    try {
        $eventType = $request->query('type');
        
        $packages = Package::where('type', $eventType)
            ->where('is_active', true)
            ->with(['features' => function($query) {
                $query->orderBy('sort_order');
            }])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    } catch (\Exception $e) {
        Log::error('Package loading error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch packages',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function getPackage($id)
    {
        try {
            $package = Package::with('features')
                ->where('id', $id)
                ->where('is_active', true)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $package
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}