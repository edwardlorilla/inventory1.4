<?php

namespace App\Http\Controllers;

use App\Category;
use App\Equipment;
use App\Http\Requests\AdminCategoriesRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

class AdminCategoriesController extends Controller
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
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCategoriesRequest $request)
    {

        Category::create($request->all());
        return redirect(route('admin.categories.index'));
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {

        if (is_null($id) == !$request->has('delete')) {
            session()->flash('error', 'no record');
            return back();
        } elseif (is_null($id) == $request->has('delete')) {
            foreach ($request->delete as $id) {
                Category::findOrFail($id)->delete();
            }
        } elseif (!is_null($id)) {
            session()->flash('success', 'Successfully Deleted');
        }
        return redirect(route('admin.categories.index'));
    }
}
