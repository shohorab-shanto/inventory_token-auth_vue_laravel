<template>
    <div>
        <div class="row">
            <router-link to="/category" class="btn btn-primary">All Category</router-link>
        </div>
        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Edit Category</h1>
                  </div>
                  <form class="user" @submit.prevent="categoryUpdate">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                 <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Category Name" v-model="form.category_name">
                                 <small class="text-danger" v-if="errors.category_name">{{errors.category_name[0]}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </div>
                  </form>
                  <hr>

                </div>
              </div>
            </div>
          </div>
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
        return {
            form:{
                category_name:'',
            },
            errors:{}
        }
    },

    created(){ //get specific id data
      let id = this.$route.params.id //getting id from url and params
      axios.get('/api/category/'+id)  //passing id to controller to get data
      //console.log(data)
      .then(({data}) => (this.form = data))  //data sb form e diea dilam
      .catch(console.log('error')) //error thakle error dekhabe

    },
    methods:{

        categoryUpdate(){
            let id = this.$route.params.id
            axios.patch('/api/category/'+id,this.form)  //ei url e jabe and oikhan thke controller drbe
            .then(() =>{
                this.$router.push({name: 'category'}) //redirect korbe
                Notification.success()
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    }


    }


</script>

<style type="text/css">

</style>
