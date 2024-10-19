<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Apartado;
use App\Models\Inventario;

class CancelarApartado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancelar-apartado';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Iniciando el proceso de cancelación de apartados expirados.');

            Apartado::where('estado', 'pendiente')
                ->where('fecha_expiracion', '<=', now())
                ->chunk(100, function ($apartadosExpirados) {
                    foreach ($apartadosExpirados as $apartado) {
                        $apartado->estado = 'cancelado';
                        $apartado->save();

                        foreach ($apartado->detalles as $item) {
                            $lote = Inventario::where('id_medicamento', $item->id_medicamento)
                                ->where('id_farmacia', $apartado->id_farmacia)
                                ->where('numero_lote', $item->numero_lote)
                                ->first();

                            if ($lote) {
                                $lote->cantidad_disponible += $item->cantidad;
                                $lote->save();
                            }
                        }
                    }

                    $this->info('Lote de apartados procesados.');
                });

            $this->info('Apartados expirados cancelados con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al cancelar apartados expirados: ' . $e->getMessage());
        }
    }
}
