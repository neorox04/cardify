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

        $item = RoadmapItem::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'priority'    => $data['priority'] ?? 'medium',
            'status'      => $data['status'] ?? 'todo',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'item' => $item->only('id', 'title', 'description', 'status', 'priority'),
            ]);
        }

        return redirect()->route('admin.roadmap')->with('success', 'Item adicionado ao roadmap.');
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

        // Drag (status) and edit (title/description/priority) both come via AJAX.
        if ($request->expectsJson() || ($request->has('status') && $request->keys() === ['status'])) {
            return response()->json([
                'item' => $item->only('id', 'title', 'description', 'status', 'priority'),
            ]);
        }

        return redirect()->route('admin.roadmap')->with('success', 'Item atualizado.');
    }

    public function destroy(Request $request, RoadmapItem $item)
    {
        $item->delete();

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()->route('admin.roadmap')->with('success', 'Item removido do roadmap.');
    }
}
