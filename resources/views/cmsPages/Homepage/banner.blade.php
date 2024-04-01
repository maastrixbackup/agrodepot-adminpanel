<h1 class="text-center mb-3">Banner Section</h1>
<div>
    <h4>Banner Images</h4>
    <div class="mx-4 mt-4">
        <div class="imageContainer mb-3">
            <h3>First Image</h3>
            <div class="row">
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Banner Image 1</label>
                    <img src="{{ asset('images/' . optional($fieldData)->bannerImage1) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="bannerImage1" id="banner_img" accept="image/*">
                </div>
                <div class="col-6">
                    <label for="bannerTitle1" class="col-sm-4 col-form-label">Banner Title 1</label>
                    <textarea class="ckeditor form-control" name="bannerTitle1" id="bannerTitle1" placeholder="Description">{{ optional($fieldData)->bannerTitle1 }}</textarea>
                </div>

            </div>
        </div>
        <div class="imageContainer mb-3">
            <h3>Second Image</h3>
            <div class="row">
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Banner Image 2</label>
                    <img src="{{ asset('images/' . optional($fieldData)->bannerImage2 ?? null) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="bannerImage2" id="banner_img" accept="image/*">
                </div>
                <div class="col-6">
                    <label for="bannerTitle2" class="col-sm-4 col-form-label">Banner Title 2</label>

                    <textarea class="ckeditor form-control" name="bannerTitle2" id="bannerTitle2" placeholder="Description">{{ optional($fieldData)->bannerTitle2 ?? null }}</textarea>
                </div>

            </div>
        </div>
        <div class="imageContainer mb-3">
            <h3>Third Image</h3>
            <div class="row">
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Banner Image 3</label>
                    <img src="{{ asset('images/' . optional($fieldData)->bannerImage3 ?? null) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="bannerImage3" id="banner_img" accept="image/*">
                </div>
                <div class="col-6">
                    <label for="bannerTitle2" class="col-sm-4 col-form-label">Banner Title 3</label>

                    <textarea class="ckeditor form-control" name="bannerTitle3" id="bannerTitle3" placeholder="Description">{{ optional($fieldData)->bannerTitle3 ?? null }}</textarea>
                </div>

            </div>
        </div>
        <div class="imageContainer mb-3">
            <h3>Fourth Image</h3>
            <div class="row">
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Banner Image 4</label>
                    <img src="{{ asset('images/' . optional($fieldData)->bannerImage4 ?? null) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="bannerImage4" id="banner_img" accept="image/*">
                </div>
                <div class="col-6">
                    <label for="bannerTitle4" class="col-sm-4 col-form-label">Banner Title 4</label>

                    <textarea class="ckeditor form-control" name="bannerTitle4" id="bannerTitle4" placeholder="Description">{{ optional($fieldData)->bannerTitle4 ?? null }}</textarea>
                </div>

            </div>
        </div>
    </div>
</div>
