<!DOCTYPE html>
<html>

<head>
    <title>Brand CRUD</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Brand CRUD</h1>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#brandModal"
            onclick="createBrand()">ADD</button>
        <table class="table table-bordered" id="brandTable">
            <thead>
                <tr>
                    <th>S.no</th>
                    <th>Brand Code</th>
                    <th>Brand Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>App View</th>
                    <th>edit</th>
                    <th>delete</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="modal fade" tabindex="1" id="brandModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="brandForm">
                    <div class="modal-header">
                        <h3 class='modal-title'>Brand CRUD</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="brand_id">
                        <div class="mb-3">
                            <label>Brand Code</label>
                            <input type="text" class="form-control" id="brand_code">
                            <span class="text-danger" id="brand_code_error"></span>
                        </div>
                        <div class="mb-3">
                            <label>Brand name</label>
                            <input type="text" class="form-control" id="brand_name">
                            <span class="text-danger" id="brand_name_error"></span>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <input type="text" class="form-control" id="description">
                            <span class="text-danger" id="description_error"></span>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select id="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <span class="text-danger" id="brand_status_error"></span>
                        </div>
                        <div class="mb-3">
                            <label>In-App View</label>
                            <select id="inapp_view" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <span class="text-danger" id="brand_inapp_view_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="saveBrand()"> Save</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"> Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });

        const brandBaseUrl = "{{ route('admin.brands.data') }}";
        const brandStoreUrl = "{{ route('admin.brands.store') }}";

        let brandModel;

        $(document).ready(function () {
            brandModel = new bootstrap.Modal(document.getElementById('brandModal'));
            loadBrands();
        });



        function loadBrands() {
            $.get(brandBaseUrl, function (show_data) {
                let rows = '';
                $.each(show_data, function (i, brand) {
                    rows += `<tr>
                        <td>${i + 1}</td>
                        <td>${brand.brand_code}</td>
                        <td>${brand.brand_name}</td>
                        <td>${brand.description}</td>
                        <td>${brand.status}</td>
                        <td>${brand.inapp_view == 1 ? 'YES' : 'No'}</td>
                        <td><button  type="button" class="btn btn-success" onclick="editBrand(${brand.id})">Edit</button></td>
                        <td><button type="button" class="btn btn-danger" onclick="deleteBrand(${brand.id})">Delete</button></td>
                        </tr>`;
                });
                $('#brandTable tbody').html(rows);
            });
        }

        function createBrand() {
            $('#brandForm')[0].reset();
            $('#brand_id').val('');
            $('.text-danger').text('');
        }

        function editBrand(id) {
            $.get(`${brandStoreUrl}/${id}`, function (brand) {
                $('#brand_id').val(brand.id);
                $('#brand_code').val(brand.brand_code);
                $('#brand_name').val(brand.brand_name);
                $('#description').val(brand.description);
                $('#status').val(brand.status);
                $('#inapp_view').val(brand.inapp_view);
                $('.text-danger').text('');
                brandModel.show();
            });
        }

        function saveBrand() {
            let id = $('#brand_id').val();
            let url = id ? `${brandStoreUrl}/${id}` : brandStoreUrl;
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: {
                    brand_code: $('#brand_code').val(),
                    brand_name: $('#brand_name').val(),
                    description: $('#description').val(),
                    status: $('#status').val(),
                    inapp_view: $('#inapp_view').val(),
                },
                success: function (response) {
                    $('text-danger').text('');
                    brandModel.hide();
                    loadBrands();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $(`#${key}_error`).text(value[0]);
                        });
                    }
                }
            });
        }
        function deleteBrand(id) {
            $.ajax({
                url: `${brandStoreUrl}/${id}`,
                method: 'DELETE',
                success: function () {
                    loadBrands();
                },
            });
        }



    </script>


</body>

</html>