<template>
    <div>
        <br>
        <div class="table">
            <table class="table table-striped mb-5">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th><router-link to="/products/create"><button class="btn btn-primary float-right">Add</button></router-link></th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products">
                        <td>{{product._id}}</td>
                        <td><img id="img" :src="product.image"></td>
                        <td>{{product.name}}</td>
                        <td>/</td>
                        <td>0</td>
                        <td>
                            <div class = "row">
                                <button class="btn btn-sm btn-danger float-right ml-2" @click="deleteProduct(product)">Delete</button>
                                <router-link :to="'/products/edit/'+ product._id"  ><button class="btn btn-sm btn-primary float-right ml-2">Edit</button></router-link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            products: []
        }
    },

    methods: {
        deleteProduct(product) {
            axios.delete('/products/' + product._id)
                .then(response => {console.log(response); this.products.splice(this.products.indexOf(product), 1);})
                .catch(error => console.log(error));
        }
    },

    mounted() {
        axios.get('/api/products')
            .then(response => {console.log(response); this.products = response.data})
            .catch(error => console.log(error));
    }
}
</script>

<style>
    #img
    {
        max-width: 50px;
    }
</style>