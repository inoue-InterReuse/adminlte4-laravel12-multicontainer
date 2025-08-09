<!doctype html>
<html lang="ja">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>InterReuse @yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--begin::Primary Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="InterReuse | Dashboard" />
  <meta name="author" content="ColorlibHQ" />
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <!--end::Primary Meta Tags-->
  <!--begin::Fonts-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
  <!--end::Fonts-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
    integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
  <!--end::Third Party Plugin(OverlayScrollbars)-->
  <!--begin::Required Plugin(Bootstrap 5 CSS)-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!--end::Required Plugin(Bootstrap 5 CSS)-->
  <!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
  <!--end::Third Party Plugin(Bootstrap Icons)-->
  <!--begin::Required Plugin(AdminLTE)-->
  <link rel="stylesheet" href="{{ asset_version('adminlte/dist/css/adminlte.css') }}" />
  <!--end::Required Plugin(AdminLTE)-->
  <!--begin::Required custom-->
  <link rel="stylesheet" href="{{ asset_version('css/custom.css') }}" />
  <link rel="stylesheet" href="{{ asset_version('css/style.css') }}" />
  <!--end::Required custom-->
  <!-- apexcharts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
    integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />
  <!-- jsvectormap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
    integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous" />
  <style>
    /* ログアウト */
    .compact-user-toggle {
      padding: 0.4rem 0.6rem !important;
      border-radius: 15px;
      transition: all 0.2s ease;
    }

    .compact-user-toggle:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .compact-user-name {
      font-size: 20px;
      font-weight: 500;
    }

    .compact-dropdown {
      min-width: 200px;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      margin-top: 5px;
    }

    .compact-logout-btn {
      padding: 0.5rem 1rem !important;
      font-size: 18px !important;
      transition: all 0.2s ease;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      text-align: center !important;
    }

    .compact-logout-btn i {
      margin-right: 0.4rem;
      width: 16px;
      color: #dc3545;
    }
  </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">

    <!--begin::Header-->
    <x-navibar />
    <!--end::Header-->

    <!--begin::Sidebar-->
    <x-sidebar />
    <!--end::Sidebar-->

    @yield('content')

    <!--begin::Footer-->
    <x-footer />
    <!--end::Footer-->

  </div>
  <!--end::App Wrapper-->
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="{{ asset_version('adminlte/dist/js/adminlte.js') }}"></script>
  <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>
  <!--end::OverlayScrollbars Configure-->
  <!-- OPTIONAL SCRIPTS -->
  <!-- sortablejs -->
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
    integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script>
  <!-- apexcharts -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
    integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
  <!-- jsvectormap -->
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
    integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
    integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const logoutForm = document.getElementById('logout-form');

      if (logoutForm) {
        logoutForm.addEventListener('submit', function(e) {
          // デフォルトの送信を防止
          e.preventDefault();

          // 手動でフェッチAPIを使用して送信
          fetch(this.action, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: new URLSearchParams(new FormData(this))
            })
            .then(response => {
              if (response.ok || response.redirected) {
                // キャッシュを避けるためにランダムクエリを追加してリダイレクト
                window.location.href = '/login?nocache=' + Math.random();
              }
            })
            .catch(error => console.error('ログアウトエラー:', error));
        });
      }
    });
  </script>
  <script>
    document.querySelectorAll('.modal').forEach(modal => {
      const modalId = modal.id;
      let opener = null;

      // モーダルを開いたトリガーを保持
      document.querySelectorAll(`[data-bs-target="#${modalId}"]`).forEach(trigger => {
        trigger.addEventListener('click', () => {
          opener = trigger;
        });
      });

      // モーダル非表示直前（フォーカスが残っていたら blur）
      modal.addEventListener('hide.bs.modal', () => {
        if (document.activeElement && modal.contains(document.activeElement)) {
          document.activeElement.blur();
        }
      });

      // モーダル完全に閉じた後（念のためもう一度 blur）
      modal.addEventListener('hidden.bs.modal', () => {
        requestAnimationFrame(() => {
          if (document.activeElement && modal.contains(document.activeElement)) {
            document.activeElement.blur();
          }

          if (opener && typeof opener.focus === 'function') {
            opener.focus();
          }
        });
      });
    });
  </script>
  <!--end::Script-->
</body>
<!--end::Body-->

</html>
