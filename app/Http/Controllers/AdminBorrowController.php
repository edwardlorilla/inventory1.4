<?php

namespace App\Http\Controllers;

use App\Borrow;
use App\Equipment;
use App\NonConsumable;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Mockery\CountValidator\Exception;

class AdminBorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $borrows = Borrow::all();
        return view('admin.borrows.index', compact('borrows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->return as $id) {
            $borrow = Borrow::find($id);
            foreach ($borrow->equipments as $equipment) {
                Equipment::where('id', $equipment->id)->update(['status' => 1, 'consumable' => 1, 'outOfStock' => 0, 'nonconsumable_id' => null]);
            }

            Borrow::destroy($request->return);
        }
        session()->flash('RETURN', 'The Equipment is successfully return');
        return Redirect::route('admin.equipment.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */


    public function confirm($id)
    {

    }


    public function destroy(Request $request, $id = null)
    {
        if (is_null($id) == !$request->has('delete')) {
            session()->flash('error', 'no record');
            return back();
        } elseif (is_null($id) == $request->has('delete')) {
            foreach ($request->delete as $id) {
                Borrow::findOrFail($id)->delete();
            }
        } elseif (!is_null($id)) {

            session()->flash('success', 'Successfully Deleted');
        }
        return back();
    }
}
