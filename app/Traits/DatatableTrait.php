<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

trait DatatableTrait
{
    public function getDataTable(Request $request, $data, $config)
    {
        $dataTable = DataTables::of($data instanceof Builder ? $data : $data->query())->addIndexColumn();

        foreach ($config['additionalColumns'] as $columnName => $callback) {
            $dataTable->addColumn($columnName, $callback);
        }

        if (!in_array('status', $config['disabledButtons'] ?? [], true)) {
            $dataTable->addColumn('status', function ($row) {
                return View::make('components.form.switch', [
                    'model' => $row,
                    'attribute' => 'status',
                ])->render();
            });
        }

        $dataTable
            ->addColumn('action', function ($row) use ($config) {
                $baseClassName = $config['routeClass'] ?? Str::plural(strtolower(class_basename($row)));
                $actionButtons = '';

                if (!in_array('delete', $config['disabledButtons'] ?? [], true)) {
                    $actionButtons .= view('components.table.delete_btn', [
                        'routeDestroy' => route('admin.' . $baseClassName . '.destroy', $row->id),
                    ])->render();
                }

                if (!in_array('edit', $config['disabledButtons'] ?? [], true)) {
                    $actionButtons .= view('components.table.edit_btn', [
                        'routeEdit' => route('admin.' . $baseClassName . '.edit', $row->id),
                    ])->render();
                }

                if (!in_array('view', $config['disabledButtons'] ?? [], true)) {
                    $actionButtons .=
                        '<a href="#" class="btn btn-sm btn-default" title="View ' .
                        $config['model'] .
                        '" data-bs-toggle="modal" data-bs-target="#view' .
                        $config['model'] .
                        $row->id .
                        '" data-' .
                        $config['model'] .
                        '-id="' .
                        $row->id .
                        '"><i class="bx bx-show-alt"></i></a> ' .
                        view('components.view_modal', [
                            'id' => $row->id,
                            'model' => $config['model'],
                        ])->render();
                }

                return '<div class="d-flex">' . $actionButtons . '</div>';
            })
            ->rawColumns(array_merge(['action', 'status'], $config['rawColumns']));

        if ($config['sortable'] === true) {
            $dataTable
                ->setRowAttr([
                    'data-id' => function ($row) {
                        return $row->id;
                    },
                ])
                ->setRowClass('row1');
        }

        return $dataTable;
    }
}
