<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            $data = $request->only('name');
            //$data['sequence'] = FacilityType::count() + 1;

            Account::create($data);

            return respondSuccess('SUCCESS');
        } catch (\Exception $e) {
            return respondError('FAIL');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        if ($request->expectsJson()) {
            return Account::paginate(request('limit') ?? 10);
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            Account::findOrFail($id)->update($request->only('name'));

            return respondSuccess('UPDATE_SUCCESS');
        } catch (\Exception $e) {
            return respondError('UPDATE_FAIL');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (Account::findOrFail($id)->delete()) {
                return respondSuccess('DELETE_SUCCESS');
            }
        } catch (\Exception $e) {
            return respondError('DELETE_FAIL');
        }
    }
}
