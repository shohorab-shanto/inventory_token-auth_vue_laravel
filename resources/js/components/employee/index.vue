<template>
    <div>
        <div class="row">
            <router-link to="/store-employee" class="btn btn-primary">Add Employee</router-link>
        </div>
        <br>
        <input type="text" v-model="searchTerm" class="form-control" style="width:300px;" placeholder="Search here">
        <br>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Sallery</th>
                        <th>Joining Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="employee in filtersearch" :key="employee.id">
                        <td>{{employee.name}}</td>
                        <td><img :src="employee.photo" id="em_photo"></td>
                        <td>{{employee.email}}</td>
                        <td>{{employee.phone}}</td>
                        <td>{{employee.sallery}}</td>
                        <td>{{employee.joining_date}}</td>
                        <td>
                            <router-link :to="{name:'edit-employee',params:{id:employee.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                            <a @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger">Delete</a>
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
            employees:[],
            searchTerm:''

        }
    },
    computed:{
        filtersearch(){ //use this filter search in v-for
            return this.employees.filter(employee =>{  //this.employee.filter k employee e define kora holo
                return employee.phone.match(this.searchTerm)
            })
        }
    },

    methods:{
        allEmployee(){
            axios.get('/api/employee/')  //data comming from there
            .then(({data}) => (this.employees = data)) //employees e data pathaiya dilam
            .catch
        },
        deleteEmployee(id){
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
                axios.delete('/api/employee/'+id)
                .then(() => {
                    this.employees = this.employees.filter(employee => {
                        return employee.id != id  //dleted id er sathe jegula match korbe na segula show korbe
                    })
                })
                .catch(() => {
                    this.$router.push({name:'employee'})
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
        this.allEmployee();
    }


    }


</script>

<style type="text/css">
    #em_photo{
        height:40px;
        width:40px;
    }
</style>
