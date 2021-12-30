<template>
    <div>
        <div class="row">
            <router-link to="/store-category" class="btn btn-primary">Add Category</router-link>
        </div>
        <br>
        <input type="text" v-model="searchTerm" class="form-control" style="width:300px;" placeholder="Search here">
        <br>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Category Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="category in categories" :key="category.id">
                        <td>{{category.category_name}}</td>
                        <td>
                            <router-link :to="{name:'edit-category',params:{id:category.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                            <a @click="deleteCategory(category.id)" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
    </div>
</template>

<script type="text/javascript">

    export default {

        created(){ //construct er mto nicher function or method colar aga ei method colbe
        if(!User.loggedIn()){ //jdi login kora thke tahole abr login page e jete parbe na
            this.$router.push({name:'/'})
        }
    },
    data(){
        return{ //i want take all data in thhis property area
            categories:[],
            searchTerm:''

        }
    },
    computed:{
        filtersearch(){ //use this filtersearch in v-for because all supplier is in this method
            return this.categories.filter(category =>{  //this.employee.filter k employee e define kora holo
                return category.phone.match(this.searchTerm)
            })
        }
    },

    methods:{
        allSupplier(){
            axios.get('/api/category/')  //data comming from there
            .then(({data}) => (this.categories = data)) //employees e data pathaiya dilam
            .catch
        },
        deleteCategory(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('/api/category/'+id)
                .then(() => {
                    this.categories = this.categories.filter(category => {
                        return category.id != id  //dleted id er sathe jegula match korbe na segula show korbe
                    })
                })
                .catch(() => {
                    this.$router.push({name:'category'})
                })
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
            })

        }
    },
    created(){ //without loading the page employee will show
        this.allSupplier();
    }


    }


</script>

<style type="text/css">
    #em_photo{
        height:40px;
        width:40px;
    }
</style>
