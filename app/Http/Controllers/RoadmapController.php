<?php

namespace App\Http\Controllers;

use App\Models\RoadmapItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoadmapController extends Controller
{
    public function index(): View
    {
        $items = RoadmapItem::latest()->get()->groupBy('status');

        return view('admin.roadmap', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'priority'    => ['nullable', 'in:' . implode(',', array_keys(RoadmapItem::PRIORITIES))],
            'status'      => ['nullable', 'in:' . implode(',', array_keys(RoadmapItem::STATUSES))],
        ]);

        RoadmapItem::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'priority'    => $data['priority'] ?? 'medium',
            'status'      => $data['status'] ?? 'todo',
        ]);

        return back()->with('success', 'Item adicionado ao roadmap.');
    }

    public function update(Request $request, RoadmapItem $item)
    {
        $data = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'priority'    => ['sometimes', 'in:' . implode(',', array_keys(RoadmapItem::PRIORITIES))],
            'status'      => ['sometimes', 'in:' . implode(',', array_keys(RoadmapItem::STATUSES))],
        ]);

        $item->update($data);

        // Status-only updates come from drag-and-drop (AJAX).
        if ($request->expectsJson() || ($request->has('status') && $request->keys() === ['status'])) {
            return response()->json(['ok' => true]);
        }

        return back()->with('success', 'Item atualizado.');
    }

    public function destroy(RoadmapItem $item)
    {
        $item->delete();

        return back()->with('success', 'Item removido do roadmap.');
    }
}
