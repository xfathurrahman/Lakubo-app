<div class="add-to-cart product_data">
    <button class="">
        <input type="hidden" class="qty_input" name="product_qty" value="1">
        <input type="hidden" class="prod_id" name="product_id" value="{{ $product->id }}">
        <input type="hidden" class="store_id" name="store_id" value="{{ $product->stores->id }}">
        <button type="button" class="btn addToCartBtn">
            <i class="fa fa-cart-plus" aria-hidden="true"></i>
        </button>
    </button>
</div>
