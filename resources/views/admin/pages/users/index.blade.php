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
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Họ tên</th>
              <th scope="col">Email</th>
              <th scope="col">Nhóm</th>
              <th scope="col">Trạng Thái</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td>@mdo</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Jacob</td>
              <td>Thornton</td>
              <td>@fat</td>
              <td>@fat</td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Larry the Bird</td>
              <td>Larry the Bird</td>
              <td>Larry the Bird</td>
              <td>Larry the Bird</td>
            </tr>
          </tbody>
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
              <ul class="pagination justify-content-end">
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&lt;</span>
                  </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&gt;</span>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&gt;&gt;</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>

        </div>

      </div>

    </div>

    <script>
      $.ajax({
        type: 'GET',
        url: '{{ route('user.index') }}/?page=2',
        dataType: 'json',
        success: function(data) {
          console.log({
            data
          });
        },
        error: function(data) {
          console.log(data);
        }
      });
    </script>
  </main>
@endsection
