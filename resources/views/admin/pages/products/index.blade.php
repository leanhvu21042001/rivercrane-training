@extends('admin.layout.layout')

@section('title')
  Product Manager Page
@endsection


@section('content')
  <main class="d-flex flex-column">

    <div class="container d-flex flex-row align-items-center justify-content-between py-5">
      <h1>Danh sách sản phẩm</h1>

      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Sản phẩm</a></li>
        </ol>
      </nav>
    </div>

    <!-- Modal Modal Delete product -->
    <div class="modal fade" id="staticBackdropDeleteProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropDeleteProductLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form id="delete-product-form" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropDeleteProductLabel">Nhắc nhở</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <input type="hidden" class="form-control" id="productIdDelete" name="productId">

            <p class="fs-3 text-center content-delete"></p>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-primary">OK</button>
          </div>
        </form>
      </div>
    </div>
    <!-- End Modal Delete product -->

    <!-- Filter -->
    <div class="container filter">
      <form id="search-form" class="pb-4">
        <div class="row my-3 fields">
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div>
              <label for="name" class="form-label">Tên sản phẩm</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên sản phẩm">
            </div>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div>
              <label for="status" class="form-label">Trạng thái</label>
              <select class="form-select" id="status" name="status">
                <option value="" selected>Mặc định</option>
                <option value="0">Ngừng bán</option>
                <option value="1">Đang bán</option>
                <option value="2">Hết hàng</option>
              </select>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
            <div class="row">
              <div class="col-5">
                <label for="price_from" class="form-label">Giá bán từ</label>
                <input type="number" class="form-control" id="price_from" name="price_from" value="0"
                  min="0">
              </div>
              <div class="col-2 px-0">
                <label class="form-label">&ThinSpace;</label>
                <input type="text" class="form-control text-center px-0 border-0" value="~">
              </div>
              <div class="col-5">
                <label for="price_to" class="form-label">Giá bán đến</label>
                <input type="number" class="form-control" id="price_to" name="price_to" value="0" min="0">
              </div>
            </div>
          </div>

        </div>

        <!-- Actions -->
        <div class="row my-3 actions">
          <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8 col left">
            <a class="btn btn-primary" type="button" href="{{ route('product.create') }}">
              <i class="fa-solid fa-plus"></i>
              <span>Thêm mới</span>
            </a>
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
    </div>

    <div class="container">
      <p class="text-end">
        Hiển thị từ <span id="from">1</span> ~ <span id="to">10</span> trong tổng số
        <span id="total">100</span> sản phẩm
      </p>

      <!-- main datatable -->
      <div class="table-responsive">
        <table class="table table-striped" id="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Tên sản phẩm</th>
              <th scope="col text-truncate" style="max-width: 150px;">Mô tả</th>
              <th scope="col">Giá</th>
              <th scope="col">Trạng Thái</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody id="table-body"></tbody>
        </table>
      </div>

      <!-- Pagination -->
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
          <nav aria-label="Page product management navigation">
            <ul class="pagination justify-content-end" id="paginate"></ul>
          </nav>
        </div>

      </div>

    </div>



    <script>
      $(document).ready(() => {
        let perPage = 10;
        let page = 1;
        let name = '';
        let status = '';
        let price_from = '';
        let price_to = '';

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
            price_from: formPriceFrom,
            price_to: formPriceTo,
          } = getData(event);

          // Store search
          name = formName;
          email = formEmail;
          role = formRole;
          status = formStatus;
          price_from = formPriceFrom;
          price_to = formPriceTo;

          // reset pagination
          page = 1;

          renderDatatable(page, perPage, name, status, price_from, price_to);
        });

        // Handle change per_page
        $('#perPage').on('change', (event) => {
          perPage = event.target.value;
          renderDatatable(page, perPage, name, status, price_from, price_to);
        });

        // Handle click paginate
        $('#paginate').on('click', (event) => {
          const pageConverted = Number(event.target.dataset.page);
          if (pageConverted?.toString() === 'NaN') return;

          page = pageConverted;
          renderDatatable(page, perPage, name, status, price_from, price_to);
        });

        const renderDatatable = (
          page = 1,
          perPage = 10,
          name = '',
          status = '',
          price_from = '',
          price_to = '',
        ) => {
          $.ajax({
            type: 'GET',
            url: `{{ route('product.index') }}/?page=${page}&perPage=${perPage}&name=${name}&status=${status}&price_from=${price_from}&price_to=${price_to}`,
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
              $.each(items, (index, product) => {
                $('#table-body').append(`
                  <tr>
                    <th scope="row">${product?.id}</th>
                    <td class="product-name">
                        <span class="all: unset;" data-toggle="tooltip" title="<img src='{{ url('') }}/${product?.image}' alt='${product?.name}' width='200' />">
                            ${product?.name}
                        </span>
                    </td>
                    <td class="text-justify" style="display: inline-block; height: 150px; min-height: fit-content; overflow: auto; width: 100%;">${product?.description}</td>
                    <td class="text-success">$${product?.price ?? 0}</td>
                    <td class="${!product?.is_sales? "text-danger":"text-success"}">${product?.status_sale_text}</td>
                    <td>
                      <div class="d-flex flex-row flex-wrap gap-3">
                        <button class="btn btn-warning" data-productId=${product?.id}>
                            <i class="fa-solid fa-pen text-white" data-productId=${product?.id}></i>
                        </button>
                        <button class="btn btn-danger btnDeleteProduct" data-productId=${product?.id} data-bs-toggle="modal" data-bs-target="#staticBackdropDeleteProduct">
                          <i class="fa-solid fa-trash-can btnDeleteProduct" data-productId=${product?.id}></i>
                        </button>
                      </div>
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
        renderDatatable(page, perPage, name, status, price_from, price_to);

        //* ++++++++++++++++++++ HANDLE DELETE PRODUCT ++++++++++++++++++++ *//
        const staticBackdropDeleteProduct = new bootstrap.Modal(document.getElementById(
          'staticBackdropDeleteProduct'), {
          keyboard: false
        });

        $('#table-body').on('click', event => {
          // If not the button show modal to toggle delete and Break function.
          const isBtnDeleteProduct = event.target.classList.value.includes('btnDeleteProduct')

          if (isBtnDeleteProduct) {
            const {
              productid: productId,
            } = event.target.dataset ?? {};

            $('#productIdDelete').val(productId);
            $('.content-delete').html(
              `Bạn có muốn <span class='fw-bolder'>xóa</span><br/>
              sản phẩm <span class='fw-bolder'>${productId}</span> không`
            );
          }
        });

        $('#delete-product-form').on('submit', event => {
          event.preventDefault();

          const {
            productId,
          } = getData(event);
          const url = `{{ route('product.delete', ['product' => ':id']) }}`.replace(':id', productId);

          $.ajax({
            url: url,
            type: 'PATCH',
            data: {
              status: status,
            },
            success: function(response) {
              renderDatatable(page, perPage, name, status, price_from, price_to);
              event.target.reset();
              staticBackdropDeleteProduct?.hide();
              alert('Xóa sản phẩm thành công');
            },
            error: function(error) {
              alert('Không thể xử lý dữ liệu');
              console.error(error);
            }
          });
        });


        $('#table-body').on('mouseover', (event) => {
          const isProductName = event.target.classList.value.includes('product-name');
          if (isProductName) {
            const tooltip = event.target.querySelector('[data-toggle="tooltip"]');
            $(tooltip).tooltip({
              animated: 'fade',
              html: true
            });
          }
        })
      });
    </script>

  </main>
@endsection
