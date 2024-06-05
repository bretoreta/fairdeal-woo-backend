<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Showrooms\StoreRequest;
use App\Http\Requests\Admin\Showrooms\UpdateRequest;
use App\Models\Showroom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowroomsController extends Controller
{
    public function index () {
        return Inertia::render('Admin/Showrooms/Index', [
            'showrooms' => Showroom::withCount('users')->latest()->paginate()
        ]);
    }

    public function create () {
        return Inertia::render('Admin/Showrooms/Create');
    }

    public function store (StoreRequest $request) {
        try {
            Showroom::create($request->validated());

            return redirect(route('admin.showrooms.index'))->with('message', [
                'type' => 'success',
                'message' => 'Showroom Has Been Created Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function update (UpdateRequest $request, Showroom $showroom) {
        try {
            $showroom->update($request->validated());

            return redirect(route('admin.showrooms.index'))->with('message', [
                'type' => 'success',
                'message' => 'Showroom Has Been Updated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function activate (Showroom $showroom) {
        try {
            $showroom->update(['active_promo' => true]);

            return redirect(route('admin.showrooms.index'))->with('message', [
                'type' => 'success',
                'message' => 'Showroom Has Been Activated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function deactivate (Showroom $showroom) {
        try {
            $showroom->update(['active_promo' => false]);

            return redirect(route('admin.showrooms.index'))->with('message', [
                'type' => 'success',
                'message' => 'Showroom Has Been Deactivated Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function delete (Showroom $showroom) {
        try {
            $showroom->delete();

            return redirect(route('admin.showrooms.index'))->with('message', [
                'type' => 'success',
                'message' => 'Showroom Has Been Deleted Successfully'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }
}
