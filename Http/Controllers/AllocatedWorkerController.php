<?php

namespace Septech\Snowflake\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Septech\Snowflake\AllocatedWorker;

class AllocatedWorkerController
{
    use ValidatesRequests;

    public function allocate(Request $request)
    {
        $data = $this->validate($request, [
            'machine_id' => 'required'
        ]);

        $instanceId = AllocatedWorker::allocateFor($data['machine_id']);

        return response()->json([
            'ok' => true,
            'data' => [
                'worker_id' => AllocatedWorker::workerId($instanceId),
                'data_center_id' => AllocatedWorker::dataCenterId($instanceId),
            ],
        ]);
    }

    public function release(Request $request)
    {
        $data = $this->validate($request, [
            'machine_id' => 'required'
        ]);

        AllocatedWorker::release($data['machine_id']);

        return response()->json([
            'ok' => true
        ]);
    }
}
