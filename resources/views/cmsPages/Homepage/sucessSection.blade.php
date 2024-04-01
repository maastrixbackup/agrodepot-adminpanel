<h1 class="text-center mb-3">Success Section</h1>
<div>
    <h4>Reviews</h4>
    <div class="mx-4 mt-4">
        <div class="imageContainer mb-3">
            <h3>{{ optional($fieldData)->successTitle1 }}</h3>
            <div class="row">
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Success Icon 1</label>
                    <img src="{{ asset('images/' . optional($fieldData)->successIcon1) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="successIcon1" id="banner_img" accept="image/*">
                    <label for="productitle2" class="col-sm-4 col-form-label form-label">Success Title 1</label>
                    <input class="form-control" value="{{ optional($fieldData)->successTitle1 }}"  type="text" name="successTitle1" id="productitle2">
                </div>
                <div class="col-6">
                    <label for="bannerTitle1" class="col-sm-4 col-form-label">Success Description 1</label>
                    <textarea class="ckeditor form-control" name="successDesc1" id="statisticsTitle1" placeholder="Description">{{ optional($fieldData)->successDesc1 }}</textarea>
                </div>

            </div>
        </div>
        <div class="imageContainer mb-3">
            <h3>{{ optional($fieldData)->successTitle2 }}</h3>
            <div class="row">
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Success Icon 2</label>
                    <img src="{{ asset('images/' . optional($fieldData)->successIcon2) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="successIcon2" id="banner_img" accept="image/*">
                    <label for="productitle2" class="col-sm-4 col-form-label form-label">Success Title 2</label>
                    <input class="form-control" value="{{ optional($fieldData)->successTitle2 }}"  type="text" name="successTitle2" id="productitle2">
                    <label for="productitle2" class="col-sm-4 col-form-label form-label">Success Text</label>
                    <input class="form-control" value="{{ optional($fieldData)->successText }}"  type="text" name="successText" id="productitle2">
                </div>
                <div class="col-6">
                    <label for="bannerTitle1" class="col-sm-4 col-form-label">Success Description 1</label>
                    <textarea class="ckeditor form-control" name="successDesc2" id="statisticsTitle1" placeholder="Description">{{ optional($fieldData)->successDesc2 }}</textarea>
                </div>

            </div>
        </div>
        <div class="imageContainer mb-3">
            <h3>{{ optional($fieldData)->successTitle3 }}</h3>
            <div class="row">
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Success Icon 3</label>
                    <img src="{{ asset('images/' . optional($fieldData)->successIcon3) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="successIcon3" id="banner_img" accept="image/*">
                    <label for="productitle2" class="col-sm-4 col-form-label form-label">Success Title 3</label>
                    <input class="form-control" value="{{ optional($fieldData)->successTitle3 }}"  type="text" name="successTitle3" id="productitle2">
                </div>
                <div class="col-6">
                    <label for="bannerTitle1" class="col-sm-4 col-form-label">Success Description 3</label>
                    <textarea class="ckeditor form-control" name="successDesc3" id="statisticsTitle1" placeholder="Description">{{ optional($fieldData)->successDesc3 }}</textarea>
                </div>

            </div>
        </div>





    </div>
</div>
