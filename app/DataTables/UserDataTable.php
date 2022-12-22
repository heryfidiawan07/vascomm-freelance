<?php

namespace App\DataTables;

use App\Models\User;
use App\Helpers\AppFile;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('roles', function($row) {
                return implode(', ', $row->getRoleNames()->toArray());
            })
            ->editColumn('photo', function($row) {
                return '<img src="'.$row->getPhoto().'" alt="" width="100">';
            })
            ->editColumn('status', function($row) {
                return $row->status ? 'Approved' : 'Inactive';
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format("d M Y");
            })
            ->editColumn('updated_at', function($row) {
                return $row->updated_at->format("d M Y");
            })
            ->addColumn('action', function($row) {
                $html = '<div class="d-flex">'; 
                $html .= '<a href="'.route('user.detail', $row).'" class="btn btn-info btn-sm">Detail</a>';
                if(auth()->user()->can('approve-user')) {
                    $html .= '<button type="button" class="btn btn-success btn-sm btn-approve ms-1" data-url="'.route('user.approve', $row).'">Approve</button>';
                }
                if(auth()->user()->can('edit-user')) {
                    $html .= '<button type="button" class="btn btn-primary btn-sm btn-edit ms-1" data-bs-toggle="modal" data-bs-target="#form-modal" data-url="'.route('user.update', $row).'">Edit</button>';
                }
                if(auth()->user()->can('delete-user')) {
                    $html .= '<button type="button" class="btn btn-danger btn-sm btn-delete ms-1" data-url="'.route('user.destroy', $row).'">Delete</button>';
                }
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['photo', 'action']);
    }

    public function query(User $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->addIndex()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax();
                    // ->dom('Bfrtip')
                    // ->orderBy(1)
                    // ->buttons(
                    //     Button::make('create'),
                    //     Button::make('export'),
                    //     Button::make('print'),
                    //     Button::make('reset'),
                    //     Button::make('reload')
                    // );
    }

    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No')
                ->exportable(false)
                ->printable(false)
                ->width(5)
                ->addClass('text-center'),
            Column::make('photo'),
            Column::make('name'),
            Column::make('email'),
            Column::make('roles'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('action'),
        ];
    }

    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
