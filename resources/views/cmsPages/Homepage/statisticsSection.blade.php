<h1 class="text-center mb-3">Statistics Section</h1>
<div>
    <h4>Images</h4>
    <div class="mx-4 mt-4">
        <div class="imageContainer mb-3">
            <h3>First Image</h3>
            <div class="row">
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Statistics Image 1</label>
                    <img src="{{ asset('images/' . optional($fieldData)->statisticsImage1) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="statisticsImage1" id="banner_img" accept="image/*">
                </div>
                <div class="col-6">
                    <label for="bannerTitle1" class="col-sm-4 col-form-label">Statistics Title 1</label>
                    <textarea class="ckeditor form-control" name="statisticsTitle1" id="statisticsTitle1" placeholder="Description">{{ optional($fieldData)->statisticsTitle1 }}</textarea>
                </div>

            </div>
        </div>
        <div class="imageContainer mb-3">
            <h3>Second Image</h3>
            <div class="row">
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Statistics Image 2</label>
                    <img src="{{ asset('images/' . optional($fieldData)->statisticsImage2) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="statisticsImage2" id="banner_img" accept="image/*">
                </div>

            </div>
        </div>
        <div class="imageContainer mb-3">
            <h3>Third Image</h3>
            <div class="row">
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Statistics Image 3</label>
                    <img src="{{ asset('images/' . optional($fieldData)->statisticsImage3) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="statisticsImage3" id="banner_img" accept="image/*">
                </div>

            </div>
        </div>




    </div>
</div>
