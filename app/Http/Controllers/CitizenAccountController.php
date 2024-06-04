<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Role;
use App\Services\AccountManagement\UserService;
use App\Services\Authentication\AuthService;
use App\Services\Notification\NotificationPusher;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CitizenAccountController extends Controller
{
    public function index(): View
    {
        $breadcrumb = [
            'list' => ['Menu', 'Penduduk', 'Data Penduduk'],
            'url' => ['dashboard', 'data-keluarga.index']
        ];
        return view('pages.data-akun.index', compact('breadcrumb'));
    }

    public function list(): JsonResponse
    {
        return response()->json([
            'code' => 200,
            'message' => 'Success',
            'timestamp' => now(),
            'data' => UserService::getDatatable()
        ], 200);
    }

    public function create()
    {
        $breadcrumb = [
            'list' => ['Menu', 'Penduduk', 'Akun Penduduk', 'Tambah Data Penduduk'],
            'url' => ['dashboard', 'data-akun.index', 'data-akun.create']
        ];
        return view('pages.data-akun.tambah.index', compact('breadcrumb'))->with([
            'role' => Role::where('role_name', '!=', 'Ketua RT')->get()
        ]);
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'nik' => [
                'required',
                'numeric',
                'digits:16',
                Rule::exists('penduduk')->where(function ($query) use ($request) {
                    $query->where('nik', $request->nik)
                        ->whereNull('user_id');
                }),
            ],
            'role_id' => 'required|exists:roles,role_id',
            'username' => 'required|string|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 422,
                    'timestamp' => now(),
                    'message' =>  $validator->errors()
                ], 422);
            }

            if ($validator->errors()->has('nik')) {
                NotificationPusher::error('Data Penduduk Tidak Ditemukan');
                return redirect()->back()->withInput();
            }

            NotificationPusher::error('Data Gagal Ditambahkan');
            return redirect()->back()->withInput()->withErrors($validator);
        }

        try {
            DB::beginTransaction();

            $user = UserService::create($request);
            Penduduk::where('nik', $request->nik)->update(['user_id' => $user->user_id]);
            DB::commit();
            if ($request->role_id === UserService::getRoleId('Ketua RT')) {
                UserService::changeRole(Auth::user()->user_id, 'Penduduk');
                $response = AuthService::logout($request);

                if (!$response) {
                    throw new AuthenticationException('Logout failed');
                }

                if ($request->is('api/*') || $request->wantsJson()) {
                    return response()->json([
                        'code' => 200,
                        'timestamp' => now(),
                        'message' => 'Logout success',
                    ], 200);
                }
                NotificationPusher::success('Hak akses berhasil ditransfer, Silahkan Login Kembali');
                return response()->redirectTo('/login');
            }

            if ($request->has('save_and_more')) {
                return redirect()->route('data-akun.create')->with(NotificationPusher::success('Data Berhasil Ditambahkan'));
            }

            return redirect()->route('data-akun.index')->with(NotificationPusher::success('Data Berhasil Ditambahkan'));
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 500,
                    'timestamp' => now(),
                    'message' => $e->getMessage()
                ], 500);
            }

            NotificationPusher::error('Data Gagal Ditambahkan');
            return redirect()->back()->withInput();
        }
    }


    public function show($id)
    {
        $breadcrumb = [
            'list' => ['Menu', 'Penduduk', 'Akun Penduduk', 'Detail Data Penduduk'],
            'url' => ['dashboard', 'data-akun.index', ['data-akun.show', $id]]
        ];
        return view('pages.data-akun.detail.index', compact('breadcrumb'))->with([
            'toolbar_id' => $id,
            'active' => 'detail',
            'toolbar_route' => [
                'detail' => route('data-akun.show', $id),
                'edit' => route('data-akun.edit', $id),
                'hapus' => route('data-akun.destroy', $id)
            ],
            'user' => UserService::find($id)->load('role', 'penduduk')
        ]);
    }

    public function edit($id)
    {
        $breadcrumb = [
            'list' => ['Menu', 'Penduduk', 'Akun Penduduk', 'Edit Data Penduduk'],
            'url' => ['dashboard', 'data-akun.index', ['data-akun.edit', $id]]
        ];
        return view('pages.data-akun.edit.index', compact('breadcrumb'))->with([
            'id' => $id,
            'toolbar_id' => $id,
            'active' => 'edit',
            'toolbar_route' => [
                'detail' => route('data-akun.show', $id),
                'edit' => route('data-akun.edit', $id),
                'hapus' => route('data-akun.destroy', $id)
            ],
            'role' => Role::all(),
            'user' => UserService::find($id)->load('role', 'penduduk')
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16',
            'role_id' => 'required|exists:roles,role_id',
            'username' => 'required|string|unique:users,username,' . $id . ',user_id',
            'email' => 'nullable|email|unique:users,email,' . $id . ',user_id',
            'password' => $request->filled('password') ? 'required|string|confirmed|min:8' : ''
        ]);

        if ($validator->fails()) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 422,
                    'timestamp' => now(),
                    'message' => 'Kesalahan Validasi',
                    'errors' => $validator->errors()
                ], 422);
            }
            NotificationPusher::error('Data Gagal Diubah');
            return redirect()->back()->withInput()->withErrors($validator);
        }
        try {
            DB::beginTransaction();
            UserService::update($id, $request, true);
            DB::commit();
            if ($request->role_id === UserService::getRoleId('Ketua RT') && Auth::user()->user_id !== $id){
                UserService::changeRole(Auth::user()->user_id, 'Penduduk');
                $response = AuthService::logout($request);

                if (!$response) {
                    throw new AuthenticationException('Logout failed');
                }

                if ($request->is('api/*') || $request->wantsJson()) {
                    return response()->json([
                        'code' => 200,
                        'message' => 'Logout success',
                        'timestamp' => now()
                    ], 200);
                }

                NotificationPusher::success('Hak akses berhasil ditransfer, Silahkan Login Kembali');
                return response()->redirectTo('/login');
            }

            NotificationPusher::success('Data Berhasil Diubah');
            return redirect()->route('data-akun.index');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'code' => 500,
                    'timestamp' => now(),
                    'message' => $e->getMessage()
                ], 500);
            }
            NotificationPusher::error('Data Gagal Diubah');
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            if (Auth::user()->user_id === $id) {
                throw new AuthenticationException('Tidak dapat menghapus akun sendiri');
            }
            $user = UserService::find($id)->load('penduduk');
            if ($user->penduduk->user_id === $id) {
                Penduduk::where('user_id', $id)->update(['user_id' => null]);
            }
            UserService::delete($id);
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Dihapus',
                'timestamp' => now(),
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'timestamp' => now(),
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
