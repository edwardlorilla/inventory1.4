<?php

namespace App\Http\Controllers;

use App\Borrow;
use App\Category;
use App\Equipment;
use App\Http\Requests\EquipmentStore;
use App\Location;
use App\NonConsumable;
use App\Photo;
use App\Reservation;
use App\Stockin;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\Yaml\Tests\B;

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

    public function index(Equipment $equipments)
    {
        $equipments = $equipments->orderBy('item', 'asc')->get();
//        $equipments = Equipment::all();

        $users = User::lists('name', 'id')->all();
        $locations = Location::lists('room', 'id')->all();
        $borrows = Borrow::all();


        $equipmentdrop = Equipment::lists('item', 'id')->all();

        return view('admin.equipments.index', compact('equipments', 'equipmentdrop', 'borrows', 'borrow', 'users', 'findusers', 'locations'));

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

//dd($request);
        if ($request->checkin) {
            $str = trim($request->no, ",");

            $ids = explode(",", $str);
            $intArray = array_map(
                function ($value) {
                    return (int)$value;
                },
                $ids

            );


            foreach ($intArray as $key => $value) {
                $stockins = Stockin::create(['equipment_id' => $intArray[$key], 'quantity' => $request->checkin[$key], 'previousQuantity' => $request->checkinoriginalQuantity[$key], 'total' => $request->checkinoriginalQuantity[$key] + $request->checkin[$key]]);
                Equipment::where('id', $intArray[$key])->update(['updated_at' => Carbon::now(), 'status' => 1, 'outOfStock' => 0, 'stockin_id' => $stockins->id]);

            }


        }

        if ($request->reservationTime) {
            $str = trim($request->reservationTime, " - ");
            $reservationtimeId = explode(" - ", $str);
            $reservationtimeArray = array_map(
                function ($value) {
                    return $value;
                },
                $reservationtimeId
            );

            $reservation = new Reservation([
                'start_time' => $reservationtimeArray[0],
                'end_time' => $reservationtimeArray[1]
            ]);
        }
        if (User::find($request->input('name'))) {
            $users = User::find($request->input('name'));

            $borrow = new Borrow([
                'user_id' => Auth::user()->id,
                'borrowedby_id' => $users->id,
                'location_id' => $request->location_id,

            ]);


            if ($request->originalQuantity) {
                foreach ($request->originalQuantity as $key => $value) {


                    if (array_key_exists($key, $request->quantity) && array_key_exists($key, $request->originalQuantity) && array_key_exists($key, $request->borrows))


                        if (!($request->originalQuantity[$key] - $request->quantity[$key] <= 0)) {

                            Equipment::where('id', $request->borrows[$key])->update(['status' => 1, 'consumable' => 1]);

                        }
                    if ($request->originalQuantity[$key] - $request->quantity[$key] == 0) {
                        Equipment::where('id', $request->borrows[$key])->update(['outOfStock' => 1, 'status' => 0]);
                    }
                    $StockinString = Equipment::findOrfail($request->borrows[$key])->stockin_id;
                    $StockinId = explode(",", $StockinString);
                    $stockinsArray = array_map(
                        function ($value) {
                            return $value;
                        },
                        $StockinId
                    );

                    if ($request->originalQuantity[$key] - $request->quantity[$key] >= 1) {


                        $stockins = Stockin::create(['equipment_id' => $request->borrows[$key], 'quantity' => $request->quantity[$key], 'previousQuantity' => $request->originalQuantity[$key], 'total' => $request->originalQuantity[$key] - $request->quantity[$key], 'deduction' => $request->quantity[$key]]);


                        Equipment::where('id', $request->borrows[$key])->update(['updated_at' => Carbon::now(), 'status' => 1, 'outOfStock' => 0, 'stockin_id' => $stockins->id]);
                    } else {
                        $stockins = Stockin::create(['equipment_id' => $request->borrows[$key], 'quantity' => $request->quantity[$key], 'previousQuantity' => $request->originalQuantity[$key], 'total' => $request->originalQuantity[$key] - $request->quantity[$key], 'deduction' => $request->quantity[$key]]);
                        Equipment::where('id', $request->borrows[$key])->update(['updated_at' => Carbon::now(), 'status' => 0, 'outOfStock' => 1, 'stockin_id' => $stockins->id]);

                    }

                }

            } else {

                if ($request->non) {
                    $borrow->status = 0;
                    foreach ($request->non as $key => $value) {
                        NonConsumable::create(['quantity' => -1, 'item' => $request->non[$key], 'status' => 0,]);
                        foreach ($request->non as $id) {
                            Equipment::where('id', $id)->update(['status' => 0, 'nonconsumable_id' => $request->non[$key], 'consumable' => 0, 'hasBorrow' => 1]);
                        }
                    }
                } else {
                    if ($request->reservationNo) {
                        $reservationString = trim($request->reservationNo, ",");
                        $reservationId = explode(",", $reservationString);

                        $reservationArray = array_map(
                            function ($value) {
                                return $value;
                            },
                            $reservationId
                        );
                        foreach ($reservationArray as $key => $value) {
                            NonConsumable::create(['quantity' => -1, 'item' => $reservationArray[$key], 'status' => 0,]);
                            foreach ($reservationArray as $id) {
                                Equipment::where('id', $id)->update(['status' => 0, 'nonconsumable_id' => -2, 'consumable' => 0, 'hasReservation' => 1, 'reservation_id' => $reservationArray[$key]]);
                            }

                        }
                    }


                }

            }
            if ($request->reservationTime) {
                $reservation->save();
            }
            $borrow->save();

            if ($request->originalQuantity) {
                $borrow->equipments()->sync($request->borrows, false);
                $borrow->names()->sync([$request->input('name')], false);
                $borrow->stockins()->sync($stockinsArray, false);
                session()->flash('success', 'Borrowed successfully save!');
                return Redirect::route('admin.borrow.index');
            } elseif ($request->reservationNo) {
                $reservation->equipments()->sync($reservationArray, false);
                return Redirect::route('admin.borrow.index');
            } else {
                session()->flash('nonconsumables', 'Successful');
                $borrow->equipments()->sync($request->non, false);
                return Redirect::route('admin.borrow.index');
            }

        } else {
            $this->validate($request, ['item' => 'required',
                'description' => 'required',
                'status' => 'required',
                'category_id' => 'required',]);
            $input = $request->all();

            $user = Auth::user();
            if ($file = $request->file('photo_id')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $photo = Photo::create(['file' => $name]);
                $input['photo_id'] = $photo->id;
            }
            if ($request->consumable == 0) {
                $input['consumable'] = 0;
                $input['hasQuantity'] = 0;
                $input['hasBorrow'] = 0;
            }

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
    public
    function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
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
    public
    function update(Request $request, $id)
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

        if ($request->user_id == Auth::user()->id) {
            Auth::user()->equipment()->whereId($id)->first()->update($input);
        } else {

        }


        return redirect(route('admin.equipment.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Request $request, $id = null)
    {
        dd($request);
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
