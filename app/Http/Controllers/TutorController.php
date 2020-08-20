<?php

namespace App\Http\Controllers;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $data = $this->redis->zRange(
            'tutor',
            0,
            -1,
            true
        );

        return view('index')->with([
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = $this->customValidate($request);

        /**
         * Return an error
         */
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $this->redis->zAdd(
            'tutor',
            ['NX'],
            $this->redis->zCard('tutor') + 1,
            json_encode($request->except('_token'))
        );

        return redirect()->route('tutors.index');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data = $this->redis->zRangeByScore(
            'tutor',
            $id,
            $id
        );

        return view('edit')->with([
            'data' => $data[0],
            'id' => $id,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = $this->customValidate($request);

        /**
         * Return an error
         */
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $this->removeData($id);
        $this->redis->zAdd(
            'tutor',
            ['NX'],
            $id,
            json_encode($request->except(['_token', '_method']))
        );

        return redirect()->route('tutors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $this->removeData($id);

        return redirect()->route('tutors.index');
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
