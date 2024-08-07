<?php

namespace App\DataTables;

use App\Models\ImagenSalon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ImagenSalonsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($imagenSalon) {
                // Renderiza las acciones usando una vista
                return view('admin.imagenSalons.actions', compact('imagenSalon'));
            })
            ->addColumn('salon', function ($imagenSalon) {
                // Accede al nombre del salón a través de la relación
                return $imagenSalon->salon->nombre;
            })
            ->addColumn('imagen', function ($imagenSalon) {
                // Crea un botón para ver la imagen
                $nombreSalon = $imagenSalon->salon->nombre;
                $imageUrl = asset('images/imagenes_salons/' . $imagenSalon->url);
                return "<button class='btn btn-primary btn-sm' onclick=\"openModal('{$imageUrl}','{$nombreSalon}')\">Ver imagen</button>";
            })
            ->setRowId('id')
            ->rawColumns(['imagen']); // Define las columnas como HTML crudo para renderizar correctamente los botones
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ImagenSalon $model): QueryBuilder
    {
        $query = $model->newQuery();
        // Aplica el filtro por ID de salón si se proporciona
        if (request()->input('salonId') != "") {
            $query->where('id_salon', request()->input('salonId'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('imagensalons-table') // Define el ID de la tabla
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
            Column::make('salon'), // Define la columna de salón
            Column::make('imagen'), // Define la columna de imagen
            Column::make('nombre_imagen')->title('Nombre de la imagen'), // Define la columna de nombre de imagen
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
        return 'ImagenSalons_' . date('YmdHis'); // Define el nombre de archivo para exportar
    }
}
