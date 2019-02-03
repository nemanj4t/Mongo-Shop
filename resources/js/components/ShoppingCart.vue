<template>
    <div class="dropdown">
        <a href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-shopping-cart"></i>
            <span>Your Cart</span>
            <div class="qty">3</div>
        </a>
        <div class="dropdown-menu p-4" aria-labelledby="dropdownMenuLink">
            <div class="cart-list">
                <div class="product-widget">
                    <div class="product-img">
                        <img src="http://www.independentmediators.co.uk/wp-content/uploads/2016/02/placeholder-image.jpg" alt="">
                    </div>
                    <div class="product-body">
                        <h3 class="product-name"><a href="#">product name goes here</a></h3>
                        <h4 class="product-price"><span class="qty">1x</span>$980.00</h4>
                    </div>
                    <button class="delete"><i class="fas fa-window-close"></i></button>
                </div>


            </div>
            <div class="cart-summary">
                <small>3 Item(s) selected</small>
                <h5>SUBTOTAL: $2940.00</h5>
            </div>
            <div class="cart-btns">
                <a href="#">View Cart</a>
                <a href="#">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
