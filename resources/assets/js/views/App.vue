<template>
  <div class="container">
    <!-- {{-- <div class="row justify-content-center"> --}} -->    
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                      <!-- {{-- <a class="navbar-brand" href="#">Navbar</a> --}} -->
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>

                      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                          <li class="nav-item">
                            <!-- {{-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> --}} -->
                            <router-link to="/main" exact class="nav-link">
                              <i class="fa fa-home" aria-hidden="true"></i>
                              <span>Home</span>
                            </router-link>
                          </li>
                          <li class="nav-item">                            
                            <router-link to="/booking" class="nav-link">
                              <i class="fa fa-list-alt" aria-hidden="true"></i>
                              <span>Booking</span>
                            </router-link>
                          </li>
                          <li class="nav-item">
                            <!-- <a class="nav-link" href="#">Shipment</a> -->
                            <router-link to="/shipment" class="nav-link">
                              <i class="fa fa-paper-plane" aria-hidden="true"></i>
                              <span>Shipment</span>
                            </router-link>
                          </li>
                          
                          <!-- <li class="nav-item">                            
                            <router-link to="/report" class="nav-link">
                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              <span>Report</span>
                            </router-link>
                          </li>
 -->
                          <li class="nav-item">                            
                            <div class="dropdown">
                               <a class="dropdown-toggle nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                  Reports
                                </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <span>                                  
                                  <router-link to="/report" class="dropdown-item">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    <span>Report</span>
                                  </router-link>
                                </span>
                                <span>
                                  <router-link to="/report-by-ref" class="dropdown-item">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    <span>Report by Reference</span>
                                  </router-link>
                                </span>                               
                              </div>
                            </div>
                          </li>
                          
                          <!-- <li class="nav-item">                            
                            <router-link to="/options" class="nav-link">
                              <i class="fa fa-list-alt" aria-hidden="true"></i>
                              <span>Options</span>
                            </router-link>
                          </li> -->

                          <!-- <li class="nav-item" v-show="isAdmin">
                            <router-link to="/settings" class="nav-link">
                              <i class="fa fa-cogs" aria-hidden="true"></i>
                              <span>Settings</span>
                            </router-link>
                          </li> -->
                          <li class="nav-item" v-show="isAdmin">                            
                            <div class="dropdown">
                               <a class="dropdown-toggle nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                  Settings
                                </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <!-- <span>                                  
                                  <router-link to="/settings" class="dropdown-item">
                                    <i class="fa fa-cogs" aria-hidden="true"></i>
                                    <span>Settings</span>
                                  </router-link>
                                </span> -->
                                <span>
                                  <router-link to="/user-register" class="dropdown-item">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    <span>Add New User</span>
                                  </router-link>
                              </span>
                                <!-- <a class="dropdown-item" href="#">
                                  <i class="fa fa-user-times" aria-hidden="true"></i>
                                  Delete User
                                </a> -->
                                <!-- <a class="dropdown-item" href="#">Change Password</a>
                                <a class="dropdown-item" href="#">Something else here</a> -->
                              </div>
                            </div>
                          </li>


                        </ul>                        
                      </div>
                    </nav>
                </div> 

                <div class="card-body" v-show="!error">                   
                    <router-view></router-view>                    
                </div>
                <div class="card-body" v-show="error">
                    <div class="alert alert-warning" role="alert">
                          <h4 class="alert-heading">Sorry!</h4>
                          <hr>
                          <p>You are not <strong> Authorized </strong> to use this program. </p>
                          <p>Please <strong>Login.</strong></p>
                          <!-- <p class="mb-0">Please log in to use.</p> -->
                    </div>                   
                </div>
            </div>
        </div>
    </div>
  </div>     
</template>

<script>
    export default {
        data() {          
          return {
            //disable: false,
            isAdmin: false,
            isUser: false,
            error: '',
            //userInfo:'' ,
          } 
        },
        mounted() {
          //console.log('Component mounted.')
          this.isRegisteredUser();
        },       
        methods: {
          isRegisteredUser() {
            var vm = this;
            axios.get('/is-registered-user') 
                  .then(function (response) {                  
                         response.data.error ? vm.error = response.data.error : vm.isUser = response.data;                         
                         if (vm.isUser == true) {
                          vm.userIsAdmin();
                         }
                    })
                    .catch(function (error) {
                        vm.error = error.response.data.message;
                        console.log(error.response.data.message);
                    });

          },
          userIsAdmin() {
            var vm = this;
            axios.get('/user') 
                  .then(function (response) {                  
                     response.data.error ? vm.error = response.data.error : vm.isAdmin = response.data;
                     //vm.loading = false;                  
              });
          }
        }

    }
</script>