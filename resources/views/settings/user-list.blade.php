@extends('layouts.app')

@section('title')
  設定
@endsection

@section('content')
  <!--begin::App Main-->
  <main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header py-2">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <div class="row justify-content-between align-items-center">
          <div class="col-auto">
            <h4 class="mb-0">ユーザーリスト</h4>
          </div>
          <div class="col-auto d-flex align-items-center gap-3">

            {{-- 表示件数 --}}
            <div class="d-flex align-items-center">
              <label for="paginate-num" class="form-label mb-0 me-2" style="font-size: 14px;">表示件数：</label>
              <select class="form-select form-select-sm w-auto" id="paginate-num" name="paginate-num">
                <option value="20" selected>20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="500">500</option>
              </select>
            </div>

            {{-- 表示順 --}}
            <div class="d-flex align-items-center">
              <label for="sortBy" class="form-label mb-0 me-2" style="font-size: 14px;">表示：</label>
              <select class="form-select form-select-sm w-auto" id="sort-by" name="sort-by">
                <option value="id-asc" selected>ID 昇順</option>
                <option value="id-desc">ID 降順</option>
              </select>
            </div>

            {{-- ボタン --}}
            <button type="button" class="btn btn-pastel-blue btn-sm w-120" id="show-search-modal">検 索</button>
            <button type="button" class="btn btn-pastel-red btn-sm w-120" id="show-create-modal">新規登録</button>
          </div>
        </div>
        <!--end::Row-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
          <div id="user-list-table">
            @include('settings.user-list-data')
          </div>
        </div>
        <!-- /.row (main row) -->
      </div>
      <!--end::Container-->
    </div>
    <!--end::App Content-->
  </main>
  <!--end::App Main-->
  <script src="{{ asset_version('js/settings/user-list.js') }}"></script>
@endsection

<!-- create update modal -->
<div class="modal fade" id="uc-modal" tabindex="-1" aria-labelledby="uc-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">

      <!-- モーダルヘッダー -->
      <div class="modal-header">
        <h5 class="modal-title" id="uc-modal-label">新規登録</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
      </div>

      <!-- モーダルボディ -->
      <div class="modal-body">
        <div class="row border-top bg-light">
          <div class="col-4 d-flex align-items-center">氏名</div>
          <div class="col-8 py-2">
            <input type="text" id="name" data-field="name" class="form-control">
            <small class="error-text text-danger d-none" id="name-error"></small>
          </div>
        </div>
        <div class="row border-top border-bottom">
          <div class="col-4 d-flex align-items-center">メールアドレス</div>
          <div class="col-8 py-2">
            <input type="email" id="email" data-field="email" class="form-control">
            <small class="error-text text-danger d-none" id="email-error"></small>
          </div>
        </div>
      </div>

      <!-- モーダルフッター -->
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary w-100" id="create-data">新規登録</button>
      </div>
    </div>
  </div>
</div>

<!-- search modal -->
<div class="modal fade" id="search-modal" tabindex="-1" aria-labelledby="search-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">

      <!-- モーダルヘッダー -->
      <div class="modal-header">
        <h5 class="modal-title" id="search-modal-label">検索</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
      </div>

      <!-- モーダルボディ -->
      <div class="modal-body">
        <div class="row border-top bg-light">
          <div class="col-4 d-flex align-items-center">氏名</div>
          <div class="col-8 py-2">
            <input type="text" id="search-name" data-search="search-name" class="form-control">
          </div>
        </div>
        <div class="row border-top border-bottom">
          <div class="col-4 d-flex align-items-center">メールアドレス</div>
          <div class="col-8 py-2">
            <input type="email" id="search-email" data-search="search-email" class="form-control">
          </div>
        </div>
      </div>

      <!-- モーダルフッター -->
      <div class="modal-footer">
        <div class="row col justify-content-end">
          <div class="col-4">
            <button type="button" class="btn btn-pastel-blue w-150" id="clear-search-data">条件クリア</button>
          </div>
          <div class="col-4">
            <button type="button" class="btn btn-pastel-red w-150" id="search-data">検索する</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- result modal -->
<div class="modal fade" id="result-modal" tabindex="-1" aria-labelledby="uc-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">

      <!-- モーダルヘッダー -->
      <div class="modal-header">
        <h5 class="modal-title" id="uc-modal-label"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
      </div>

      <!-- モーダルボディ -->
      <div class="modal-body">
        <div class="" id="result-text">
        </div>
      </div>

      <!-- モーダルフッター -->
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary btn-block" id="close-result-modal">閉じる</button>
      </div>
    </div>
  </div>
</div>
