<?php

namespace App\DataTables;

use App\Models\Resena;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ResenasDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($resena) {
                // Cargar la vista de acciones para la reseña
                return view('admin.resenas.actions', compact('resena'));
            })
            ->addColumn('nombre_usuario', function ($resena) {
                // Acceder al nombre del usuario a través de la relación
                return $resena->usuario->name;
            })
            ->addColumn('fecha', function ($resena) {
                // Formatear la fecha de creación
                return $resena->created_at->format('d/m/Y');
            })
            ->setRowId('id'); // Definir el ID de la fila como 'id'
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Resena $model): QueryBuilder
    {
        $query = $model->newQuery();
        
        // Aplicar el filtro por puntuación si se proporciona
        if (request()->input('puntuacion') != "") {
            $query->where('puntuacion', request()->input('puntuacion'));
        }

        // Aplicar el filtro por ID de usuario si se proporciona
        if (request()->input('usuarioId') != "") {
            $query->where('id_usuario', request()->input('usuarioId'));
        }

        // Aplicar el filtro por fecha de inicio si se proporciona
        if (request()->input('fechaInicio') != "") {
            $query->where('created_at','>=', request()->input('fechaInicio'));
        }

        // Aplicar el filtro por fecha de fin si se proporciona
        if (request()->input('fechaFin') != "") {
            $query->where('created_at','<=',request()->input('fechaFin'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('resenas-table') // Definir el ID de la tabla
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
            Column::make('puntuacion'), // Definir la columna de puntuación
            Column::make('comentario'), // Definir la columna de comentario
            Column::make('fecha'), // Definir la columna de fecha
            Column::computed('action') // Definir la columna de acciones
                ->title("Acciones")
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->addClass('text-center align-middle'), // Agregar clases CSS a la columna de acciones
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Resenas_' . date('YmdHis'); // Definir el nombre de archivo para exportar
    }
}
