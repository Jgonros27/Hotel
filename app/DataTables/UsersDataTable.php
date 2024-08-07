<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('action', function ($usuario) {
                // Agregar columna de acciones que muestra botones para editar, eliminar, etc.
                return view('admin.usuarios.actions', compact('usuario'));
            })
            ->editColumn('admin', function ($usuario) {
                // Editar la columna 'admin' para mostrar "Si" si es admin y "No" si no lo es
                return $usuario->admin ? "Si" : "No";
            })
            ->setRowId('id'); // Definir el ID de la fila como 'id'
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        // Obtener la consulta base para los usuarios
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        // Configurar el generador HTML para la DataTable
        return $this->builder()
                    ->setTableId('users-table') // Definir el ID de la tabla
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
            Column::make('name')->title('Nombre'), // Columna de nombre con título personalizado
            Column::make('email'), // Columna de correo electrónico
            Column::make('admin')->title('Es admin') // Columna de admin
                ->exportable(false) // No exportable
                ->printable(false) // No imprimible
                ->searchable(false) // No se puede buscar
                ->orderable(false) // No se puede ordenar
                ->addClass('text-center'), // Clases CSS para centrar el contenido
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
        return 'Users_' . date('YmdHis');
    }
}
