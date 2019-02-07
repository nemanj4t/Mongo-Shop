<template>
    <div>
        <div class="product">
            <div class="product-img">
                <img :src="product.image" alt="" />
            </div>
            <div class="product-body">
                <p class="product-category">{{category_name}}</p>
                <h3 class="product-name"><a :href="'/products/' + product._id">{{product.name}}</a></h3>
                <h4 class="product-price">${{product.price}}</h4>
                <div v-if="'grade' in product" class="product-rating">
                    <i v-for="n in Math.round(product.grade)" class="fa fa-star ml-1"></i>
                </div>
                <div v-else class="product-rating">
                </div>
                <div class="product-btns">
                    <button v-if="user === 'auth'" @click="addToWishList(product)" class="add-to-wishlist"><i class="fas fa-heart"></i><span class="tooltipp">add to wishlist</span></button>
                    <button @click="goToPage" class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                </div>
            </div>
            <div class="add-to-cart">
                <button @click="addToCart(product)" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
            </div>
        </div>
    </div>
</template>

<script>

    import { mapState, mapMutations } from 'vuex'

    export default {
        props: ['product', 'category_name', 'user'],
        computed: {
            getWishes() {
                return this.$store.getters.returnWishes;
            }
        },
        methods: {
            ...mapMutations([
                'ADD_PRODUCT_TO_CART',
                'ADD_PRODUCT_TO_WISH_LIST'
            ]),

            addToCart(product) {
                let cartItem = {};
                cartItem.product = product;
                cartItem.quantity = 1;
                axios.post('/shoppingcart/add', {
                    'newProduct' : cartItem
                }).then(response => {
                    this.ADD_PRODUCT_TO_CART(cartItem);
                });
            },

            addToWishList(product) {
                let index = -1;
                this.getWishes.products.forEach(element => {
                    if(element._id === product._id) {
                        index = 0;
                    }
                });

                if(!(index > -1)) {
                    this.ADD_PRODUCT_TO_WISH_LIST(product);
                    axios.post('/wishes', {
                        'product_id' : product._id,
                    });
                }
            },

            goToPage() {
                window.location.href='/products/' + this.product._id;
            }
        },

        mounted() {
            console.log(this.product);
        }
    }
</script>
