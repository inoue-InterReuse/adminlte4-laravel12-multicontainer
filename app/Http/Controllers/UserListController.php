<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserListController extends Controller
{
  use AuthorizesRequests, ValidatesRequests;

  public function index()
  {
    $userDatas = $this->getDatas();
    return view('settings.user-list', compact('userDatas'));
  }

  function updateToCreate(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'  => 'required',
      'email' => 'required|email',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    } else {
      User::updateOrCreate(
        ['email' => $request->input('email')],
        [
          'name'     => $request->input('name'),
          'email'    => $request->input('email'),
          'password' => bcrypt('teriyaki'),
        ]
      );

      $userDatas = $this->getDatas($request);
      Log::info('userDatas', [
        'userDatas' => $userDatas,
      ]);
      $html = view('settings.user-list-data', compact('userDatas'))->render();

      return response()->json([
        'success' => true,
        'html' => $html
      ]);
    }
  }

  function detail(Request $request)
  {
    $userData = User::where('id', $request->input('id'))->first();
    Log::info('userData', [
      'userData' => $userData,
    ]);
    return response()->json(['userData' => $userData]);
  }

  function getData(Request $request)
  {

    Log::info('getData', [
      'request' => $request->all(),
    ]);

    $userDatas = $this->getDatas($request);

    Log::info('userDatas', [
      'userDatas' => $userDatas,
    ]);

    $html = view('settings.user-list-data', compact('userDatas'))->render();

    return response()->json([
      'success' => true,
      'html' => $html
    ]);
  }

  private function getDatas(Request $request = null)
  {

    $request = $request ?? request();

    Log::info('getDatas', [
      'request' => $request->all(),
    ]);

    $query = User::query();

    // ページネーション数
    $paginateNum = $request->input('paginateNum', 20);

    // 並び替え処理（許可されたカラムのみ）
    $sortableColumns = ['id'];
    [$column, $direction] = explode('-', $request->input('sortBy', 'id-asc')) + ['id', 'asc'];;
    if (in_array($column, $sortableColumns) && in_array($direction, ['asc', 'desc'])) {
      $query->orderBy($column, $direction);
    } else {
      $query->orderBy('id', 'asc'); // フォールバック
    }

    // フィルター条件
    if ($request->filled('search-name')) {
      $query->where('name', 'LIKE', '%' . $request->input('search-name') . '%');
    }

    if ($request->filled('search-email')) {
      $query->where('email', 'LIKE', '%' . $request->input('search-email') . '%');
    }

    return $query->paginate($paginateNum);
  }
}
