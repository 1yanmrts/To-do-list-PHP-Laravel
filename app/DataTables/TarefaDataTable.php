<?php

namespace App\DataTables;

use App\Models\Tarefa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TarefaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder<Tarefa>  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($tarefa) {
                return view('partials.botoes-tabela', compact('tarefa'))->render();
            })
            ->addColumn('status', function ($tarefa) {
                $checked = $tarefa->concluida ? 'checked' : '';

                return view('partials.status-checkbox', compact('tarefa'))->render();
            })
            ->editColumn('data_limite', function ($tarefa) {
                return $tarefa->data_limite ? Carbon::parse($tarefa->data_limite)->format('d/m/Y') : '-';
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Tarefa>
     */
    public function query(Tarefa $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {        
        return $this->builder()
            ->setTableId('tarefa-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->layout([
                'topStart' => 'buttons',
                'topEnd' => 'search',
                'bottomStart' => 'info',
                'bottomEnd' => 'paging',
            ])
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel')->text('<i class="fa-solid fa-file-excel"></i> Excel'),
                Button::make('csv')->text('<i class="fa-solid fa-file-csv"></i> CSV'),
                Button::make('pdf')->text('<i class="fa-solid fa-file-pdf"></i> PDF'),
                Button::make('print')->text('<i class="fa-solid fa-print"></i> Imprimir'),
            ])
            ->parameters([
                'destroy' => true,
                'language' => [
                    'url' => asset('vendor/datatables/i18n/pt-BR.json'),
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID')->width(50),
            Column::computed('status')->title('Feita')->width(50)->addClass('text-center'),
            Column::make('nome')->title('Titulo da Tarefa'),
            Column::make('descricao')->title('Descrição'),
            Column::make('data_limite')->title('Data Limite'),

            Column::computed('action')
                ->title('Ações')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Tarefa_'.date('YmdHis');
    }
}
