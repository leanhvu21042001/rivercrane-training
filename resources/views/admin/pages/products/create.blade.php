@extends('admin.layout.layout')

@section('title')
  Product Manager Page
@endsection


@section('content')
  <main class="d-flex flex-column">

    <div class="container d-flex flex-row flex-wrap align-items-center justify-content-between py-5">
      <h1>Danh sách sản phẩm</h1>

      <!-- Breadcrumb -->
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
          <a class="breadcrumb-item" href="{{ route('product.index') }}">Sản phẩm</a>
          <a class="breadcrumb-item active text-decoration-none" aria-current="page" href="{{ route('product.create') }}">
            Chi tiết sản phẩm
          </a>
        </ol>
      </nav>

    </div>

    <!-- Form -->
    <div class="container">
      <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('POST') }}

        <div class="row">

          <!-- Left Fields -->
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
            <div class="mb-3">
              <label for="productName" class="form-label">Tên sản phẩm</label>
              <input name="name" type="text" class="form-control" id="productName" placeholder="Nhập tên sản phảm">
            </div>
            <div class="mb-3">
              <label for="productPrice" class="form-label">Giá bán</label>
              <input name="price" type="text" class="form-control" id="productPrice" placeholder="Nhập tên sản phảm">
            </div>
            <div class="mb-3">
              <label for="productDescription" class="form-label">Mô tả</label>
              <textarea name="description" class="form-control" id="productDescription" rows="10" placeholder="Mô tả sản phẩm"></textarea>
            </div>
            <div class="mb-3">
              <label for="productStatus" class="form-label">Trạng thái</label>
              <select class="form-select" id="productStatus" name="is_sales">
                <option value="" selected>Mặc định</option>
                <option value="0">Ngừng bán</option>
                <option value="1">Đang bán</option>
                <option value="2">Hết hàng</option>
              </select>
            </div>
          </div>

          <!-- Right Fields -->
          <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">

            <div class="border text-center">
              <img class="img-fluid img-thumbnail" id="preview"
                src="https://via.placeholder.com/400?text=Product%20Image" />
            </div>

            <div class="d-flex flex-wrap gap-3 align-items-center justify-content-center mt-3">
              <label class="btn btn-primary" for="fileUpload">Upload</label>
              {{-- fileUpload: will be convert to 'image' field in controller --}}
              <input name="fileUpload" type="file" class="form-control d-none" id="fileUpload">
              <button class="btn btn-danger">Xóa file</button>
              <input class="input-group-text" type="text" disabled value="Tên file upload">
            </div>

          </div>

          <!-- Action buttons -->
          <div class="col-12 text-end mt-5">
            <button class="btn btn-secondary btn-lg">Hủy</button>
            <button class="btn btn-danger btn-lg">Lưu</button>
          </div>

        </div>
      </form>
    </div>


    <script></script>
  </main>
@endsection
