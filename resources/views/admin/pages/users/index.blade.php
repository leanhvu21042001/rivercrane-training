@extends('admin.layout.layout')

@section('title')
  User Manager Page
@endsection


@section('content')
  <main class="d-flex flex-column">

    <div class="container py-5">
      <h1>Users</h1>
    </div>

    <div class="container filter">
      <div class="pb-4">
        <div class="row my-3 fields">
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div>
              <label for="name" class="form-label">Tên</label>
              <input type="text" class="form-control" id="name" placeholder="Nhập họ tên">
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div>
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Nhập email">
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div>
              <label for="role" class="form-label">Nhóm</label>
              <select class="form-select" id="role">
                <option value="default" selected>Mặc định</option>
                <option value="admin">Admin</option>
                <option value="editor">Editor</option>
                <option value="reviewer">Reviewer</option>
              </select>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div>
              <label for="role" class="form-label">Trạng thái</label>
              <select class="form-select" id="role">
                <option value="default" selected>Mặc định</option>
                <option value="0">Tạm khóa</option>
                <option value="1">Đang Hoạt động</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row my-3 actions ">
          <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8 col left">
            <button class="btn btn-primary">
              <i class="fa-solid fa-user-plus"></i>
              <span>Thêm mới</span>
            </button>
          </div>

          <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 col right text-end">
            <button class="btn btn-primary ms-3">
              <i class="fa-solid fa-magnifying-glass"></i>
              <span>Tìm kiếm</span>
            </button>

            <button class="btn btn-success ms-3">
              <i class="fa-solid fa-delete-left"></i>
              <span>Xóa tìm</span>
            </button>
          </div>
        </div>
      </div>


      <div>
        <p class="text-end">
          Hiển thị từ <span id="from">1</span> ~ <span id="to">10</span> trong tổng số
          <span id="total">100</span> user
        </p>

        <!-- main datatable -->
        <table class="table table-striped" id="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Họ tên</th>
              <th scope="col">Email</th>
              <th scope="col">Nhóm</th>
              <th scope="col">Trạng Thái</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody id="table-body"></tbody>
        </table>

        <div class="row">

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="d-flex align-items-center gap-2">
              <label for="perPage">Hiển thị</label>
              <select class="form-select form-select-sm w-auto" id="perPage">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="50">50</option>
              </select>
              <label for="perPage">đơn vị</label>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <nav aria-label="Page user management navigation">
              <ul class="pagination justify-content-end" id="paginate"></ul>
            </nav>
          </div>

        </div>

      </div>

    </div>

    <script>
      let perPage = 10;
      let page = 1;

      // Handle change per_page
      $('#perPage').on('change', (event) => {
        perPage = event.target.value;
        handleRenderDatatable(page, perPage);
      });

      // Handle click paginate
      $('#paginate').on('click', (event) => {
        const pageConverted = Number(event.target.dataset.page);
        if (pageConverted?.toString() === 'NaN') return;

        page = pageConverted;
        handleRenderDatatable(page, perPage);
      });

      const handleRenderDatatable = (page = 1, perPage = 10) => {
        $.ajax({
          type: 'GET',
          url: `{{ route('user.index') }}/?page=${page}&perPage=${perPage}`,
          dataType: 'json',
          success: function(response) {
            if (!response?.paginate?.data?.length) {
              // No data to show
              $('#table-body').html(
                "<tr class='text-center'><td colspan='5' class='fw-bold fs-3'>Không có dữ liệu</td></tr>")
              return;
            }

            const paginate = response.paginate ?? {};
            const total = paginate.total ?? 0;
            const from = paginate.from ?? 0;
            const to = paginate.to ?? 0;
            const lastPage = paginate.last_page ?? 0;
            const links = paginate.links ?? [];
            const items = paginate.data ?? [];

            $('#from').html(from);
            $('#to').html(to);
            $('#total').html(total);

            // Render table data
            $('#table-body').html(null);
            $.each(items, (index, user) => {
              $('#table-body').append(`
                <tr>
                  <th scope="row">${index + 1}</th>
                  <td>${user?.name}</td>
                  <td>${user?.email}</td>
                  <td>${user?.role ?? 'unknow'}</td>
                  <td>${user?.active_text}</td>
                  <td>
                    <i class="fa-solid fa-pen"></i>
                    <i class="fa-solid fa-trash-can"></i>
                    <i class="fa-solid fa-user-xmark"></i>
                  </td>
                </tr>
                `);
            });

            // Render pagination
            $('#paginate').html(null);
            $.each(links, (index, link) => {

              const page = link?.url?.split('page=').at(1);

              if (index === 0) {
                $('#paginate').append(`
                    <li class="page-item${link.active ? ' active' : ''}" data-page="${page}">
                        <a href="#!" class="page-link" aria-label="Previous" data-page="${page}">
                            <span aria-hidden="true" data-page="${page}">&lt;</span>
                        </a>
                    </li>
                  `);
              } else if (index === links.length - 1) {
                $('#paginate').append(`
                    <li class="page-item${link.active ? ' active' : ''}" data-page="${page}">
                        <a href="#!" class="page-link" aria-label="Next" data-page="${page}">
                            <span aria-hidden="true" data-page="${page}">&gt;</span>
                        </a>
                    </li>
                  `);
              } else {
                $('#paginate').append(`
                  <li class="page-item${link.active ? ' active' : ''}" ${link.active ? 'aria-current="page"' : ''} data-page="${page}">
                      <a href="#!" class="page-link" data-page="${page}">${link.label}</a>
                  </li>
                  `);
              }
            });

            $('#paginate').append(`
              <li class="page-item" data-page="${lastPage}">
                <a href="#!" class="page-link" aria-label="Next" data-page="${lastPage}">
                  <span aria-hidden="true" data-page="${lastPage}">&gt;&gt;</span>
                </a>
              </li>
            `)
          },
          error: function(data) {
            console.log(data);
          }
        });
      }
      // First render data
      handleRenderDatatable(page, perPage);
    </script>
  </main>
@endsection
