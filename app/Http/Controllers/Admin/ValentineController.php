<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ValentineSubmission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\DatatableTrait;

class ValentineController extends Controller
{
    use DatatableTrait;

    /**
     * Display the valentine submissions report.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ValentineSubmission::query()
                ->select(['id', 'uuid', 'sender_name', 'day_type', 'status', 'open_count', 'likes_count', 'created_at'])
                ->latest();

            $config = [
                'additionalColumns' => [
                    'day_type' => function ($row) {
                        $config = ValentineSubmission::getDayConfig();
                        $day = $config[$row->day_type] ?? null;
                        return $day ? $day['emoji'] . ' ' . $day['name'] : $row->day_type;
                    },
                    'status' => function ($row) {
                        $badges = [
                            'pending' => '<span class="badge bg-warning">Pending</span>',
                            'accepted' => '<span class="badge bg-success">Accepted</span>',
                            'rejected' => '<span class="badge bg-danger">Rejected</span>',
                        ];
                        return $badges[$row->status] ?? $row->status;
                    },
                    'view_link' => function ($row) {
                        return '<a href="' . route('admin.valentines.show', $row->id) . '" class="btn btn-sm btn-info" title="View"><i class="bx bx-show-alt"></i></a>';
                    },
                ],
                'disabledButtons' => ['edit', 'view'],
                'model' => 'ValentineSubmission',
                'rawColumns' => ['day_type', 'status', 'view_link'],
                'sortable' => false,
                'routeClass' => 'valentines',
            ];

            return $this->getDataTable($request, $query, $config)->make(true);
        }

        // Calculate statistics
        $stats = [
            'total' => ValentineSubmission::count(),
            'accepted' => ValentineSubmission::where('status', 'accepted')->count(),
            'rejected' => ValentineSubmission::where('status', 'rejected')->count(),
            'pending' => ValentineSubmission::where('status', 'pending')->count(),
            'total_opens' => ValentineSubmission::sum('open_count'),
            'total_likes' => ValentineSubmission::sum('likes_count'),
        ];

        // Top days
        $topDays = ValentineSubmission::selectRaw('day_type, COUNT(*) as count')
            ->groupBy('day_type')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return view('admin.valentine.index', [
            'columns' => ['sender_name', 'day_type', 'status', 'open_count', 'likes_count', 'created_at', 'view_link'],
            'stats' => $stats,
            'topDays' => $topDays,
        ]);
    }

    /**
     * Display a specific submission.
     */
    public function show(ValentineSubmission $valentine): View
    {
        $dayConfig = ValentineSubmission::getDayConfig();
        
        return view('admin.valentine.show', [
            'submission' => $valentine,
            'dayConfig' => $dayConfig[$valentine->day_type] ?? null,
        ]);
    }

    /**
     * Delete a submission.
     */
    public function destroy(ValentineSubmission $valentine)
    {
        $valentine->delete();

        return redirect()->route('admin.valentines.index')->with('error', 'Valentine Submission Deleted Successfully!');
    }
}
