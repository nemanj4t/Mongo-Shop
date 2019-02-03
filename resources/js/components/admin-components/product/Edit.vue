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
                    <label>Amount:</label>
                    <input class="form-control" name="amount" placeholder="Amount" v-model = "request.amount">
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
            categories: "",
            original: {
                category: "",
                additionalFields: {}
            },
            request: {
                name: "",
                image: "",
                category: "",
                amount: "",
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
            }
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

        editProduct() {
            axios.put('/products/' + this.$route.params.id, this.request)
            .then(response => {console.log(response); this.$router.push('/products');})
            .catch(error => console.log(error));
        }
    },

    mounted() {
        axios.get('/api/products/' + this.$route.params.id)
            .then(response =>
             {
                 this.request.name = response.data.name;
                 this.request.image = response.data.image;
                 this.request.category = response.data.category;
                 this.request.amount = response.data.amount;
                 this.request.name = response.data.name;
                 Object.keys(response.data.details).forEach((key, value) => {
                     this.request.additionalFields[key] = response.data.details[key];
                 });

                 this.original.category = response.data.category;
                 this.original.additionalFields = this.request.additionalFields;
            })
            .catch(error => console.log(error));

            axios.get('/api/categories')
            .then(response => {this.categories = response.data.categories; console.log(this.categories);})
            .catch(error => console.log(error));
    }
}
</script>

<style>

</style>