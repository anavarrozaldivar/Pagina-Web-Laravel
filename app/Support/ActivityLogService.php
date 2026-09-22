<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public static function modelCreated(Model $model): void
    {
        self::recordModelEvent('created', $model);
    }

    public static function modelUpdated(Model $model): void
    {
        $changes = $model->getChanges();

        unset(
            $changes['updated_at'],
            $changes['password'],
            $changes['remember_token']
        );

        if ($changes !== []) {
            $changes = self::sanitize($changes);
        }

        self::recordModelEvent(
            'updated',
            $model,
            $changes
        );
    }

    public static function modelDeleted(Model $model): void
    {
        self::recordModelEvent('deleted', $model);
    }

    public static function record(
        string $action,
        ?Model $actor,
        ?Model $subject,
        string $description,
        array $properties = []
    ): ActivityLog {
        $actor ??= Auth::user();

        return ActivityLog::create([
            'user_id' => $actor?->getKey(),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'properties' => $properties !== []
                ? self::sanitize($properties)
                : null,
            'ip_address' => app()->runningInConsole()
                ? null
                : request()->ip(),
            'user_agent' => app()->runningInConsole()
                ? null
                : request()->userAgent(),
        ]);
    }

    private static function recordModelEvent(
        string $action,
        Model $model,
        array $properties = []
    ): void {
        $description = self::buildDescription($action, $model);

        self::record(
            $action,
            Auth::user(),
            $model,
            $description,
            $properties
        );
    }

    private static function buildDescription(
        string $action,
        Model $model
    ): string {
        $subject = match (class_basename($model)) {
            'User' => 'usuario "' . ($model->name ?? 'Sin nombre') . '"',
            'Role' => 'rol "' . ($model->label ?? $model->name ?? 'Sin nombre') . '"',
            'Content' => 'contenido "' . ($model->title ?? 'Sin título') . '"',
            'Setting' => 'configuración "' . ($model->key ?? 'Sin clave') . '"',
            'Notification' => 'notificación "' . ($model->title ?? 'Sin título') . '"',
            default => strtolower(class_basename($model)),
        };

        $verb = match ($action) {
            'created' => 'creó',
            'updated' => 'modificó',
            'deleted' => 'eliminó',
            default => 'actualizó',
        };

        return ucfirst($verb . ' ' . $subject . '.');
    }

    private static function sanitize(array $data): array
    {
        $sensitiveKeys = [
            'password',
            'password_confirmation',
            'remember_token',
            'token',
            'secret',
            'api_key',
            'access_token',
        ];

        foreach ($data as $key => $value) {
            $keyLower = strtolower((string) $key);

            foreach ($sensitiveKeys as $sensitiveKey) {
                if (str_contains($keyLower, $sensitiveKey)) {
                    $data[$key] = '[REDACTED]';
                    continue 2;
                }
            }

            if (is_array($value)) {
                $data[$key] = self::sanitize($value);
            }
        }

        return $data;
    }
}