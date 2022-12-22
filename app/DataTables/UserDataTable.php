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
                $url = $row->photo ? AppFile::url('public', $row->photo): 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHsAAAB7CAMAAABjGQ9NAAAAVFBMVEXv8PL6+/3z9PaAiZDu7vLv8PB4hIeBi4/j5ei2usH29vWnrbH3+Pp+ho16hIq7vsWgpqp3f4bIzdCIkJXV2Nvc3uJzf4O+wsaVmp6ZoKSts7ausbdVdA7yAAAByElEQVRoge3ai26CMBQG4HoOnaClUC46t/d/z7VjiKJgox7Ikv83MZFqP09LuRjVZr0o2LBhw4YN+702icbM20oyBBs2bNiwYcOGDRs2bNiwpWxSM128YOuIzHYgbM99/nmbVBITkhjztv6IiK3T6T6etSkr05iU2fvtXbaPWQS0F7ApztYS9kzdlzu3r3u3nE1+1x5aRMZ8wqa0dtzQufQl7U2dM1u1ik2OmV2brGBrs2bdLTtbrTPfPqlKhhfStia6OV/1baK2f6LmTv+644XrpmZ7OI7fuEjdgc7ZjnBq/nTZMW/ZryqPG32uVu8qV1I3H2K2fzQu0P54kpm+SZvKsfukJLTL1W2avKMvcK2rcHCzp7DWJGzd1d3wENfNuaaq+zr2lMjVHej8As+Pfp17ut9oS5lrh8Tbpr2iww5HnrbDSJQkVPdX665pzt1x8zvXfQ4nI3HdQkXt1/UIZ/vtrrbZUsDWVFi+k/GXyW3x/v18wr6JLcxUHwvYAtfnhXsMy9hapTVvH4a5TifpZ+1wmoi8D52+D/6Pv3lQ3L2/LzqZ7uMf1g0bNmzYsGHDhg0bNmzYsCVts+L/sBcNbNiwYcOG/Wp+AH9ZMxSJz71EAAAAAElFTkSuQmCC';
                return '<img src="'.$url.'" alt="" width="100">';
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
                if(auth()->user()->can('approve-user')) {
                    $html .= '<button type="button" class="btn btn-success btn-sm btn-approve" data-url="'.route('user.approve', $row).'">Approve</button>';
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
