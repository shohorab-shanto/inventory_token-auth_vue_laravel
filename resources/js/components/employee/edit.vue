<template>
    <div>
        <div class="row">
            <router-link to="/employee" class="btn btn-primary">All Employee</router-link>
        </div>
        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Employee Update</h1>
                  </div>
                  <form class="user" @submit.prevent="employeeUpdate" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                 <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter First Name" v-model="form.name">
                                 <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>
                            </div>

                            <div class="col-md-6">
                                 <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Enter Email Address" v-model="form.email">
                                <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                 <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Address" v-model="form.address">
                                 <small class="text-danger" v-if="errors.address">{{errors.address[0]}}</small>
                            </div>

                            <div class="col-md-6">
                                 <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Enter Your Sallery" v-model="form.sallery">
                                <small class="text-danger" v-if="errors.sallery">{{errors.sallery[0]}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                 <input type="date" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Joining Date" v-model="form.joining_date">
                                 <small class="text-danger" v-if="errors.joining_date">{{errors.joining_date[0]}}</small>
                            </div>

                            <div class="col-md-6">
                                 <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Enter NID" v-model="form.nid">
                                <small class="text-danger" v-if="errors.nid">{{errors.nid[0]}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                 <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Phone Number" v-model="form.phone">
                                 <small class="text-danger" v-if="errors.phone">{{errors.phone[0]}}</small>
                            </div>

                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                <small class="text-danger" v-if="errors.photo">{{errors.photo[0]}}</small>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>

                            <div class="col-md-6">
                                <img :src="form.photo" style="height:50px;width:50px;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Update  </button>
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
                name:'',
                email:'',
                phone:'',
                sallery:'',
                address:'',
                photo:'',
                newphoto:'', //for relace old photo
                nid:'',
                joining_date:'',
            },
            errors:{}
        }
    },
    created(){ //get specific id data
      let id = this.$route.params.id //getting id from url and params
      axios.get('/api/employee/'+id)  //passing id to controller to get data
      //console.log(data)
      .then(({data}) => (this.form = data))  //data sb form e diea dilam
      .catch(console.log('error')) //error thakle error dekhabe

    },
    methods:{
        onFileSelected(event){
            let file = event.target.files[0]; //this is console log position
            if(file.size > 5048770){  //size will come from console log
                Notification.image_validation()
            }else{
                let reader = new FileReader();
                reader.onload = event =>{  //event theke data pathacci
                    this.form.newphoto = event.target.result

                };
                reader.readAsDataURL(file); //getting img url
                // console.log(event);
            }

        },
        employeeUpdate(){
            let id = this.$route.params.id
            axios.patch('/api/employee/'+id,this.form)  //ei url e jabe and oikhan thke controller drbe
            .then(() =>{
                this.$router.push({name: 'employee'}) //redirect korbe
                Notification.success()
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    }


    }


</script>

<style type="text/css">

</style>
