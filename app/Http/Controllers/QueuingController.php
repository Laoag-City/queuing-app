<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Statistic;
use App\QueueType;
use Validator;

class QueuingController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
    	$this->request = $request;
    }

    public function showViewOptions()
    {
    	return view('view_option', [
    		'title' => 'View Types',
    		'queue' => !Auth::user()->is_admin ? Auth::user()->queue_type->queue_type_id : QueueType::all()->toArray()
    	]);
    }

    public function showWindowView()
    {
    	return view('window', [
    		'title' => 'Window ' . Auth::user()->window_number,
    		'current_regular_number' => $this->getResettedNumber(Auth::user()->current_regular_queue_number, Auth::user()->queue_type->queue_limit_regular),
    		'current_pod_number' => $this->getResettedNumber(Auth::user()->current_pod_queue_number, Auth::user()->queue_type->queue_limit_pod),
            'regular_color' => Auth::user()->queue_type->color_regular,
            'pod_color' => Auth::user()->queue_type->color_pod,
    	]);
    }

    //used for client view and the "real time" update of each queue
    public function showClientView(QueueType $queue_type)
    {
    	if($this->request->ajax())
    	{
    		$results = User::select(['user_id','queue_type_id', 'window_number', 'current_regular_queue_number', 'current_pod_queue_number', 'is_currently_serving_regular'])
    						->where([
    							['is_admin', '=', false],
    							['queue_type_id', '=', $queue_type->queue_type_id]
    						])
                            ->with(['queue_type:queue_type_id,queue_limit_regular,queue_limit_pod'])
    						->orderBy('window_number', 'asc')
    						->get()
                            ->toArray();

            foreach($results as &$result)
            {
                $result['current_regular'] = $result['current_regular'] != null ? $this->getResettedNumber($result['current_regular'], $result['queue_type']['queue_limit_regular']) : $result['current_regular'];
                $result['current_pod'] = $result['current_pod'] != null ? $this->getResettedNumber($result['current_pod'], $result['queue_type']['queue_limit_pod']) : $result['current_pod'];
            }

            $rows = ceil(count($results) / 3);
            $vertical_results = [];

            for($i = 0; $i < $rows; $i++)
                for($j = 0; $j < 3; $j++)
                    $vertical_results[] = isset($results[$i + $j * $rows]) ? $results[$i + $j * $rows] : null;

            return $vertical_results;
    	}

    	else
    		return view('client', [
    			'title' => 'Queue View',
    			'window_type' => $queue_type->type,
                'queue_id' => $queue_type->queue_type_id,
                'regular_color' => $queue_type->color_regular,
                'pod_color' => $queue_type->color_pod,
    		]);
    }

    //used for when teller press next in window view
    public function incrementNumber()
    {
    	if($this->request->ajax())
    	{
    		Validator::make($this->request->all(), [
    			'client_type' => 'required|in:Regular,POD'
    		])->validate();

            $stats = Statistic::firstOrNew(['queue_type_id' => Auth::user()->queue_type_id, 'date' => date('Y-m-d', strtotime('now'))]);

    		if($this->request->client_type == 'Regular')
    		{
    			$row = 'current_regular_queue_number';
                $stats->total_regular += 1;
                $limit = Auth::user()->queue_type->queue_limit_regular;
                $serving_regular = true;
    		}

    		else
    		{
    			$row = 'current_pod_queue_number';
                $stats->total_pod += 1;
                $limit = Auth::user()->queue_type->queue_limit_pod;
                $serving_regular = false;
    		}

            $stats->save();

    		$latest_number = User::where('queue_type_id', Auth::user()->queue_type_id)->max($row) + 1;

			User::where('user_id', Auth::user()->user_id)
				->update([$row => $latest_number, 'is_currently_serving_regular' => $serving_regular]);

			return $this->getResettedNumber($latest_number, $limit);
    	}

    	else
    		return response([], 405);
    }

    public function getStatistics()
    {
        if($this->request->year && $this->request->queue)
        {
            Validator::make($this->request->all(), [
                'year' => 'integer|min:2018',
                'queue' => 'exists:queue_types,queue_type_id'
            ])->validate();

            $title = 'Queue Statistics: ' . QueueType::find($this->request->queue)->type . " ({$this->request->year})";

            $stats = Statistic::where('queue_type_id', $this->request->queue)
                                ->whereYear('date', $this->request->year)
                                ->get()
                                ->transform(function($item, $key){
                                    return [
                                        'month' => date('m', strtotime($item->date)),
                                        'month_name' => date('F', strtotime($item->date)),
                                        'date' => date('d', strtotime($item->date)),
                                        'total_regular' => $item->total_regular,
                                        'total_pod' => $item->total_pod
                                    ];
                                })
                                ->sortBy('date');
        }

        else
        {
            $stats = [];
            $title = 'Queue Statistics';
        }

        return view('stats', [
            'title' => $title,
            'stats' => $stats,
            'queues' => QueueType::all()->toArray()
        ]);
    }

    public function resetQueue()
    {
    	if($this->request->isMethod('get'))
    	{
    		return view('reset_queue', [
	    		'title' => 'Reset Queue',
	    		'queues' => QueueType::all()
	    	]);
    	}

    	else if($this->request->isMethod('put'))
    	{
    		Validator::make($this->request->all(), [
	    		'queue_type' => 'bail|required|exists:queue_types,queue_type_id'
	    	])->validate();

	    	User::where('queue_type_id', $this->request->queue_type)
	    		->update(['current_regular_queue_number' => null, 
		                    'current_pod_queue_number' => null, 
		                    'is_currently_serving_regular' => null,
		                ]);

	    	return back()->with('success', ['header' => 'Queue reset successfully.']);
    	}

    	else
    		return response([], 405);
    }

    public function queueTypes()
    {
        return view('queue_types', [
            'title' => 'Queue Types',
            'queues' => QueueType::all()
        ]);
    }

    public function updateQueueType(QueueType $queue_type)
    {
        $colors_rule = 'in:red,orange,yellow,olive,green,teal,blue,violet,purple,pink,brown,grey,black';

        Validator::make($this->request->all(), [
                'type' => "bail|required|string|unique:queue_types,type,{$queue_type->queue_type_id},queue_type_id",
                'regular_color' => "bail|required|different:pod_color|$colors_rule",
                'pod_color' => "bail|required|different:regular_color|$colors_rule",
                'regular_queue_limit' => 'bail|required|integer|min:1|max:1000',
                'pod_queue_limit' => 'bail|required|integer|min:1|max:1000'
            ])->validate();

            $queue_type->type = $this->request->type;
            $queue_type->color_regular = $this->request->regular_color;
            $queue_type->color_pod = $this->request->pod_color;
            $queue_type->queue_limit_regular = $this->request->regular_queue_limit;
            $queue_type->queue_limit_pod = $this->request->pod_queue_limit;
            $queue_type->save();

            return back()->with('success', ['header' => 'Queue type updated successfully.']);
    }

    private function getResettedNumber($number, $limit)
    {
        while($number > $limit)
            $number -= $limit;

        return $number;
    }
}
