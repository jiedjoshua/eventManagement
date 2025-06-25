<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Addon;

class AddonController extends Controller
{
    /**
     * Store a newly created add-on.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);
        $validated['display_name'] = $validated['name'];

        $addon = Addon::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Add-on created successfully!',
            'addon' => $addon
        ]);
    }

    /**
     * Return JSON for the requested add-on (for editing in modal).
     */
    public function edit($id)
    {
        $addon = Addon::find($id);
        if (!$addon) {
            return response()->json([
                'success' => false,
                'message' => 'Add-on not found.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'addon' => $addon
        ]);
    }

    public function update(Request $request, $id)
    {
        $addon = Addon::find($id);
        if (!$addon) {
            return response()->json([
                'success' => false,
                'message' => 'Add-on not found.'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);
        $validated['display_name'] = $validated['name'];

        $addon->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Add-on updated successfully!',
            'addon' => $addon
        ]);
    }

    /**
     * Remove the specified add-on from storage.
     */
    public function destroy($id)
    {
        try {
            $addon = Addon::find($id);
            if (!$addon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Add-on not found.'
                ], 404);
            }

            $addon->delete();

            return response()->json([
                'success' => true,
                'message' => 'Add-on deleted successfully!'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23503') { // Foreign key violation
                return response()->json([
                    'success' => false,
                    'message' => 'This add-on cannot be deleted because it is used in one or more bookings.'
                ], 409);
            }
            throw $e;
        }
    }
} 