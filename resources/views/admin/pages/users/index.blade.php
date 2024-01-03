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

      <!-- Modal Add new -->
      <div class="modal fade" id="staticBackdropAddNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropAddNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <form id="add-new-user-form" class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropAddNewLabel">Thêm người dùng mới</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input required type="text" class="form-control" id="name" name="name"
                  placeholder="Nhập họ tên">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input required type="email" class="form-control" id="email" name="email"
                  placeholder="Nhập email">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input required type="password" class="form-control" id="password" name="password"
                  placeholder="Nhập password">
              </div>
              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input required type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                  placeholder="Nhập Confirm password">
                <span class="text-danger mt-2" id="password-error-text"></span>
              </div>
              <div class="mb-3">
                <label for="role" class="form-label">Nhóm</label>
                <select required class="form-select" id="role" name="role">
                  <option value="admin">Admin</option>
                  <option value="editor">Editor</option>
                  <option value="reviewer">Reviewer</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select required class="form-select" id="status" name="status">
                  <option value="1">Hoạt động</option>
                  <option value="0">Tạm khóa</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
              <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
          </form>
        </div>
      </div>
      <!-- End Modal add new -->


      <!-- Modal Edit User -->
      <div class="modal fade" id="staticBackdropUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropUpdateLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <form id="update-user-form" class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropUpdateLabel">Cập nhập thông tin người dùng</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <input type="hidden" class="form-control" id="userId" name="userId">

            <div class="modal-body">
              <div class="mb-3">
                <label for="nameEditing" class="form-label">Tên</label>
                <input required type="text" class="form-control" id="nameEditing" name="nameEditing"
                  placeholder="Nhập họ tên">
              </div>
              <div class="mb-3">
                <label for="emailEditing" class="form-label">Email</label>
                <input required type="emailEditing" class="form-control" id="emailEditing" name="emailEditing"
                  placeholder="Nhập email">
              </div>
              <div class="mb-3">
                <label for="passwordEditing" class="form-label">Password</label>
                <input required type="password" class="form-control" id="passwordEditing" name="passwordEditing"
                  placeholder="Nhập password">
              </div>
              <div class="mb-3">
                <label for="confirmPasswordEditing" class="form-label">Confirm Password</label>
                <input required type="password" class="form-control" id="confirmPasswordEditing"
                  name="confirmPasswordEditing" placeholder="Nhập Confirm password">
                <span class="text-danger mt-2" id="password-editing-error-text"></span>
              </div>
              <div class="mb-3">
                <label for="roleEditing" class="form-label">Nhóm</label>
                <select required class="form-select" id="roleEditing" name="roleEditing">
                  <option value="admin">Admin</option>
                  <option value="editor">Editor</option>
                  <option value="reviewer">Reviewer</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="statusEditing" class="form-label">Trạng thái</label>
                <select required class="form-select" id="statusEditing" name="statusEditing">
                  <option value="1">Hoạt động</option>
                  <option value="0">Tạm khóa</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
              <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
          </form>
        </div>
      </div>
      <!-- End Modal Edit User -->


      <!-- Modal Modal Block and unlock user -->
      <div class="modal fade" id="staticBackdropBlockAndUnLock" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropBlockAndUnLockLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <form id="block-and-unlock-user-form" class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropBlockAndUnLockLabel">Nhắc nhở</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <input type="hidden" class="form-control" id="userIdToggleActive" name="userId">
              <input type="hidden" class="form-control" id="isActiveToggleActive" name="status">

              <p class="fs-3 text-center content-toggle-block"></p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
              <button type="submit" class="btn btn-primary">OK</button>
            </div>
          </form>
        </div>
      </div>
      <!-- End Modal Block and unlock user -->


      <!-- Modal Modal Delete user -->
      <div class="modal fade" id="staticBackdropDeleteUser" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropDeleteUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <form id="delete-user-form" class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropDeleteUserLabel">Nhắc nhở</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <input type="hidden" class="form-control" id="userIdDelete" name="userId">

              <p class="fs-3 text-center content-delete"></p>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
              <button type="submit" class="btn btn-primary">OK</button>
            </div>
          </form>
        </div>
      </div>
      <!-- End Modal Delete user -->

      <form id="search-form" class="pb-4">
        <div class="row my-3 fields">
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div>
              <label for="name" class="form-label">Tên</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ tên">
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div>
              <label for="email" class="form-label">Email</label>
              <input class="form-control" id="email" name="email" placeholder="Nhập email">
              {{-- Depended on Customer Requirement --}}
              {{-- <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email">
            --}}
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div>
              <label for="role" class="form-label">Nhóm</label>
              <select class="form-select" id="role" name="role">
                <option value="" selected>Mặc định</option>
                <option value="admin">Admin</option>
                <option value="editor">Editor</option>
                <option value="reviewer">Reviewer</option>
              </select>
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div>
              <label for="status" class="form-label">Trạng thái</label>
              <select class="form-select" id="status" name="status">
                <option value="" selected>Mặc định</option>
                <option value="0">Tạm khóa</option>
                <option value="1">Đang Hoạt động</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row my-3 actions">
          <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8 col left">
            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
              data-bs-target="#staticBackdropAddNew">
              <i class="fa-solid fa-user-plus"></i>
              <span>Thêm mới</span>
            </button>
          </div>

          <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 col right text-end">
            <button type="submit" class="btn btn-primary ms-3">
              <i class="fa-solid fa-magnifying-glass"></i>
              <span>Tìm kiếm</span>
            </button>

            <button type="reset" id="clear-search" class="btn btn-success ms-3">
              <i class="fa-solid fa-delete-left"></i>
              <span>Xóa tìm</span>
            </button>
          </div>
        </div>
      </form>


      <div>
        <p class="text-end">
          Hiển thị từ <span id="from">1</span> ~ <span id="to">10</span> trong tổng số
          <span id="total">100</span> user
        </p>

        <!-- main datatable -->
        <div class="table-responsive">
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
        </div>


        <div class="row">

          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="d-flex align-items-center gap-2">
              <label for="perPage">Hiển thị</label>
              <select class="form-select form-select-sm w-auto" id="perPage">
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
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
      $(document).ready(() => {
        let perPage = 10;
        let page = 1;
        let name = '';
        let email = '';
        let role = '';
        let status = '';

        // Helper: get data from form.
        const getData = (event) => {
          const target = event.target;
          const inputNames = [];
          const formData = new FormData(target);

          for (const item of target) {
            if (!item?.name) continue;
            inputNames.push(item.name);
          }

          return inputNames.reduce((prevValue, currentValue) => {
            return {
              ...prevValue,
              [currentValue]: formData.get(currentValue),
            };
          }, {});
        };

        // handle clear filter (search)
        $('#clear-search').on('click', () => {
          // Run with default parameters
          renderDatatable();
        });

        // handle submit form
        $('#search-form').on('submit', (event) => {
          event.preventDefault();
          const {
            name: formName,
            email: formEmail,
            role: formRole,
            status: formStatus,
          } = getData(event);

          // Store search
          name = formName;
          email = formEmail;
          role = formRole;
          status = formStatus;

          // reset pagination
          page = 1;

          renderDatatable(page, perPage, name, email, role, status);
        });

        // Handle change per_page
        $('#perPage').on('change', (event) => {
          perPage = event.target.value;
          renderDatatable(page, perPage, name, email, role, status);
        });

        // Handle click paginate
        $('#paginate').on('click', (event) => {
          const pageConverted = Number(event.target.dataset.page);
          if (pageConverted?.toString() === 'NaN') return;

          page = pageConverted;
          renderDatatable(page, perPage, name, email, role, status);
        });

        const renderDatatable = (
          page = 1,
          perPage = 10,
          name = '',
          email = '',
          role = '',
          status = ''
        ) => {
          $.ajax({
            type: 'GET',
            url: `{{ route('user.index') }}/?page=${page}&perPage=${perPage}&name=${name}&email=${email}&role=${role}&status=${status}`,
            dataType: 'json',
            success: function(response) {
              const paginate = response?.paginate ?? {};
              const total = paginate.total ?? 0;
              const from = paginate.from ?? 0;
              const to = paginate.to ?? 0;
              const lastPage = paginate.last_page ?? 0;
              const links = paginate.links ?? [];
              const items = paginate.data ?? [];

              $('#from').html(from);
              $('#to').html(to);
              $('#total').html(total);

              if (!paginate?.data?.length) {
                // No data to show
                $('#table-body').html(
                  "<tr class='text-center'><td colspan='5' class='fw-bold fs-3'>Không có dữ liệu</td></tr>")
                $('#paginate').html(null);
                return;
              }


              // Render table data
              $('#table-body').html(null);
              $.each(items, (index, user) => {
                $('#table-body').append(`
                <tr>
                  <th scope="row">${user?.id}</th>
                  <td>${user?.name}</td>
                  <td>${user?.email}</td>
                  <td class="text-capitalize">${user?.group_role ?? 'unknow'}</td>
                  <td class="${!user?.is_active ? "text-danger":"text-success"}">${user?.active_text}</td>
                  <td class="d-flex flex-row flex-wrap gap-3">
                    <button class="btn btn-warning btnEditUser" data-userId=${user?.id} data-bs-toggle="modal" data-bs-target="#staticBackdropUpdate">
                      <i class="fa-solid fa-pen text-white btnEditUser" data-userId=${user?.id}></i>
                    </button>

                    <button class="btn btn-danger btnDeleteUser" data-userId=${user?.id} data-bs-toggle="modal" data-bs-target="#staticBackdropDeleteUser">
                        <i class="fa-solid fa-trash-can btnDeleteUser" data-userId=${user?.id}></i>
                    </button>

                    <button class="btn btn-dark btnToggleBlockUser" data-userId=${user?.id} data-isActive=${user?.is_active} data-bs-toggle="modal" data-bs-target="#staticBackdropBlockAndUnLock">
                       ${user?.is_active ?
                        `<i class="fa-solid fa-unlock text-white btnToggleBlockUser" data-userId=${user?.id} data-isActive=${user?.is_active}></i>`
                        :`<i class="fa-solid fa-lock text-warning btnToggleBlockUser" data-userId=${user?.id} data-isActive=${user?.is_active}></i>`}
                    </button>
                  </td>
                </tr>
                `);
              });


              if (total < 20) {
                $('#paginate').html(null);
                return;
              }

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
            `);
            },
            error: function(error) {
              alert('Không thể xử lý dữ liệu, nhấn F5 để làm mới trang web');
              console.error(error);
            }
          });
        }
        // First render data
        renderDatatable(page, perPage, name, email, role, status);


        //* ++++++++++++++++++++ HANDLE ADD NEW USER ++++++++++++++++++++ *//
        const handleComparePassword = (password, confirmPassword, target = '#password-error-text') => {
          if (password === confirmPassword) {
            $(target).html(null)
            return false;
          } else {
            $(target).html('Mật khẩu không trùng khớp')
            return true;
          }
        }

        // get modal want to close.
        const staticBackdropAddNew = new bootstrap.Modal(document.getElementById('staticBackdropAddNew'), {
          keyboard: false
        });

        let isError = false;

        $('#password').on('keyup', ({
          target
        }) => {
          isError = handleComparePassword(target.value, $('#confirmPassword').val())
        });

        $('#confirmPassword').on('keyup', ({
          target
        }) => {
          isError = handleComparePassword($('#password').val(), target.value)
        })

        $('#add-new-user-form').on('submit', (event) => {
          event.preventDefault();
          if (isError) return;

          const {
            name,
            email,
            role,
            status,
            password,
            confirmPassword
          } = getData(event);

          $.ajax({
            url: `{{ route('user.store') }}`,
            type: 'POST',
            data: {
              name,
              email,
              role,
              status,
              password,
            },
            success: function(response) {
              renderDatatable();
              event.target.reset();
              staticBackdropAddNew?.hide();
              alert('Tạo người dùng mới thành công');
            },
            error: function(error) {
              alert('Không thể xử lý dữ liệu');
              console.error(error);
            }
          });
        });

        //* ++++++++++++++++++++ HANDLE UPDATE USER ++++++++++++++++++++ *//

        // Get user data want to update.
        $('#table-body').on('click', event => {
          // If not the button show modal to edit and Break function.
          const isBtnEditUser = event.target.classList.value.includes('btnEditUser');
          if (!isBtnEditUser) return;

          // set userId for hidden input
          const userId = event.target.dataset.userid;
          $('#userId').val(userId);

          const url = `{{ route('user.edit', ['user' => ':userId']) }}`.replace(':userId', userId);

          $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(response) {
              const user = response.user ?? {};

              $('#nameEditing').val(user?.name);
              $('#emailEditing').val(user?.email);
              $('#roleEditing').val(user?.group_role);
              $('#statusEditing').val(user?.is_active);
              $('#passwordEditing').val(null);
              $('#confirmPasswordEditing').val(null);
            },
            error: function(error) {
              alert('Không thể xử lý dữ liệu');
              console.error(error);
            }
          });
        });

        const staticBackdropUpdate = new bootstrap.Modal(document.getElementById('staticBackdropUpdate'), {
          keyboard: false
        });

        let isErrorEditing = false;

        $('#passwordEditing').on('keyup', ({
          target
        }) => {
          isErrorEditing = handleComparePassword(
            target.value,
            $('#confirmPasswordEditing').val(),
            '#password-editing-error-text'
          )
        });

        $('#confirmPasswordEditing').on('keyup', ({
          target
        }) => {
          isErrorEditing = handleComparePassword(
            $('#passwordEditing').val(),
            target.value,
            '#password-editing-error-text'
          )
        })

        $('#update-user-form').on('submit', (event) => {
          event.preventDefault();
          if (isErrorEditing) return;

          const {
            userId,
            nameEditing,
            emailEditing,
            roleEditing,
            statusEditing,
            passwordEditing,
            confirmPassworEditing
          } = getData(event);

          const url = `{{ route('user.update', ['user' => ':id']) }}`.replace(':id', userId);

          $.ajax({
            url: url,
            type: 'PATCH',
            data: {
              name: nameEditing,
              email: emailEditing,
              role: roleEditing,
              status: statusEditing,
              password: passwordEditing,
            },
            success: function(response) {
              renderDatatable(page, perPage, name, email, role, status);
              event.target.reset();
              staticBackdropUpdate?.hide();
              alert('Cập nhập người dùng thành công');
            },
            error: function(error) {
              alert('Không thể xử lý dữ liệu');
              console.error(error);
            }
          });
        });


        //* ++++++++++++++++++++ HANDLE BLOCK AND UNBLOCK USER ++++++++++++++++++++ *//
        const staticBackdropBlockAndUnLock = new bootstrap.Modal(document.getElementById(
          'staticBackdropBlockAndUnLock'), {
          keyboard: false
        });

        $('#table-body').on('click', event => {
          // If not the button show modal to toggle block user and Break function.
          const isBtnToggleBlockUser = event.target.classList.value.includes('btnToggleBlockUser')
          if (isBtnToggleBlockUser) {
            const {
              userid: userId,
              isactive: isActive
            } = event.target.dataset ?? {};

            if (Number(isActive) === 0) {
              $('.content-toggle-block').html(
                `Bạn có muốn <span class='fw-bolder'>mở khóa</span> <br/> thành viên <span class='fw-bolder'>${userId}</span> không`
              );
              $('#userIdToggleActive').val(userId);
              $('#isActiveToggleActive').val(1);

            } else if (Number(isActive) === 1) {
              $('.content-toggle-block').html(
                `Bạn có muốn <span class='fw-bolder'>khóa</span> <br/> thành viên <span class='fw-bolder'>${userId}</span> không`
              );
              $('#userIdToggleActive').val(userId);
              $('#isActiveToggleActive').val(0);
            }
          }
        });

        $('#block-and-unlock-user-form').on('submit', event => {
          event.preventDefault();

          const {
            userId,
            status: statusToggling,
          } = getData(event);
          const url = `{{ route('user.update', ['user' => ':id']) }}?fields[]=status`.replace(':id', userId);

          $.ajax({
            url: url,
            type: 'PATCH',
            data: {
              status: statusToggling,
            },
            success: function(response) {
              renderDatatable(page, perPage, name, email, role, status);
              event.target.reset();
              staticBackdropBlockAndUnLock?.hide();
              alert('Cập nhập người dùng thành công');
            },
            error: function(error) {
              alert('Không thể xử lý dữ liệu');
              console.error(error);
            }
          });
        });

        //* ++++++++++++++++++++ HANDLE DELETE USER ++++++++++++++++++++ *//
        const staticBackdropDeleteUser = new bootstrap.Modal(document.getElementById(
          'staticBackdropDeleteUser'), {
          keyboard: false
        });

        $('#table-body').on('click', event => {
          // If not the button show modal to toggle block user and Break function.
          const isBtnDeleteUser = event.target.classList.value.includes('btnDeleteUser')
          if (isBtnDeleteUser) {
            const {
              userid: userId,
            } = event.target.dataset ?? {};

            $('#userIdDelete').val(userId);
            $('.content-delete').html(
              `Bạn có muốn <span class='fw-bolder'>xóa</span><br/>
              thành viên <span class='fw-bolder'>${userId}</span> không`
            );
          }
        });

        $('#delete-user-form').on('submit', event => {
          event.preventDefault();

          const {
            userId,
          } = getData(event);
          const url = `{{ route('user.delete', ['user' => ':id']) }}`.replace(':id', userId);

          $.ajax({
            url: url,
            type: 'PATCH',
            data: {
              status: status,
            },
            success: function(response) {
              renderDatatable(page, perPage, name, email, role, status);
              event.target.reset();
              staticBackdropDeleteUser?.hide();
              alert('Xóa người dùng thành công');
            },
            error: function(error) {
              alert('Không thể xử lý dữ liệu');
              console.error(error);
            }
          });
        });

      })
    </script>

  </main>
@endsection
