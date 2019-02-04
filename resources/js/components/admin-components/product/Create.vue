<template>
    <div class='card'>
        <div class='card-header'>
            Create product:        
        </div>
        <div class='card-body'>
            <div>
                <div class="form-group">
                    <label>Product name:</label>
                    <input class="form-control" name="name" placeholder="Product name" v-model = "request.name">
                </div>
                <div class="form-group">
                    <label>Category:</label>
                    <select class="form-control" name="category" v-model="request.category" v-on:change="getCategory">
                        <option v-for="category in categories" :value="category">{{category.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Image:</label>
                    <input class="form-control" name="image" placeholder="Image" v-model = "request.image">
                </div>
                <div class="form-group">
                    <label>Price:</label>
                    <input class="form-control" name="price" placeholder="Price" v-model = "request.price">
                </div>
                <div class="form-group">
                    <label>Stock:</label>
                    <input class="form-control" name="stock" placeholder="Amount of products on stock" v-model = "request.stock">
                </div>
                <div class="form-group">
                    <label>Additional fields:</label>
                    <div class="row" v-for="(field, index) in request.additionalFields">
                        <label>{{index}}:</label>
                        <input class="col-md-12 form-control" v-model="request.additionalFields[index]"/>
                    </div>            
                </div>
                <button type="submit" class="btn btn-primary" @click="createProduct">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            categories: "",
            request: {
                name: "",
                image: "",
                category: "",
                stock: "",
                price: "",
                additionalFields : {}
            }
        }
    },
    //props: ['categories'],
    name:'ProductCreate',
    methods: {
        
        getCategory() {
            this.request.additionalFields = {};
            parent = this.findParent(this.request.category.category_id);

            this.request.category.details.forEach(detail => {
                this.request.additionalFields[detail] = "";
            });

            while(parent != "" && parent != null) {
                parent.details.forEach(detail => {
                    this.request.additionalFields[detail] = "";
                });

                parent = this.findParent(parent.category_id);
            }
            console.log(this.request);
        },

        findParent(id) {
            parent = "";
            this.categories.forEach(category => {
                if (category._id == id){
                    parent = category;
                }
            });
            return parent;
        },

        createProduct() {
            axios.post('/products', this.request)
            .then(response => 
            {
                console.log(response);
                this.$router.push('/products');
            })
            .catch(error => console.log(error));
        }
    },

    mounted() {
        axios.get('/api/categories')
            .then(response => {this.categories = response.data.categories; console.log(this.categories);})
            .catch(error => console.log(error));
    }
}
</script>

<style>

</style>