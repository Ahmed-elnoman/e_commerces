<div class="modal fade" id="categoryModel" tabindex="-1" aria-labelledby="categoryModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <form action="/brands/submit" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_method" data-ng-if="brandUpdate !== false" value="put">
                    <input type="hidden" name="brand_id" data-ng-value="brands[brandUpdate].id">
                    @csrf
                    <div class="mb-3">
                        <label id="cate_name">Brnad Name</label>
                        <input type="text" name="brand_name" id="cate_name" class="form-control"
                            data-ng-value="brands[brandUpdate].brand_name">
                    </div>
                    <div class="d-flex mt-3">
                        <button type="button" class="btn btn-outline-secondary me-auto "
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_active" tabindex="-1" aria-labelledby="editStatusCategoryModelLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-body">
                <form action="/brands/change_status" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_method" data-ng-if="brandUpdate !== false" value="put">
                    <input type="hidden" name="brand_id" data-ng-value="brands[brandUpdate].id">
                    <input type="hidden" name="brand_status" data-ng-value="brands[brandUpdate].brand_status">
                    @csrf
                    <div class="mb-3">
                        <p>Are you sure the status has changed?</p>
                    </div>
                    <div class="d-flex mt-3">
                        <button type="button" class="btn btn-outline-secondary me-auto "
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
