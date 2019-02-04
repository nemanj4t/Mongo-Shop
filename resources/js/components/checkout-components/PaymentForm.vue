<template>
    <div class="row">
        <div class="col-md-6">
            <form action="/checkout" method="POST" id="payment-form" @submit.prevent="pay()">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email">
                </div>

                <div class="form-group">
                    <label for="name_on_card">Name on Card</label>
                    <input type="text" class="form-control" id="name_on_card" name="name_on_card" v-model="name_on_card">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="postalcode">Postal Code</label>
                            <input type="text" class="form-control" id="postalcode" name="postalcode">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label for="card-element">Credit Card</label>
                    <card-element></card-element>
                </div>

                <!-- CSRF Field -->
                <input type="hidden" name="_token" :value="csrf">

                <div class="spacer"></div>

                <button type="submit" class="btn btn-success" :disabled="shoppingCart.items == 0">Submit Payment</button>
            </form>
        </div>
        <div class="col-md-6">
            <div v-if="shoppingCart.item = 0">
                <p>Your shopping cart is empty</p>
            </div>
            <div class="cart-summary">
                <small>{{shoppingCart.items}} Item(s) selected</small>
                <h5>SUBTOTAL: ${{shoppingCart.price}}</h5>
            </div>
            <div v-for="product in shoppingCart.products" class="product-widget">
                <div>
                    <img class="product-img-large" src="http://www.independentmediators.co.uk/wp-content/uploads/2016/02/placeholder-image.jpg" alt="">
                </div>
                <div class="product-body">
                    <p class="product-name"><a href="#">{{product.product.name}} - {{product.quantity}} x ${{product.product.price}}</a></p>
                </div>
                <button class="delete"><i class="fas fa-window-close"></i></button>
            </div>
        </div>
    </div>
</template>


<script>
    import { createToken, Card } from 'vue-stripe-elements-plus'
    export default {
        data () {
            return {
              csrf: document.head.querySelector('meta[name="csrf-token"]').content,
              name_on_card: '',
            }
        },
        methods: {
            pay () {
              // createToken returns a Promise which resolves in a result object with
              // either a token or an error key.
              // See https://stripe.com/docs/api#tokens for the token object.
              // See https://stripe.com/docs/api#errors for the error object.
              // More general https://stripe.com/docs/stripe.js#stripe-create-token.
              var options = {
                name: this.name_on_card,
              }
              createToken(options).then(result => {
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', result.token.id);
                form.appendChild(hiddenInput);

                //shoppingcart data
                //var hiddenInput = document.createElement('input');
                //hiddenInput.setAttribute('type', 'hidden');
                //hiddenInput.setAttribute('name', 'shoppingcart');
                //hiddenInput.setAttribute('value', this.shopping_cart);
                //this.$el.appendChild(hiddenInput);

                // Submit the form
                form.submit();
              });
            }
      },
      computed: {
            shoppingCart() {
                console.log(this.$store.getters.returnShoppingCart);
                return this.$store.getters.returnShoppingCart;             
            }
        },

        mounted() {
            console.log(this.$session.getAll());
        }
    }
</script>

<style scoped>
    .product-img-large {
        width: 300px;
    }
</style>