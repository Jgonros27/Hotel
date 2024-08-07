<?php

namespace App\DataTables;

use App\Models\TipoCabana;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TipoCabanasDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // Configurar las columnas de la DataTable
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($tipoCabana) {
                // Agregar columna de acciones que muestra botones para editar, eliminar, etc.
                return view('admin.tipoCabanas.actions', compact('tipoCabana'));
            })
            ->editColumn('servicios', function ($tipoCabana) {
                // Editar la columna 'servicios' para mostrar una lista de servicios
                $serviciosArray = explode(';', $tipoCabana->servicios);
                $cadena = "<ul>";
                foreach ($serviciosArray as $servicio) {
                    $cadena = $cadena . "<li>".$servicio."</li>";
                }
                $cadena = $cadena . "</ul>";
                return $cadena;
            })
            ->setRowId('id') // Definir el ID de la fila como 'id'
            ->rawColumns(['servicios']); // Marcar la columna 'servicios' como HTML crudo
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(TipoCabana $model): QueryBuilder
    {
        // Obtener la consulta base para los tipos de cabaña
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        // Configurar el generador HTML para la DataTable
        return $this->builder()
                    ->setTableId('tipocabanas-table') // Definir el ID de la tabla
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
        // Definir las columnas de la DataTable
        return [
            Column::make('id'), // Columna de ID
            Column::make('nombre'), // Columna de nombre
            Column::make('precio'), // Columna de precio
            Column::make('capacidad'), // Columna de capacidad
            Column::make('servicios'), // Columna de servicios
            Column::make('precio_media_pension'), // Columna de precio con media pensión
            Column::make('dias_cancelacion'), // Columna de días de cancelación
            Column::make('especificaciones'), // Columna de especificaciones
            Column::computed('action') // Columna de acciones
                ->title("Acciones") // Título de la columna
                ->exportable(false) // No exportable
                ->printable(false) // No imprimible
                ->searchable(false) // No se puede buscar
                ->orderable(false) // No se puede ordenar
                ->addClass('text-center align-middle'), // Clases CSS para centrar el contenido
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        // Definir el nombre de archivo para exportar
        return 'TipoCabanas_' . date('YmdHis');
    }
}
