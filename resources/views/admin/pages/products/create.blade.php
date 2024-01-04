@extends('admin.layout.layout')

@section('title')
  Product Manager Page
@endsection

@section('MoreJsPlugin')
  <script src="{{ asset('ckeditor5/build/ckeditor.js') }}"></script>
@endsection


@section('content')
  <main class="d-flex flex-column">

    <div class="container d-flex flex-row flex-wrap align-items-center justify-content-between py-5">
      <h1>Thêm sản phẩm</h1>

      <!-- Breadcrumb -->
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
          <a class="breadcrumb-item" href="{{ route('product.index') }}">Sản phẩm</a>
          <a class="breadcrumb-item active text-decoration-none" aria-current="page" href="{{ route('product.create') }}">
            Thêm sản phẩm
          </a>
        </ol>
      </nav>

    </div>

    <!-- Form -->
    <div class="container">
      <form id="form-product" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('POST') }}

        <div class="row">

          <!-- Left Fields -->
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">

            <div class="mb-3">
              <label for="productName" class="form-label">Tên sản phẩm</label>
              <input name="name" type="text" class="form-control" id="productName" placeholder="Nhập tên sản phảm">
              <div class="text-danger" id="productNameError"></div>
            </div>

            <div class="mb-3">
              <label for="productPrice" class="form-label">Giá bán</label>
              <input name="price" type="text" class="form-control" id="productPrice" placeholder="Nhập tên sản phảm">
              <div class="text-danger" id="productPriceError"></div>
            </div>

            <div class="mb-3">
              <label for="editor" class="form-label">Mô tả</label>
              <div id="editor"></div>
            </div>

            <div class="mb-3">
              <label for="productStatus" class="form-label">Trạng thái</label>
              <select class="form-select" id="productStatus" name="is_sales">
                <option value="" selected>Mặc định</option>
                <option value="0">Ngừng bán</option>
                <option value="1">Đang bán</option>
                <option value="2">Hết hàng</option>
              </select>
              <div class="text-danger" id="productStatusError"></div>
            </div>
          </div>

          <!-- Right Fields -->
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">

            <!-- Show image -->
            <div class="border text-center">
              <img class="img-fluid img-thumbnail" id="fileUploadPreview"
                src="https://via.placeholder.com/400?text=Product%20Image" style="max-height: 400px" />
            </div>

            <!-- Show error -->
            <div class="text-danger" id="productFileUploadError"></div>

            <!-- Show custom input and button field -->
            <div class="d-flex flex-wrap gap-3 align-items-center justify-content-center mt-3">
              <label class="btn btn-primary" for="fileUpload">Upload</label>
              {{-- fileUpload: will be convert to 'image' field in controller --}}
              <input name="fileUpload" type="file" accept=".png, .jpg, .jpeg" class="form-control d-none"
                id="fileUpload">
              <button id="clearFileUpload" type="button" class="btn btn-danger">Xóa file</button>
              <input id="fileUploadImageName" class="input-group-text flex-grow-1" type="text" disabled
                value="Tên file upload">
            </div>

          </div>

          <!-- Action buttons -->
          <div class="col-12 text-end mt-5">
            <a href="{{ route('product.index') }}" class="btn btn-secondary btn-lg">Hủy</a>
            <button type="submit" class="btn btn-danger btn-lg">Lưu</button>
          </div>

        </div>
      </form>
    </div>


    <script>
      let editor;
      ClassicEditor
        .create(document.querySelector('#editor'))
        .then(newEditor => {
          editor = newEditor;
        })
        .catch(error => {
          console.error(error);
        });

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


      // Create validate functions
      const checkProductName = (name = '') => {
        if (name?.length === 0) return "Vui lòng nhập tên sản phẩm";
        else if (name?.length <= 5) return "Tên sản phẩm phải lớn hơn 5 ký tự";
        return "";
      }
      const checkProductPrice = (price = '') => {
        if (price?.length === 0) return "Giá bán không được để trống";
        else if (Number(price).toString() === 'NaN') return "Giá bán chỉ được nhập số";
        else if (Number(price) < 0) return "Giá bán không được nhỏ hơn 0";
        return "";
      }
      const checkProductStatus = (status = '') => {
        if (status?.length === 0) return "Trạng thái không được để trống";
        return "";
      }
      const showErrorProductImage = async (file) => {
        if (!file) return $('#productFileUploadError').html(null);

        if (file.size > 2097152) {
          return $('#productFileUploadError').html("Dung lượng hình không quá 2Mb");
        } else {
          $('#productFileUploadError').html(null);
        }

        const image = new Image();
        image.src = URL.createObjectURL(file);

        image.onload = function() {
          if (image.naturalWidth > 1024 || image.naturalHeight > 1024) {
            return $('#productFileUploadError').html("Kích thước ảnh không vượt quá 1024px");
          } else {
            $('#productFileUploadError').html(null);
          }
        }

      }
      const checkProductImage = () => {
        return $('#productFileUploadError').html();
      }

      // Validate fields on Change
      $('#productName').on('input', (event) => {
        const name = event.target.value;
        const productNameError = checkProductName(name)
        $('#productNameError').html(productNameError);
      });

      $('#productPrice').on('input', (event) => {
        const price = event.target.value;
        const productPriceError = checkProductPrice(price)
        $('#productPriceError').html(productPriceError);
      });

      $('#productStatus').on('input', (event) => {
        const status = event.target.value;
        const productStatusError = checkProductStatus(status)
        $('#productStatusError').html(productStatusError);
      });

      // Handle Preview Image
      $('#fileUpload').on('change', event => {
        const [file] = event.target.files;

        if (file) {
          const image = URL.createObjectURL(file);
          const imageName = file?.name ?? 'image-name-error-text';

          $('#fileUploadPreview').attr('src', image);
          $('#fileUploadImageName').val(imageName);

          showErrorProductImage(file);
        }
      });

      $('#clearFileUpload').on('click', event => {
        // Load init data
        $('#fileUploadPreview').attr('src', 'https://via.placeholder.com/400?text=Product%20Image');
        $('#fileUploadImageName').val('Tên file upload'); // clear name of file
        $('#fileUpload').val(null); // clear file input
        $('#productFileUploadError').html(null); // clear error
      });

      // Handle Submit form
      $('#form-product').on('submit', (event) => {
        event.preventDefault();

        const {
          name,
          price,
          is_sales,
          fileUpload,
        } = getData(event);
        const descriptionEditorData = editor.getData();

        // Validate when submit form
        const productNameError = checkProductName(name);
        const productPriceError = checkProductPrice(price);
        const productStatusError = checkProductStatus(is_sales);
        // No return value
        const productImageError = checkProductImage();

        // Show string error or empty after validate
        $('#productNameError').html(productNameError);
        $('#productPriceError').html(productPriceError);
        $('#productStatusError').html(productStatusError);


        // Stop if has any errors
        if (productNameError || productPriceError || productStatusError || productImageError) return;

        const formData = new FormData(event.target);
        formData.append('description', descriptionEditorData);

        $.ajax({
          url: `{{ route('product.store') }}`,
          method: 'POST',
          processData: false,
          contentType: false,
          data: formData,
          success: (response) => {
            window.location.href = "{{ route('product.index') }}";
          },
          error: (error) => {
            alert(error?.responseJSON?.message ?? 'Không thể xử lý dữ liệu');
            console.error(error);
          }
        })
      });
    </script>
  </main>
@endsection
