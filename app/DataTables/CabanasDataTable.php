<?php

namespace App\DataTables;

use App\Models\Cabana;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CabanasDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($cabana) {
                // Utiliza una vista para renderizar acciones en la columna
                return view('admin.cabanas.actions', compact('cabana'));
            })
            ->addColumn('tipo_cabana', function ($cabana) {
                // Accede al nombre del tipo de cabaña a través de la relación
                return $cabana->tipoCabana->nombre;
            })
            ->setRowId('id'); // Define la columna ID como ID de fila
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Cabana $model): QueryBuilder
    {
        $query = $model->newQuery();
        
        // Aplica el filtro por tipo de cabaña si se proporciona
        if (request()->input('tipoCabanaId') != "") {
            $query->where('id_tipo_cabana', request()->input('tipoCabanaId'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('cabanas-table') // Define el ID de la tabla
                    ->columns($this->getColumns()) // Define las columnas de la tabla
                    ->minifiedAjax() // Habilita la carga Ajax simplificada
                    ->dom('Bfrtip') // Define la estructura DOM de la tabla
                    ->orderBy(1) // Ordena por la primera columna por defecto
                    ->parameters([
                        'language' => [
                            'url' => "https://cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json", // Define el idioma de la tabla
                        ]
                    ])
                    ->selectStyleSingle() // Habilita la selección de fila única
                    ->buttons([ // Define los botones de la tabla
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
            Column::make('id'), // Define la columna ID
            Column::make('tipo_cabana')->title('Tipo de cabaña'), // Define la columna de tipo de cabaña
            Column::computed('action') // Define la columna de acciones
                ->title("Acciones")
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->addClass('text-center align-middle'), // Añade clases CSS a la columna de acciones
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Cabanas_' . date('YmdHis'); // Define el nombre de archivo para exportar
    }
}
