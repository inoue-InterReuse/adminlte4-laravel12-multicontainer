<div>
  <div class="table-responsive sticky-table-wrapper">
    <table class="table table-bordered table-striped text-nowrap sticky-table">
      <thead class="">
        <tr>
          <th scope="col" class="text-center">ID</th>
          <th scope="col" class="text-center">氏名</th>
          <th scope="col" class="text-center">email</th>
          <th scope="col" class="text-center"></th>
        </tr>
      </thead>

      <tbody>
        @foreach ($userDatas as $userData)
          <tr>
            <td class="text-center">{{ $userData->id }}</td>
            <td class="text-center">{{ $userData->name }}</td>
            <td>{{ $userData->email }}</td>
            <td class="text-center">
              <button type="button" class="btn btn-outline-primary btn-sm show-update-modal" data-id="{{ $userData->id }}">修正</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- ページネーション --}}
  <div class="mt-3">
    {{ $userDatas->onEachSide(1)->links('pagination.bootstrap-5') }}
  </div>
</div>
