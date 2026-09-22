<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Mostrar las notificaciones del usuario.
     */
    public function index(Request $request): View
    {
        $notifications = Notification::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }


    /**
     * Marcar una notificación como leída.
     */
    public function markAsRead(
        Request $request,
        Notification $notification
    ): RedirectResponse {
        abort_unless(
            $notification->user_id === $request->user()->id,
            403
        );

        $notification->update([
            'read_at' => now(),
        ]);

        if ($notification->url) {
            return redirect($notification->url);
        }

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notificación marcada como leída.');
    }


    /**
     * Marcar todas las notificaciones como leídas.
     */
    public function markAllAsRead(Request $request): RedirectResponse
    {
        Notification::query()
            ->where('user_id', $request->user()->id)
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Todas las notificaciones han sido marcadas como leídas.');
    }


    /**
     * Mostrar formulario para crear una notificación.
     */
    public function create(): View
    {
        $users = User::query()
            ->orderBy('name')
            ->get();

        return view('admin.notifications.create', compact('users'));
    }


    /**
     * Guardar y enviar una notificación.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
                'max:2000',
            ],

            'type' => [
                'required',
                'in:info,success,warning',
            ],

            'url' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        Notification::create($validated);

        return redirect()
            ->route('admin.users.show', $validated['user_id'])
            ->with('success', 'Notificación enviada correctamente.');
    }
}
