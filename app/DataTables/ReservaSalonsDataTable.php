<?php

namespace App\DataTables;

use App\Models\ReservaSalon;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReservaSalonsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($reservaSalon) {
                // Cargar la vista de acciones para la reserva de salón
                return view('admin.reservaSalons.actions', compact('reservaSalon'));
            })
            ->addColumn('nombre_usuario', function ($reservaSalon) {
                // Acceder al nombre del usuario a través de la relación
                return $reservaSalon->usuario->name;
            })
            ->addColumn('nombre_salon', function ($reservaSalon) {
                // Acceder al nombre del salón a través de la relación
                return $reservaSalon->salon->nombre;
            })
            ->addColumn('fecha_evento', function ($reservaSalon) {
                // Formatear la fecha del evento
                return Carbon::parse($reservaSalon->fecha_evento)->format('d/m/Y');
            })
            ->addColumn('hora_inicio', function ($reservaSalon) {
                // Formatear la hora de inicio
                return Carbon::parse($reservaSalon->hora_inicio)->format('H:i');
            })
            ->addColumn('hora_fin', function ($reservaSalon) {
                // Formatear la hora de fin
                return Carbon::parse($reservaSalon->hora_fin)->format('H:i');
            })
            ->setRowId('id'); // Definir el ID de la fila como 'id'
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ReservaSalon $model): QueryBuilder
    {
        $query = $model->newQuery();

        // Aplicar filtro por ID de salón si se proporciona
        if (request()->input('salonId') != "") {
            $query->where('id_salon', request()->input('salonId'));
        }

        // Aplicar filtro por ID de usuario si se proporciona
        if (request()->input('usuarioId') != "") {
            $query->where('id_usuario', request()->input('usuarioId'));
        }

        // Aplicar filtro por fecha de inicio si se proporciona
        if (request()->input('fechaInicio') != "") {
            $query->where('fecha_evento','>=', request()->input('fechaInicio'));
        }

        // Aplicar filtro por fecha de fin si se proporciona
        if (request()->input('fechaFin') != "") {
            $query->where('fecha_evento','<=',request()->input('fechaFin'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('reservasalons-table') // Definir el ID de la tabla
                    ->columns($this->getColumns()) // Definir las columnas de la tabla
                    ->minifiedAjax() // Habilitar la carga Ajax simplificada
                    ->dom('Bfrtip') // Definir la estructura DOM de la tabla
                    ->orderBy(1) // Ordenar por la primera columna por defecto
                    ->parameters([
                        'language' => [
                            'url' => "https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json", // Definir el idioma de la tabla
                        ]
                    ])
                    ->selectStyleSingle() // Habilitar la selección de fila única
                    ->buttons([ // Definir los botones de la tabla
                        Button::make('add')->text("+ Nuevo"),
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload'),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'), // Definir la columna ID
            Column::make('nombre_usuario')->title('Nombre Cliente'), // Definir la columna de nombre de cliente
            Column::make('nombre_salon')->title("Nombre Salon"), // Definir la columna de nombre de salón
            Column::make('fecha_evento')->title("Fecha del evento"), // Definir la columna de fecha del evento
            Column::make('hora_inicio')->title("Hora de inicio"), // Definir la columna de hora de inicio
            Column::make('hora_fin')->title("Hora de fin"), // Definir la columna de hora de fin
            Column::make('tipo_evento')->title("Tipo de evento"), // Definir la columna de tipo de evento
            Column::make('mensaje')->width('300px'), // Definir la columna de mensaje
            Column::make('precio_final'), // Definir la columna de precio final
            Column::computed('action') // Definir la columna de acciones
                ->title("Acciones")
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->addClass('text-center align-middle') // Agregar clases CSS a la columna de acciones
                ->width('150px'), // Definir el ancho de la columna de acciones
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ReservaSalons_' . date('YmdHis'); // Definir el nombre de archivo para exportar
    }
}
