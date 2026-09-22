<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    /**
     * Mostrar todos los contenidos.
     */
    public function index(Request $request): View
    {
        $contents = Content::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $contentStats = [
            'total' => Content::count(),
            'published' => Content::where('status', 'published')->count(),
            'drafts' => Content::where('status', 'draft')->count(),
        ];

        return view('admin.contents.index', compact('contents', 'contentStats'));
    }

    /**
     * Mostrar formulario para crear contenido.
     */
    public function create(): View
    {
        return view('admin.contents.create');
    }

    /**
     * Guardar un nuevo contenido.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:published,draft'],
        ]);

        $content = Content::create($validated);

        return redirect()
            ->route('admin.contents.show', $content)
            ->with('success', 'Contenido creado correctamente.');
    }

    /**
     * Mostrar un contenido.
     */
    public function show(Content $content): View
    {
        return view('admin.contents.show', compact('content'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Content $content): View
    {
        return view('admin.contents.edit', compact('content'));
    }

    /**
     * Actualizar contenido.
     */
    public function update(Request $request, Content $content): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:published,draft'],
        ]);

        $content->update($validated);

        return redirect()
            ->route('admin.contents.show', $content)
            ->with('success', 'Contenido actualizado correctamente.');
    }

    /**
     * Eliminar contenido.
     */
    public function destroy(Content $content): RedirectResponse
    {
        $content->delete();

        return redirect()
            ->route('admin.contents.index')
            ->with('success', 'Contenido eliminado correctamente.');
    }
}

