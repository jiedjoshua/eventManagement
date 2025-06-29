<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageFeature;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    // Admin Management Methods
    public function index(Request $request)
    {
        $query = Package::with('features');

        // Apply type filter from URL parameter
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $packages = $query->orderBy('type')->orderBy('name')->get();
        $addons = Addon::all(); // Fetch all add-ons

        // Set active page based on type parameter
        $activePage = 'packages'; // default
        if ($request->has('type') && $request->type != '') {
            $type = strtolower($request->type);
            switch ($type) {
                case 'wedding':
                    $activePage = 'wedding-packages';
                    break;
                case 'birthday':
                    $activePage = 'birthday-packages';
                    break;
                case 'baptism':
                    $activePage = 'baptism-packages';
                    break;
                default:
                    $activePage = 'packages';
                    break;
            }
        }

        return view('admin.packages.index', compact('packages', 'addons', 'activePage'));
    }

    public function create()
    {
        $types = ['Wedding', 'Birthday', 'Baptism'];
        return view('admin.packages.create', compact('types'));
    }

    public function store(Request $request)
    {
        \Log::debug('Package store request', $request->all());
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:Wedding,Birthday,Baptism',
                'title' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'is_active' => 'boolean',
                'features' => 'array',
                'features.*.title' => 'required|string|max:255',
                'features.*.description' => 'required|string',
                'features.*.sort_order' => 'required|integer|min:1'
            ]);

            // Always store type as lowercase
            $validated['type'] = strtolower($validated['type']);

            DB::transaction(function () use ($validated) {
                $package = Package::create([
                    'name' => $validated['name'],
                    'type' => $validated['type'],
                    'title' => $validated['title'],
                    'price' => $validated['price'],
                    'base_price' => $validated['price'],
                    'description' => $validated['description'],
                    'is_active' => isset($validated['is_active'])
                ]);

                if (isset($validated['features'])) {
                    foreach ($validated['features'] as $feature) {
                        PackageFeature::create([
                            'package_id' => $package->id,
                            'title' => $feature['title'],
                            'description' => $feature['description'],
                            'sort_order' => $feature['sort_order']
                        ]);
                    }
                }
            });

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Package created successfully!'
                ]);
            }

            return redirect()->route('admin.packages.index')->with('success', 'Package created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed in package store', ['errors' => $e->errors()]);
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Exception in package store', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create package: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Failed to create package: ' . $e->getMessage()]);
        }
    }
    public function edit(Package $package)
    {
        try {
            $package->load('features');
            return response()->json([
                'success' => true,
                'package' => $package
            ]);
        } catch (\Exception $e) {
            \Log::error('Exception in package edit', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to load package: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Package $package)
    {
        \Log::debug('Package update request', $request->all());
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|in:Wedding,Birthday,Baptism',
                'title' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'is_active' => 'boolean',
                'features' => 'array',
                'features.*.title' => 'required|string|max:255',
                'features.*.description' => 'required|string',
                'features.*.sort_order' => 'required|integer|min:1'
            ]);

            // Always store type as lowercase
            $validated['type'] = strtolower($validated['type']);

            DB::transaction(function () use ($validated, $package) {
                $package->update([
                    'name' => $validated['name'],
                    'type' => $validated['type'],
                    'title' => $validated['title'],
                    'price' => $validated['price'],
                    'base_price' => $validated['price'],
                    'description' => $validated['description'],
                    'is_active' => isset($validated['is_active'])
                ]);

                // Delete existing features
                $package->features()->delete();

                // Create new features
                if (isset($validated['features'])) {
                    foreach ($validated['features'] as $feature) {
                        PackageFeature::create([
                            'package_id' => $package->id,
                            'title' => $feature['title'],
                            'description' => $feature['description'],
                            'sort_order' => $feature['sort_order']
                        ]);
                    }
                }
            });

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Package updated successfully!'
                ]);
            }

            return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed in package update', ['errors' => $e->errors()]);
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Exception in package update', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update package: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Failed to update package: ' . $e->getMessage()]);
        }
    }

    public function destroy(Package $package)
    {
        try {
            $featureIds = $package->features()->pluck('id')->toArray();
            \Log::debug('Deleting features for package', ['package_id' => $package->id, 'feature_ids' => $featureIds]);
            $package->features()->delete();
            $package->delete();

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Package deleted successfully!'
                ]);
            }
            return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23503') { // Foreign key violation
                $msg = 'This package cannot be deleted because it is used in one or more bookings.';
                if (request()->expectsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $msg
                    ], 409);
                }
                return redirect()->route('admin.packages.index')->with('error', $msg);
            }
            throw $e;
        }
    }

    public function toggleStatus(Package $package)
    {
        $package->update(['is_active' => !$package->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $package->is_active
        ]);
    }

    // Existing API Methods
    public function getPackages(Request $request)
    {
        try {
            $eventType = $request->query('type');

            $packages = Package::where('type', $eventType)
                ->where('is_active', true)
                ->with(['features' => function ($query) {
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
