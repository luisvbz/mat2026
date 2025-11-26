<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_reclamo',
        'fecha_incidente',
        'nombre',
        'apellido',
        'tipo_documento',
        'numero_documento',
        'direccion',
        'departamento',
        'provincia',
        'distrito',
        'telefono',
        'email',
        'es_menor_edad',
        'nombre_apoderado',
        'apellido_apoderado',
        'dni_apoderado',
        'telefono_apoderado',
        'tipo_bien',
        'descripcion_bien',
        'monto_reclamado',
        'moneda',
        'detalle_reclamo',
        'pedido',
        'observaciones',
        'acciones',
        'numero_registro',
        'estado',
        'acepto_terminos',
        'fecha_respuesta',
    ];

    protected $casts = [
        'fecha_incidente' => 'date',
        'es_menor_edad' => 'boolean',
        'acepto_terminos' => 'boolean',
        'monto_reclamado' => 'decimal:2',
        'fecha_respuesta' => 'datetime',
    ];

    // Generar número de registro automático
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reclamo) {
            $reclamo->numero_registro = 'REC-' . date('Y') . '-' . str_pad(
                static::whereYear('created_at', date('Y'))->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );
        });
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function getNombreApoderadoCompletoAttribute()
    {
        if ($this->es_menor_edad && $this->nombre_apoderado) {
            return $this->nombre_apoderado . ' ' . $this->apellido_apoderado;
        }
        return null;
    }

    public function getTipoReclamoLabelAttribute()
    {
        return ucfirst($this->tipo_reclamo);
    }

    public function getEstadoLabelAttribute()
    {
        $estados = [
            'pendiente' => 'Pendiente',
            'en_proceso' => 'En Proceso',
            'resuelto' => 'Resuelto',
            'cerrado' => 'Cerrado'
        ];

        return $estados[$this->estado] ?? 'Desconocido';
    }

    public function getMontoFormateadoAttribute()
    {
        if (!$this->monto_reclamado) return null;

        $simbolo = $this->moneda === 'dolares' ? 'US$ ' : 'S/ ';
        return $simbolo . number_format($this->monto_reclamado, 2);
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en_proceso');
    }

    public function scopeResueltos($query)
    {
        return $query->where('estado', 'resuelto');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_reclamo', $tipo);
    }

    public function scopePorFecha($query, $fechaInicio, $fechaFin = null)
    {
        $query->whereDate('created_at', '>=', $fechaInicio);

        if ($fechaFin) {
            $query->whereDate('created_at', '<=', $fechaFin);
        }

        return $query;
    }
}
