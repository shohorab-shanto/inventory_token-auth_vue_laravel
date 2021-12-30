<template>
    <div>
        <div class="row">
            <router-link to="/product" class="btn btn-primary">All product</router-link>
        </div>
        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add product</h1>
                  </div>
                  <form class="user" @submit.prevent="ProductInsert" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="exampleFormControlSelect1">Product Name</label>
                                 <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Product Name" v-model="form.product_name">
                                 <small class="text-danger" v-if="errors.product_name">{{errors.product_name[0]}}</small>
                            </div>

                            <div class="col-md-6">
                                <label for="exampleFormControlSelect1">Product Code</label>
                                 <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Enter product code" v-model="form.product_code">
                                <small class="text-danger" v-if="errors.product_code">{{errors.product_code[0]}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                 <label for="exampleFormControlSelect1">Product Category</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="form.category_id">
                                    <option :value="category.id" v-for="category in categories">{{category.category_name}}</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                 <label for="exampleFormControlSelect1">Product Supplier</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id">
                                    <option :value="supplier.id" v-for="supplier in suppliers">{{supplier.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="exampleFormControlSelect1">Root</label>
                                 <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Root" v-model="form.root">
                                 <small class="text-danger" v-if="errors.root">{{errors.root[0]}}</small>
                            </div>

                            <div class="col-md-4">
                                <label for="exampleFormControlSelect1">Product Buying Price</label>
                                 <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Buying Price" v-model="form.buying_price">
                                 <small class="text-danger" v-if="errors.buying_price">{{errors.buying_price[0]}}</small>
                            </div>

                            <div class="col-md-4">
                                <label for="exampleFormControlSelect1">Product Selling Price</label>
                                 <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Enter Selling Price" v-model="form.selling_price">
                                <small class="text-danger" v-if="errors.selling_price">{{errors.selling_price[0]}}</small>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="exampleFormControlSelect1">Product Buying Date</label>
                                 <input type="date" class="form-control" id="exampleInputFirstName"  v-model="form.buying_date">
                                 <small class="text-danger" v-if="errors.buying_date">{{errors.buying_date[0]}}</small>
                            </div>

                            <div class="col-md-6">
                                <label for="exampleFormControlSelect1">Product Quantity</label>
                                 <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" v-model="form.product_quantity">
                                <small class="text-danger" v-if="errors.product_quantity">{{errors.product_quantity[0]}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                <small class="text-danger" v-if="errors.image">{{errors.image[0]}}</small>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>

                            <div class="col-md-6">
                                <img :src="form.image" style="height:50px;width:50px;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
                product_name: null,
                product_code: null,
                category_id: null,
                supplier_id: null,
                root: null,
                buying_price: null,
                selling_price: null,
                buying_date: null,
                image: null,
                product_quantity: null
            },
            errors:{},
            categories:{},
            suppliers:{},
        }
    },
    methods:{
        onFileSelected(event){
            let file = event.target.files[0]; //this is console log position
            if(file.size > 1048770){  //size will come from console log
                Notification.image_validation()
            }else{
                let reader = new FileReader();
                reader.onload = event =>{  //event theke data pathacci
                    this.form.image = event.target.result
                    console.log(event.target.result);
                };
                reader.readAsDataURL(file); //getting img url
                // console.log(event);
            }

        },
        ProductInsert(){
            axios.post('/api/product',this.form)  //ei url e jabe and oikhan thke controller drbe
            .then(() =>{
                this.$router.push({name: 'product'}) //redirect korbe
                Notification.success()
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    },
    created(){
        axios.get('/api/category/')
        .then(({data}) => (this.categories = data))

        axios.get('/api/supplier/')
        .then(({data}) => (this.suppliers = data))
    }


    }


</script>

<style type="text/css">

</style>
