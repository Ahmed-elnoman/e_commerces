<div class="modal fade" id="categoryModel" tabindex="-1" aria-labelledby="categoryModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">
                <form action="/products/submit" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_method" data-ng-if="productUpdate !== false" value="put">
                    <input type="hidden" name="product_id"
                        data-ng-value="productUpdate !== false ? products[productUpdate].id : 0">
                    @csrf
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Home</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-sel-tags-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-sel-tags" type="button" role="tab"
                                aria-controls="pills-sel-tags" aria-selected="false">SEO TAGS</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-details-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-details" type="button" role="tab"
                                aria-controls="pills-details" aria-selected="false">Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-images-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-images" type="button" role="tab"
                                aria-controls="pills-images" aria-selected="false">Produtc Images</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <div class="mb-3">
                                <label for="">categories</label>
                                <select name="category" class="form-select" required>
                                    <option value="0">----</option>
                                    <option data-ng-repeat="category in categories" data-ng-value="category.id"
                                        ng-bind="category.category_name"></option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Product name</label>
                                <input type="text" class="form-control" name="product_name"
                                    data-ng-value="products[productUpdate].product_name" required />
                            </div>


                            <div class="mb-3">
                                <label>Brnads name</label>
                                <select name="brand" class="form-select" required>
                                    <option value="0">----</option>
                                    <option data-ng-repeat="brand in brands" data-ng-value="brand.id"
                                        ng-bind="brand.brand_name"></option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Product Description</label>
                                <textarea name="product_descrpiton" class="form-control" cols="30" rows="10" required><%products[productUpdate].product_description%></textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-sel-tags" role="tabpanel"
                            aria-labelledby="pills-sel-tags-tab" tabindex="0">
                            <div class="mb-3">
                                <label>Product Meta Title</label>
                                <input type="text" class="form-control" name="meta_title"
                                    data-ng-value="products[productUpdate].product_meta_name" required />
                            </div>
                            <div class="mb-3">
                                <label>Product Meta Key</label>
                                <input type="text" class="form-control" name="meta_ket"
                                    data-ng-value="products[productUpdate].product_meta_key" required />
                            </div>
                            <div class="mb-3">
                                <label>Product Meta Descripton</label>
                                <textarea name="meta_descrption" class="form-control" cols="30" rows="10" required><%products[productUpdate].product_meta_description%></textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-details" role="tabpanel"
                            aria-labelledby="pills-details-tab" tabindex="0">
                            <div class="mb-3">
                                <label>Origin Price</label>
                                <input type="text" class="form-control" name="origin_price"
                                    data-ng-value="products[productUpdate].product_original_price" required />
                            </div>
                            <div class="mb-3">
                                <label>Selling Price</label>
                                <input type="text" class="form-control" name="selling_price"
                                    data-ng-value="products[productUpdate].product_selling_price" required />
                            </div>
                            <div class="mb-3">
                                <label>Product Quintity</label>
                                <input type="text" class="form-control" name="quintity"
                                    data-ng-value="products[productUpdate].product_quantity" required />
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-images" role="tabpanel"
                            aria-labelledby="pills-images-tab" tabindex="0">
                            <div class="mb-3">
                                <label>Product Image</label>
                                <input type="file" name="image" class="form-control" multiple required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mt-3">
                        <button type="button" class="btn btn-outline-secondary me-auto"
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
