<?php

namespace App\Http\Controllers;

use App\Borrow;
use App\Category;
use App\Equipment;
use App\Http\Requests\EquipmentStore;
use App\NonConsumable;
use App\Photo;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminEquipmentController extends Controller
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

        $equipments = Equipment::all();

        $users = User::lists('name', 'id')->all();
        $borrows = Borrow::all();


        $equipmentdrop = Equipment::lists('item', 'id')->all();

        return view('admin.equipments.index', compact('equipments', 'equipmentdrop', 'borrows', 'borrow', 'users', 'findusers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::lists('name', 'id')->all();
        return view('admin.equipments.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (User::find($request->input('name'))) {
            $users = User::find($request->input('name'));

            $borrow = new Borrow([
                'user_id' => Auth::user()->id,
                'borrowedby_id'=> $users->id
            ]);


            if ($request->originalQuantity) {
                foreach ($request->originalQuantity as $key => $value) {
                    $nonconsumableItem = Equipment::findOrfail($request->borrows[$key]);

                    if (array_key_exists($key, $request->quantity) && array_key_exists($key, $request->originalQuantity) && array_key_exists($key, $request->borrows))
                        $item = NonConsumable::create(['quantity' => ($request->originalQuantity[$key] - $request->quantity[$key]), 'item' => $request->borrows[$key], 'status' => 0, 'outOfStock' => 0]);

                    $quantityBorrow = NonConsumable::create(['quantity' => $request->quantity[$key], 'item' => $request->borrows[$key], 'status' => 1]);
                    $itemid = $item->id;
                    
                    $quantityBorrowId[] = $quantityBorrow->id;

                    if (!($request->originalQuantity[$key] - $request->quantity[$key] <= 0)) {

                        Equipment::where('id', $request->borrows[$key])->update(['status' => 1, 'nonconsumable_id' => $itemid, 'consumable' => 1]);

                    } else {

                        if (($request->originalQuantity[$key] - $request->quantity[$key]) > 0) {
                            Equipment::where('id', $request->borrows[$key])->update(['status' => 0, 'nonconsumable_id' => $itemid, 'consumable' => 1]);
                        } else {
                            Equipment::where('id', $request->borrows[$key])->update(['status' => 0, 'nonconsumable_id' => $itemid, 'consumable' => 1, 'outOfStock' => 1, 'hasQuantity' => 0]);
                        }
                    }

                    foreach ($quantityBorrowId as $borrowId) {
                        NonConsumable::where('id', $borrowId)->update(['status' => 1, 'name' => $nonconsumableItem->item]);
                        $borrow->nonconsumable_id = $borrowId;

                    }


                }

            } else {

                foreach ($request->non as $key => $value) {
                    NonConsumable::create(['quantity' => -1, 'item' => $request->non[$key], 'status' => 0,]);
                    foreach ($request->non as $id) {
                        Equipment::where('id', $id)->update(['status' => 0, 'nonconsumable_id' => $request->non[$key], 'consumable' => 0]);
                    }
                }

            }

            $borrow->save();

            if ($request->originalQuantity) {
                $borrow->equipments()->sync($request->borrows, false);
                $borrow->names()->sync([$request->input('name')], false);
                $borrow->nonconsumables()->sync($quantityBorrowId, false);
            } else {
                session()->flash('nonconsumables', 'Successful');
                $borrow->equipments()->sync($request->non, false);
            }
            session()->flash('success', 'Borrowed successfully save!');
            return Redirect::route('admin.borrow.index');
        } else {

            $this->validate($request, [
                'item' => 'required',
                'description' => 'required',
                'status' => 'required',
                'category_id' => 'required',
                'photo_id' => 'required',
            ]);
            $input = $request->all();

            $user = Auth::user();
            if ($file = $request->file('photo_id')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['file' => $name]);
                $input['photo_id'] = $photo->id;
            }
            $input['consumable'] = 1;
            if ($request->nonconsumable_id) {
                $quantity = $request->nonconsumable_id;
                $nonconsumable = NonConsumable::create(['quantity' => $quantity]);
                $input['nonconsumable_id'] = $nonconsumable->id;

            } else {
                session()->flash('borrows', 'The Equipment was successfully save!');
            }
            $user->equipment()->create($input);
            session()->flash('success', 'The Equipment was successfully save!');

            return Redirect::route('admin.equipment.index');

        }


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
        $categories = Category::lists('name', 'id')->all();
        $equipments = Equipment::findOrfail($id);

        return view('admin.equipments.edit', compact('equipments', 'categories'));
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

        $input = $request->all();
        if ($file = $request->file('photo_id')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file' => $name]);
            $input['photo_id'] = $photo->id;
        }

        $input['consumable'] = 1;

        if ($request->nonconsumable_id) {

            $quantity = $request->nonconsumable;
            NonConsumable::where('id', $request->nonconsumable_id)->update(['quantity' => $quantity]);
            $input['outOfStock'] = 0;
        } else {
            session()->flash('borrows', 'The Equipment was successfully save!');
        }


        session()->flash('success', 'The Equipment was successfully save!');


        Auth::user()->equipment()->whereId($id)->first()->update($input);
        return redirect(route('admin.equipment.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
        if (is_null($id) == !$request->has('no')) {
            session()->flash('error', 'no record');
            return back();
        } elseif (is_null($id) == $request->has('no')) {
            $str = trim($request->no, ",");

            $ids = explode(",", $str);
            $intArray = array_map(
                function ($value) {
                    return (int)$value;
                },
                $ids
            );
            foreach ($intArray as $id) {
                $equipment = Equipment::findOrFail($id);
                if (!($equipment->photo_id == 0)) {
                    unlink(public_path() . $equipment->photo->file);
                }
                $equipment->delete();
            }
        } elseif (!is_null($id)) {
            session()->flash('success', 'Successfully Deleted');
        }
        return redirect(route('admin.equipment.index'));
    }
}
