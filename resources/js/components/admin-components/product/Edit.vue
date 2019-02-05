<template>
    <div class='card'>
        <div class='card-header'>
            Edit product:        
        </div>
        <div class='card-body'>
            <div>
                <div class="form-group">
                    <label>Product name:</label>
                    <input class="form-control" name="name" placeholder="Category name" v-model = "request.name">
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
                    <label>Stock:</label>
                    <input class="form-control" name="stock" placeholder="Products on stock" v-model = "request.stock">
                </div>
                <div class="form-group">
                    <label>Price:</label>
                    <input class="form-control" name="stock" placeholder="Price" v-model = "request.price">
                </div>
                <div class="form-group">
                    <label>Additional fields:</label>
                    <div class="row" v-for="(field, index) in request.additionalFields">
                        <label>{{index}}:</label>
                        <input class="col-md-12 form-control" v-model="request.additionalFields[index]"/>
                    </div>            
                </div>
                <button type="submit" class="btn btn-primary" @click="editProduct">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            updated_at: "",
            categories: "",
            original: {
                category: "",
                additionalFields: {}
            },
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
           // console.log(this.request.category, this.original.category);
            if (this.request.category._id == this.original.category._id) {
                this.request.additionalFields = this.original.additionalFields;
            }
            else {
                this.request.additionalFields = {};
                parent = this.findCategory(this.request.category.category_id);

                this.request.category.details.forEach(detail => {
                    this.request.additionalFields[detail] = "";
                });

                while(parent != "" && parent != null) {
                    parent.details.forEach(detail => {
                        this.request.additionalFields[detail] = "";
                    });

                    parent = this.findCategory(parent.category_id);
                }
            }
        },

        findCategory(id) {
            parent = "";
            this.categories.forEach(category => {
                if (category._id == id){
                    parent = category;
                }
            });
            return parent;
        },

        editProduct() {
            axios.put('/products/' + this.$route.params.id, this.request)
            .then(response => {console.log(response); this.$router.push('/products');})
            .catch(error => console.log(error));
        },

    },

    mounted() {
        axios.get('/api/categories')
            .then(response => {this.categories = response.data.categories; console.log(this.categories);})
            .catch(error => console.log(error));

        axios.get('/api/products/' + this.$route.params.id)
            .then(response =>
             {
                 this.request.name = response.data.name;
                 this.request.image = response.data.image;
                 this.request.category = this.findCategory(response.data.category_id);
                 this.request.price = response.data.price;
                 this.request.stock = response.data.stock;
                 
                 Object.keys(response.data).forEach((key, value) => {
                     if (key == 'updated_at')
                        this.updated_at = value;
                 });
                 Object.keys(response.data).forEach((key, value) => {
                     if (value >5 && value < this.updated_at){
                         this.request.additionalFields[key] = response.data[key];
                     }
                 });

                 this.original.category = this.findCategory(response.data.category_id);
                 this.original.additionalFields = this.request.additionalFields;
                 console.log(this.request, this.original);
            })
            .catch(error => console.log(error));
           
    }
}
</script>

<style>

</style>