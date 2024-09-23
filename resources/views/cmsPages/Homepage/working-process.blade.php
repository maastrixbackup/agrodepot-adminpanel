<h1 class="text-center mb-3">Our Working Process Section</h1>
<div>
    <h4>Working Process Steps</h4>
    <div class="mx-4 mt-4">
        <div class="imageContainer mb-3">
            <div class="row">
                <div class="col-6">
                    <label for="step1Number" class="col-sm-4 col-form-label">Step1 Number </label>
                    <input class="form-control" name="step1Number" id="step1Number"
                        value="{{ optional($fieldData)->step1Number }}">
                </div>
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Step1 Image</label>
                    <img src="{{ asset('images/' . optional($fieldData)->step1Image) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="step1Image" id="step_img" accept="image/*">
                </div>
                <div class="col-6">
                    <label for="step1Title" class="col-sm-4 col-form-label">Step1 Title </label>
                    <input class="form-control" name="step1Title" id="step1Title"
                        value="{{ optional($fieldData)->step1Title }}">
                </div>

            </div>
        </div>
        <div class="imageContainer mb-3">
            <div class="row">
                <div class="col-6">
                    <label for="step2Number" class="col-sm-4 col-form-label">Step2 Number </label>
                    <input class="form-control" name="step2Number" id="step2Number"
                        value="{{ optional($fieldData)->step2Number }}">
                </div>
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Step2 Image</label>
                    <img src="{{ asset('images/' . optional($fieldData)->step2Image) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="step2Image" id="step_img" accept="image/*">
                </div>
                <div class="col-6">
                    <label for="step2Title" class="col-sm-4 col-form-label">Step2 Title </label>
                    <input class="form-control" name="step2Title" id="step2Title"
                        value="{{ optional($fieldData)->step2Title }}">
                </div>

            </div>
        </div>
        <div class="imageContainer mb-3">
            <div class="row">
                <div class="col-6">
                    <label for="step3Number" class="col-sm-4 col-form-label">Step3 Number </label>
                    <input class="form-control" name="step3Number" id="step3Number"
                        value="{{ optional($fieldData)->step3Number }}">
                </div>
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Step3 Image</label>
                    <img src="{{ asset('images/' . optional($fieldData)->step3Image) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="step3Image" id="step_img" accept="image/*">
                </div>
                <div class="col-6">
                    <label for="step3Title" class="col-sm-4 col-form-label">Step3 Title </label>
                    <input class="form-control" name="step3Title" id="step3Title"
                        value="{{ optional($fieldData)->step3Title }}">
                </div>

            </div>
        </div>
    </div>
</div>
