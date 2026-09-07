<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\LocationRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLocationRequest;
use App\Models\Location;

class LocationController extends Controller
{
    public function __construct(
        protected LocationRepositoryInterface $locationRepo
    ) {}

    public function index()
    {
        $locations = $this->locationRepo->paginate(10);
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(StoreLocationRequest $request)
    {
        $this->locationRepo->create($request->validated());
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi ditambahkan.');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(StoreLocationRequest $request, Location $location)
    {
        $this->locationRepo->update($location, $request->validated());
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi diperbarui.');
    }

    public function destroy(Location $location)
    {
        $this->locationRepo->delete($location);
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi dihapus.');
    }
}
