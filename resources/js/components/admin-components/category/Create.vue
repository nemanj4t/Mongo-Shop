<template>
    <div class='card'>
        <div class='card-header'>
            Create category:        
        </div>
        <div class='card-body'>
            <div>
                <div class="form-group">
                    <label>Category name:</label>
                    <input class="form-control" name="name" placeholder="Category name" v-model = "request.name">
                </div>
                <div class="form-group">
                    <label>Parent category:</label>
                    <select class="form-control" name="category_id" v-model="request.category_id">
                        <option value="" selected='selected'>No parent category</option>
                        <option v-for="category in categories" :value="category._id">{{category.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Additional fields:</label>
                    <button class="btn btn-secondary" @click='addField'>+</button>
                    <div class="row" v-for="(field, index) in request.additionalFields">
                        <input class="col-md-10 form-control mt-2" :name="'aditionalField_' + index" v-model = "request.additionalFields[index]"/>
                        <button class="btn btn-sm btn-danger mt-2 ml-2" :value="index" @click="deleteField(index)">X</button>
                    </div>            
                </div>
                <button type="submit" class="btn btn-primary" @click="createComponent">Submit</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            categories : [],
            request: {
                name: "",
                category_id: "",
                additionalFields : []
            }
        }
    },
   // props: ['categories'],
    name:'CategoryCreate',
    methods: {
        addField() {
            this.request.additionalFields.push("");
           // console.log(this.additionalFields);
        },
        
        deleteField(index) {
            this.request.additionalFields.splice(index, 1);
        },

        createComponent() {
            axios.post('/categories', this.request)
            .then(response =>{console.log(response); this.request.name = ""; this.request.category_id = "", this.request.additionalFields = [];})
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