<template>
    <div>
        <div class="product">
            <div class="product-img">
                <img src="http://www.independentmediators.co.uk/wp-content/uploads/2016/02/placeholder-image.jpg" alt="" />
            </div>
            <div class="product-body">
                <p class="product-category">{{category_name}}</p>
                <h3 class="product-name"><a href="#">{{name}}</a></h3>
                <h4 class="product-price">{{price}} <del class="product-old-price">$990.00</del></h4>
                <div class="product-rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
                <div class="product-btns">
                    <button class="add-to-wishlist"><i class="fas fa-heart"></i><span class="tooltipp">add to wishlist</span></button>
                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                </div>
            </div>
            <div class="add-to-cart">
                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['name', 'price', 'category_name'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
