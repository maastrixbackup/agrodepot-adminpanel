<h1 class="text-center mb-3">Sale Section</h1>
<div>
    <h4>Sale Products</h4>
    <div class="mx-4 mt-4">
        <div class="imageContainer mb-3">
            <h3>Product 1</h3>
            <div class="row">
                <div class="col-6">
                    <label for="productitle1" class="col-sm-4 col-form-label form-label">Product Title 1</label>
                    <input class="form-control" value="{{ optional($fieldData)->product1title1 }}" type="text" name="product1title1" id="productitle1">
                    <label for="productitle2" class="col-sm-4 col-form-label form-label">Product Title 2</label>
                    <input class="form-control" value="{{ optional($fieldData)->product1title2 }}" type="text" name="product1title2" id="productitle2">
                </div>
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Product 1 Image</label>
                    <img src="{{ asset('images/' . optional($fieldData)->product1image ) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="product1image" id="banner_img" accept="image/*">
                </div>
            </div>
        </div>
        <div class="imageContainer mb-3">
            <h3>Product 2</h3>
            <div class="row">
                <div class="col-6">
                    <label for="productitle1" class="col-sm-4 col-form-label form-label">Product Title 1</label>
                    <input class="form-control" value="{{ optional($fieldData)->product2title1 }}"  type="text" name="product2title1" id="productitle1">
                    <label for="productitle2" class="col-sm-4 col-form-label form-label">Product Title 2</label>
                    <input class="form-control" value="{{ optional($fieldData)->product2title2 }}"  type="text" name="product2title2" id="productitle2">
                </div>
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Product 2 Image</label>
                    <img src="{{ asset('images/' . optional($fieldData)->product2image ) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="product2image" id="banner_img" accept="image/*">
                </div>
            </div>
        </div>
        <div class="imageContainer mb-3">
            <h3>Product 3</h3>
            <div class="row">
                <div class="col-6">
                    <label for="productitle1" class="col-sm-4 col-form-label form-label">Product Title 1</label>
                    <input class="form-control" value="{{ optional($fieldData)->product3title1 }}" type="text" name="product3title1" id="productitle1">
                    <label for="productitle2" class="col-sm-4 col-form-label form-label">Product Title 2</label>
                    <input class="form-control" value="{{ optional($fieldData)->product3title2 }}" type="text" name="product3title2" id="productitle2">
                </div>
                <div class="col-6">
                    <label for="input40" class="col-sm-4 col-form-label">Product 3 Image</label>
                    <img src="{{ asset('images/' . optional($fieldData)->product3image) }}" alt="image" id="pImage"
                        style="width:20%">
                    <input type="file" class="form-control" name="product3image" id="banner_img" accept="image/*">
                </div>
            </div>
        </div>


    </div>
</div>
