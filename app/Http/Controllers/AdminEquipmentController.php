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
        $users = User::lists('name', 'id')->all();
        $borrows = Borrow::all();

        $equipments = Equipment::all()->where('status', 1);

        $equipmentdrop = Equipment::lists('item', 'id')->all();

        return view('admin.equipments.index', compact('equipments', 'equipmentdrop', 'borrows', 'borrow', 'borrows2', 'users'));

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
//        dd($request);
        if (User::find($request->input('name'))) {
            $users = User::find($request->input('name'));

            $borrow = new Borrow([
                'name' => $users->name,
                'description' => $users->email,
                'user_id' => Auth::user()->id,
            ]);

            foreach ($request->originalQuantity as $key => $value) {
                if (array_key_exists($key, $request->quantity) && array_key_exists($key, $request->originalQuantity) && array_key_exists($key, $request->borrows))
                    $item = NonConsumable::create(['quantity' => ($request->originalQuantity[$key] - $request->quantity[$key]), 'item' => $request->borrows[$key], 'status' => 0]);
                $quantityBorrow = NonConsumable::create(['quantity' => $request->quantity[$key], 'item' => $request->borrows[$key], 'status' => 1]);
                $itemid = $item->id;
                $quantityBorrowId[] = $quantityBorrow->id;

//                dd($request->originalQuantity[$key] - $request->quantity[$key]);

                if (!($request->originalQuantity[$key] - $request->quantity[$key]) == 0) {
                    foreach ($request->borrows as $id) {
                        Equipment::where('id', $id)->update(['status' => 1, 'nonconsumable_id' => $itemid]);
                    }

                }else{
                    foreach ($request->borrows as $id) {
                        Equipment::where('id', $id)->update(['status' => 0, 'nonconsumable_id' => $itemid]);
                    }
                    
                }

                foreach ($quantityBorrowId as $borrowId) {
                    NonConsumable::where('id', $borrowId)->update(['status' => 1, 'currentquantity' => $request->originalQuantity[$key] - $request->quantity[$key] ]);
                }

            }

//            $quantityBorrowId
//                foreach ($request->borrows as $id) {
//                    Equipment::where('id', $id)->update(['status' => 0]);
//                }


            $borrow->save();
            $borrow->equipments()->sync($request->borrows, false);
            $borrow->nonconsumables()->sync($quantityBorrowId, false);
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
            if ($request->nonconsumable_id) {
                $quantity = $request->nonconsumable_id;
                $nonconsumable = NonConsumable::create(['quantity' => $quantity]);
                $input['nonconsumable_id'] = $nonconsumable->id;
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
        //
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
                unlink(public_path() . $equipment->photo->file);
                $equipment->delete();
            }
        } elseif (!is_null($id)) {
            session()->flash('success', 'Successfully Deleted');
        }
        return redirect(route('admin.equipment.index'));
    }
}
