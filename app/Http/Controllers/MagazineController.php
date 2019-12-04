<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Magazine;

class MagazineController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = (Auth::user());
        $magazines = $user->magazines()->orderBy('created_at', 'desc')->get();
        return view('admin.magazines.index', ['magazines' => $magazines]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.magazines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'book' => 'required|file|mimes:pdf|max:20000',
        ]);
        $request->user()->magazines()->create([
            'name' => $request->name,
            'image' => $request->image,
            'book' => $request->book,
        ]);

        $orginName = $request->file('image')->getClientOriginalName();
        $fileName = pathinfo($orginName, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $fileName = $fileName . '_' . time() . '.' . $extension;

        $orginName1 = $request->file('book')->getClientOriginalName();
        $fileName1 = pathinfo($orginName1, PATHINFO_FILENAME);
        $extension1 = $request->file('book')->getClientOriginalExtension();
        $fileName1 = $fileName1 . '_' . time() . '.' . $extension1;

        request()->image->move(public_path('images'), $fileName);
        request()->book->move(public_path('books'), $fileName1);

        return redirect(route('magazines.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Magazine $magazine) {
        return view('admin.magazines.edit', ['magazine' => $magazine]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Magazine $magazine) {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $magazine->name = $request->name;
        $magazine->save();

        return redirect(route('magazines.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Magazine $magazine) {
        $magazine->delete();
        return redirect(route('magazines.index'));
    }

}
