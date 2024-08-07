<?php

namespace App\DataTables;

use App\Models\ReservaCabana;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReservaCabanasDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($reservaCabana) {
                // Cargar la vista de acciones para la reserva de cabaña
                return view('admin.reservaCabanas.actions', compact('reservaCabana'));
            })
            ->addColumn('nombre_usuario', function ($reservaCabana) {
                // Acceder al nombre del usuario a través de la relación
                return $reservaCabana->usuario->name;
            })
            ->addColumn('fecha_entrada', function ($reservaCabana) {
                // Formatear la fecha de entrada
                return Carbon::parse($reservaCabana->fecha_entrada)->format('d/m/Y');
            })
            ->addColumn('fecha_salida', function ($reservaCabana) {
                // Formatear la fecha de salida
                return Carbon::parse($reservaCabana->fecha_salida)->format('d/m/Y');
            })
            ->addColumn('tipo_cabana', function ($reservaCabana) {
                // Acceder al tipo de cabaña a través de la relación
                return $reservaCabana->cabana->tipoCabana->nombre;
            })
            ->setRowId('id'); // Definir el ID de la fila como 'id'
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ReservaCabana $model): QueryBuilder
    {
        $query = $model->newQuery();
        
        // Aplicar el filtro por ID de tipo de cabaña si se proporciona
        if (request()->input('tipoCabanaId') != "") {
            $query->whereHas('cabana', function ($query) {
                $query->where('id_tipo_cabana', request()->input('tipoCabanaId'));
            });
        }

        // Aplicar el filtro por ID de usuario si se proporciona
        if (request()->input('usuarioId') != "") {
            $query->where('id_usuario', request()->input('usuarioId'));
        }

        // Aplicar el filtro por fecha de entrada si se proporciona
        if (request()->input('fechaEntrada') != "") {
            $query->where('fecha_entrada', request()->input('fechaEntrada'));
        }

        // Aplicar el filtro por fecha de salida si se proporciona
        if (request()->input('fechaSalida') != "") {
            $query->where('fecha_salida', request()->input('fechaSalida'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('reservacabanas-table') // Definir el ID de la tabla
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
            Column::make('nombre_usuario')->title('Nombre de cliente'), // Definir la columna de nombre de usuario
            Column::make('tipo_cabana')->title('Tipo de cabaña'), // Definir la columna de tipo de cabaña
            Column::make('id_cabana')->title('Cabaña nº'), // Definir la columna de número de cabaña
            Column::make('fecha_entrada')->title('Fecha de entrada'), // Definir la columna de fecha de entrada
            Column::make('fecha_salida')->title('Fecha de salida'), // Definir la columna de fecha de salida
            Column::make('n_huespedes')->title('Nº de huéspedes'), // Definir la columna de número de huéspedes
            Column::make('precio_habitacion'), // Definir la columna de precio de habitación
            Column::make('precio_total'), // Definir la columna de precio total
            Column::make('descuento'), // Definir la columna de descuento
            Column::make('media_pension'), // Definir la columna de media pensión
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
        return 'ReservaCabanas_' . date('YmdHis'); // Definir el nombre de archivo para exportar
    }
}
