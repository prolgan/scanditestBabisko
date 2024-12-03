<form id="product_form" name="product_form" action="newItem" method="POST">
    <div class="row">
        <div class="col-2">
            <p>SKU</p>
        </div>
        <div class="col-4">
            <input type="text" class="form-control" id="sku" name="sku" required>
        </div>
        <div class="col-6"></div>
        <div class="col-2">
            <p>Name</p>
        </div>
        <div class="col-4">
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="col-6"></div>
        <div class="col-2">
            <p>Price ($)</p>
        </div>
        <div class="col-4">
            <input type="Number" class="form-control" id=price name="price" required>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-2">
            <label for="productType">Type Switcher</label>
        </div>
        <div class="col-4">
            <select name="productType" id="productType" class="form-select">
                <option id="#DVD" value="DVD" selected>DVD</option>
                <option id="#Furniture "value="Furniture">Furniture</option>
                <option id='#Book' value="Book">Book</option>
            </select>
        </div>
    </div>

    <div class="row mt-3 d-none hideObj" id="DVD">
        <div class="col-2">
            <p>Size (MB)</p>
        </div>
        <div class="col-4">
            <input type="Number" class="form-control reqInput DVD" id="size" name="size">
        </div>
        <div class="col-6"></div>
        <div class="col-6 alert alert-warning mt-3">
            Please, provide size
        </div>
    </div>

    <div class="row mt-3 d-none hideObj" id="Furniture">
        <div class="col-2">
            <p>Height (CM)</p>
        </div>
        <div class="col-4">
            <input type="Number" class="form-control reqInput Furniture" id="height" name="height">
        </div>
        <div class="col-6"></div>
        <div class="col-2">
            <p>Width (CM)</p>
        </div>
        <div class="col-4">
            <input type="Number" class="form-control reqInput Furniture" id="width" name="width">
        </div>
        <div class="col-6"></div>
        <div class="col-2">
            <p>Length (CM)</p>
        </div>
        <div class="col-4">
            <input type="Number" class="form-control reqInput Furniture" id="length" name="length">
        </div>
        <div class="col-6"></div>
        <div class="col-6 alert alert-warning mt-3">
            Please, provide dimensions
        </div>

    </div>

    <div class="row mt-3 d-none hideObj" id="Book">
        <div class="col-2">
            <p>Weigth (KG)</p>
        </div>
        <div class="col-4">
            <input type="Number" class="form-control reqInput Book" id="weight" name="weight">
        </div>
        <div class="col-6"></div>
        <div class="col-6 alert alert-warning mt-3">
            Please, provide weight
        </div>
    </div>

</form>