<?php

namespace App\Http\Controllers\API;

use Image;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\UniversityProfile;
use App\Models\UserOverallProfile;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;

class UserAPIController extends Controller
{
    /**
     * Shows all users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsers()
    {
        return Datatables::of(User::where('id', '!=', auth('api')->user()->id)->get())
            ->removeColumn('is_verified')
            ->removeColumn('is_admin')
            ->removeColumn('is_blocked')
            ->removeColumn('email_verified_at')
            ->addColumn('verified', function($user) {
                if ($user->is_verified) return '<span style="color: green">Verified</span>';
                return '<span style="color: red">Not Verified</span>';
            })
            ->addColumn('admin', function($user) {
                if ($user->is_admin) return '<span style="color: green">Admin</span>';
                return '<span style="color: red">Not Admin</span>';
            })
            ->addColumn('banned', function($user) {
                if ($user->is_blocked) return '<span style="color: red">Banned</span>';
                return '<span style="color: green">Not Banned</span>';
            })
            ->addColumn('action', function ($user) {
                $attr = '<div class="btn-group" role="group" aria-label="Second group">';
                $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-primary" id="view-user" data-id="' . $user->id . '"><i class="fa fa-eye"></i> View</a>';
                if ($user->is_blocked) $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-success" id="unblock-user" data-id="' . $user->id . '"><i class="fa fa-user"></i> Unblock</a></div>';
                else $attr .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger" id="block-user" data-id="' . $user->id . '"><i class="fa fa-user-slash"></i> Block</a></div>';

                return $attr;
            })
            ->rawColumns(['verified', 'admin', 'banned', 'action'])
            ->make(true);
    }

    /**
     * Get user details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(int $id)
    {
        $user = User::findOrFail($id);

        return response($user, 200);
    }

    /**
     * Get current user details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentUser()
    {
        $user = auth('api')->user();

        return response($user, 200);
    }

    /**
     * Get complete user details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserCompleteProfile(int $id)
    {
        $user = UserOverallProfile::findOrFail($id);

        return response($user, 200);
    }

    public function getPosts(int $id)
    {
        $posts = User::findOrFail($id)->posts()->latest();

        return response($posts->paginate(3), 200);
    }

    /**
     * Verifies user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id != auth('api')->user()->id && auth('api')->user()->is_admin) {
            $user->update([
                'is_verified' => true,
            ]);
        }

        return response(null, 200);
    }

    /**
     * Blocks user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function blockUser(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id != auth('api')->user()->id && auth('api')->user()->is_admin) {
            $user->update([
                'is_blocked' => true,
            ]);
        }

        return response(null, 200);
    }

    /**
     * Unblocks user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unblockUser(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id != auth('api')->user()->id && auth('api')->user()->is_admin) {
            $user->update([
                'is_blocked' => false,
            ]);
        }

        return response(null, 200);
    }

    public function uploadProfilePicture(Request $request)
    {
        $user = auth('api')->user();

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $filename = $file->getClientOriginalName();

            $filename = pathinfo($filename, PATHINFO_FILENAME) . '_' . time() . '.' . pathinfo($filename, PATHINFO_EXTENSION);

            $save_path = 'storage/' . $user->id . '/profiles';

            if (!file_exists($save_path)) {
                mkdir($save_path, 666, true);
            }

            Image::make($file)->save( public_path($save_path . '/' . $filename) );

            $userProfile = Profile::firstOrNew(array('user_id' => $user->id));

            $userProfile->user_id = $user->id;
            $userProfile->profile_picture_url = '/' . $save_path . '/' . $filename;

            $userProfile->save();
        }

        return response(null, 200);
    }

    public function updateBio(Request $request) {
        $user = auth('api')->user();

        $userProfile = Profile::firstOrNew(array('user_id' => $user->id));

        $userProfile->user_id = $user->id;
        $userProfile->bio = $request->bio;
        $userProfile->save();

        return response(null, 200);
    }

    public function updatePassword(ChangePasswordRequest $request) {
        $validated = $request->validated();

        $user = auth('api')->user();

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response(null, 200);
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'birth_date' => 'required|date|date_format:Y-m-d|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'mobile_number' => 'required',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        ]);

        $userProfile = Profile::firstOrNew(array('user_id' => auth('api')->user()->id));

        $userProfile->user_id = auth('api')->user()->id;
        $userProfile->birth_date = Carbon::createFromFormat('Y-m-d', $request->birth_date);
        $userProfile->gender = $request->gender;
        $userProfile->mobile_number = $request->mobile_number;
        $userProfile->blood_group = $request->blood_group;

        $userProfile->save();

        return response(null, 200);
    }

    public function updateUniversityProfile(Request $request) {
        $userProfile = UniversityProfile::firstOrNew(array('user_id' => auth('api')->user()->id));

        if ($userProfile->is_teacher) {
            $request->validate([
                'department' => 'required|string|max:199',
            ]);

            $userProfile->user_id = auth('api')->user()->id;
            $userProfile->department = $request->department;
        }
        else {
            $request->validate([
                'student_id' => 'required|string|max:20',
                'department' => 'required|string|max:199',
                'ongoing_degree' => 'required|string|max:199',
                'session' => 'required|string|max:199',
                'alloted_hall' => 'required|string|max:199',
            ]);

            $userProfile->user_id = auth('api')->user()->id;
            $userProfile->student_id = $request->student_id;
            $userProfile->department = $request->department;
            $userProfile->ongoing_degree = $request->ongoing_degree;
            $userProfile->session = $request->session;
            $userProfile->alloted_hall = $request->alloted_hall;
        }

        $userProfile->save();

        return response(null, 200);
    }

    public function updateStudentFromTeacher($id) {
        $user = UniversityProfile::firstOrNew(array('user_id' => $id));

        $user->user_id = $id;

        if ($user->user_id != auth('api')->user()->id && auth('api')->user()->is_admin) {
            $user->is_teacher = false;
        }

        $user->save();

        return response(null, 200);
    }

    public function updateTeacherFromStudent($id) {
        $user = UniversityProfile::firstOrNew(array('user_id' => $id));

        $user->user_id = $id;

        if ($user->user_id != auth('api')->user()->id && auth('api')->user()->is_admin) {
            $user->is_teacher = true;
        }

        $user->save();

        return response(null, 200);
    }
}
