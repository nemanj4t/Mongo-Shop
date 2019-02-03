<template>
    <div class='card'>
        <div class='card-header'>
            Edit category: 
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
                        <option value="" selected='selected'>No parent caregory</option>
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
                <button type="submit" class="btn btn-primary" @click="edit">Submit</button>
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
                additionalFields : [],
                id: this.$route.params.id
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

        edit() {
            axios.put('/categories/'+ this.$route.params.id, this.request)
            .then(response =>{console.log(response); this.$router.push('/categories')})
            .catch(error => console.log(error));
        }
    },

    mounted() {
        axios.get('/api/categories')
            .then(response => {this.categories = response.data.categories; console.log(this.categories);})
            .catch(error => console.log(error));
        
        axios.get('/api/categories/' + this.$route.params.id)
            .then(response => {console.log(response); this.request.name = response.data.name; this.request.category_id = response.data.category_id; this.request.additionalFields = response.data.details;})
            .catch(error => console.log(error));
    }
}
</script>

<style>

</style>