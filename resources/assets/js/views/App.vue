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
                          <li class="nav-item active">
                            <!-- {{-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> --}} -->
                            <router-link to="/main" exact><i class="fa fa-clock-o"></i> <span class="nav-link">Home</span></router-link>
                          </li>
                          <li class="nav-item">
                            <!-- {{-- <a class="nav-link" href="#">Booking</a> --}} -->
                            <router-link to="/booking"><i class="fa fa-table" aria-hidden="true"></i><span class="nav-link">Booking</span></router-link>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Shipment</a>
                          </li>
                           <li class="nav-item">
                            <a class="nav-link" href="#">Report</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link disabled" href="#">Disabled</a>
                          </li>
                        </ul>                        
                      </div>
                    </nav>
                </div> 

                <div class="card-body">                   
                    <router-view></router-view>                    
                </div>
            </div>
        </div>
    </div>
  </div>     
</template>

<script>
    export default {
        // mounted() {
        //     console.log('Component mounted.')
        // }
    }
</script>