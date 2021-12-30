<template>
    <div>
        <div class="row">
            <router-link to="/store-supplier" class="btn btn-primary">Add Supplier</router-link>
        </div>
        <br>
        <input type="text" v-model="searchTerm" class="form-control" style="width:300px;" placeholder="Search here">
        <br>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Supplier List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>shopname</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="supplier in suppliers" :key="supplier.id">
                        <td>{{supplier.name}}</td>
                        <td><img :src="supplier.photo" id="em_photo"></td>
                        <td>{{supplier.email}}</td>
                        <td>{{supplier.phone}}</td>
                        <td>{{supplier.shopname}}</td>
                        <td>
                            <router-link :to="{name:'edit-supplier',params:{id:supplier.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                            <a @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger">Delete</a>
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
            suppliers:[],
            searchTerm:''

        }
    },
    computed:{
        filtersearch(){ //use this filtersearch in v-for because all supplier is in this method
            return this.suppliers.filter(supplier =>{  //this.employee.filter k employee e define kora holo
                return supplier.phone.match(this.searchTerm)
            })
        }
    },

    methods:{
        allSupplier(){
            axios.get('/api/supplier/')  //data comming from there
            .then(({data}) => (this.suppliers = data)) //employees e data pathaiya dilam
            .catch
        },
        deleteSupplier(id){
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
                axios.delete('/api/supplier/'+id)
                .then(() => {
                    this.suppliers = this.suppliers.filter(supplier => {
                        return supplier.id != id  //dleted id er sathe jegula match korbe na segula show korbe
                    })
                })
                .catch(() => {
                    this.$router.push({name:'supplier'})
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
