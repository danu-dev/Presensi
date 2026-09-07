<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceResource;
use App\Http\Resources\UserResource;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiController extends Controller
{
    public function user(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    public function attendances(Request $request): AnonymousResourceCollection
    {
        $attendances = Attendance::with(['location', 'room', 'user'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(15);

        return AttendanceResource::collection($attendances);
    }
}
