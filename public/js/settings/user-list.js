let page = 1;
let sortBy = 'id-asc';
let paginateNum = 20;

document.querySelector('#paginate-num').addEventListener('change', function (e) {
  e.preventDefault();
  paginateNum = e.target.value;
  page = 1;
  getDatas();
});

document.querySelector('#sort-by').addEventListener('change', function (e) {
  e.preventDefault();
  sortBy = e.target.value;
  page = 1;
  getDatas();
});

document.addEventListener('click', function (e) {

  // モーダル表示ボタンの処理
  const modalBtn = e.target.closest('.show-update-modal');
  if (modalBtn) {
    const userId = modalBtn.dataset.id;
    if (userId) {
      showUpdateModal(userId);
    }
    return; // 他の処理はスキップ
  }


  const link = e.target.closest('.page-link');
  if (!link) return;

  e.preventDefault();
  const href = link.getAttribute('href');
  if (!href) return;

  const url = new URL(href, window.location.origin);
  page = url.searchParams.get('page');

  getDatas();
});

document.querySelector('#search-data').addEventListener('click', function (e) {
  e.preventDefault();
  page = 1;
  getDatas();
});

document.querySelector('#show-create-modal').addEventListener('click', function (e) {
  e.preventDefault();
  document.querySelectorAll('.error-text').forEach(el => {
    el.classList.add('d-none');
    el.textContent = '';
  });
  document.querySelectorAll('[data-field]').forEach(input => {
    input.value = '';
  });
  document.querySelector('#uc-modal-label').innerText = '新規登録';
  document.querySelector('#create-data').innerText = '新規登録';

  const modalEl = document.querySelector('#uc-modal');
  const modal = new bootstrap.Modal(modalEl);
  modal.show();
});

document.querySelector('#show-search-modal').addEventListener('click', function (e) {
  e.preventDefault();
  const modalEl = document.querySelector('#search-modal');
  const modal = new bootstrap.Modal(modalEl);
  modal.show();
});

document.querySelector('#clear-search-data').addEventListener('click', function (e) {
  e.preventDefault();
  document.querySelectorAll('[data-search]').forEach(input => {
    input.value = '';
  });
});

document.querySelector('#create-data').addEventListener('click', function (e) {
  e.preventDefault();

  // エラーメッセージ非表示（前回のエラーをクリア）
  document.querySelectorAll('.error-text').forEach(el => {
    el.classList.add('d-none');
    el.textContent = '';
  });

  const data = {};
  document.querySelectorAll('[data-field]').forEach(input => {
    data[input.dataset.field] = input.value;
  });

  data['paginateNum'] = document.querySelector('#paginate-num')?.value || 20;
  data['sortBy'] = document.querySelector('#sort-by')?.value || 'id-asc';

  const url = '/settings/user-list/update-create';

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify(data),
  })
    .then(response => {
      if (response.status === 422) {
        return response.json().then(data => {
          const errors = data.errors;
          for (const [field, messages] of Object.entries(errors)) {
            const errorEl = document.getElementById(`${field}-error`);
            if (errorEl) {
              errorEl.textContent = messages[0];
              errorEl.classList.remove('d-none');
            }
          }
        });
      } else {
        return response.json();
      }
    })
    .then(data => {
      if (data?.success) {
        document.querySelector('#user-list-table').innerHTML = data.html;

        let modalEl = document.getElementById('uc-modal');
        let modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();

        document.querySelector('#uc-modal-label').innerText = '新規登録';
        document.querySelector('#result-text').textContent = '登録が完了しました';

        modalEl = document.querySelector('#result-modal');
        modal = new bootstrap.Modal(modalEl);
        modal.show();

      }
    })
    .catch(error => {
      console.error('送信エラー:', error);
      alert('サーバーエラーが発生しました');
    });
});

document.querySelector('#close-result-modal').addEventListener('click', function () {
  console.log('close btn-close');
  const modalEl = document.getElementById('result-modal');
  const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
  modal.hide();
})

// モーダル表示処理（例）
function showUpdateModal(userId) {
  // データ取得（必要であればAjaxなど）
  fetch('/settings/user-list/detail', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ id: userId })
  })
    .then(response => response.json())
    .then(data => {
      // モーダルの中身を埋める処理
      document.querySelector('#name').value = data.userData.name;
      document.querySelector('#email').value = data.userData.email;
      document.querySelector('#uc-modal-label').innerText = '修正';
      document.querySelector('#create-data').innerText = '更新';
      // ...

      // モーダル表示
      const modalEl = document.querySelector('#uc-modal');
      const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
      modal.show();
    })
    .catch(error => {
      console.error('ユーザー情報取得エラー', error);
      alert('ユーザー情報の取得に失敗しました');
    });
}


function getDatas() {

  console.log('getDatas');

  const data = {};
  document.querySelectorAll('[data-search]').forEach(input => {
    data[input.dataset.search] = input.value;
  });
  data['page'] = page;
  data['paginateNum'] = paginateNum;
  data['sortBy'] = sortBy;

  console.log('data', data);

  const url = '/settings/user-list/get-data';

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify(data),
  })
    .then(response => response.json())
    .then(data => {
      if (data?.success) {
        document.querySelector('#user-list-table').innerHTML = data.html;
      }
    })
    .catch(error => {
      console.error('送信エラー:', error);
      alert('サーバーエラーが発生しました');
    });
}

