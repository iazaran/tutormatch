<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redis;

class TutorController extends Controller
{
    private Redis $redis;

    /**
     * Instantiate a new controller instance.
     * Building a new Redis instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis');
    }

    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->redis->zRange(
            'tutor',
            0,
            -1,
            true
        );

        /**
         * Make a pretty array to convert to JSON
         */
        $result = [];
        foreach ($data as $key => $val) {
            $result[] = [
                'id' => $val,
                'title' => json_decode($key)->title,
                'description' => json_decode($key)->description,
                ];
        }

        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = $this->customValidate($request);

        /**
         * Return an error
         */
        if ($validator->fails()) {
            return response()->json([
                'status'=>'Error',
                'message' => 'Empty fields!',
            ], 400);
        }

        $this->redis->zAdd(
            'tutor',
            ['NX'],
            $this->redis->zCard('tutor') + 1,
            json_encode($request->except('_token'))
        );

        return response()->json([
            'status'=> 'Success',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = $this->customValidate($request);

        /**
         * Return an error
         */
        if ($validator->fails()) {
            return response()->json([
                'status'=>'Error',
                'message' => 'Empty fields!',
            ], 400);
        }

        $this->removeData($id);
        $this->redis->zAdd(
            'tutor',
            ['NX'],
            $id,
            json_encode($request->except(['_token', '_method']))
        );

        return response()->json([
            'status'=> 'Success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->removeData($id);

        return response()->json([
            'status'=> 'Success',
        ], 200);
    }

    /**
     * Validate inputs
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function customValidate(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'required|min:8',
        ]);
    }

    /**
     * Remove specific data
     *
     * @param int $id
     * @return int
     */
    private function removeData(int $id)
    {
        $data = $this->redis->zRangeByScore(
            'tutor',
            $id,
            $id
        );

        return $this->redis->zRem(
            'tutor',
            $data[0]
        );
    }
}
