<?php

namespace App\DataTables;

use App\Models\Oferta;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OfertasDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($oferta) {
                // Carga la vista de acciones para la oferta
                return view('admin.ofertas.actions', compact('oferta'));
            })
            ->addColumn('tipo_cabana', function ($oferta) {
                // Accede al nombre del tipo de cabaña a través de la relación
                return $oferta->tipoCabana->nombre;
            })
            ->addColumn('fecha_inicio', function ($oferta) {
                // Formatea la fecha de inicio
                return Carbon::parse($oferta->fecha_inicio)->format('d/m/Y');
            })
            ->addColumn('fecha_fin', function ($oferta) {
                // Formatea la fecha de fin
                return Carbon::parse($oferta->fecha_fin)->format('d/m/Y');
            })
            ->setRowId('id'); // Define el ID de la fila como 'id'
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Oferta $model): QueryBuilder
    {
        $query = $model->newQuery();
        
        // Aplica el filtro por ID de tipo de cabaña si se proporciona
        if (request()->input('tipoCabanaId') != "") {
            $query->where('id_tipo_cabana', request()->input('tipoCabanaId'));
        }

        // Aplica el filtro por fecha de inicio si se proporciona
        if (request()->input('fechaInicio') != "") {
            $query->where('fecha_inicio', request()->input('fechaInicio'));
        }

        // Aplica el filtro por fecha de fin si se proporciona
        if (request()->input('fechaFin') != "") {
            $query->where('fecha_fin', request()->input('fechaFin'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('ofertas-table') // Define el ID de la tabla
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
            Column::make('descuento')->title('Descuento %'), // Define la columna de descuento
            Column::make('fecha_inicio')->title('Fecha de inicio'), // Define la columna de fecha de inicio
            Column::make('fecha_fin')->title('Fecha de fin'), // Define la columna de fecha de fin
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
        return 'Ofertas_' . date('YmdHis'); // Define el nombre de archivo para exportar
    }
}
