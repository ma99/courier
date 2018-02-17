<template>
<!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Booking
        <!-- <small>Optional description</small> -->
      </h1>      
    </section>

    <!-- Main content -->
    <section class="content">       
     <!-- Your Page Content Here -->   
     <p> Booking Page </p> 
      <div class="row justify-content-center">
        <div class="col-8">          
         <form>
            <div class="form-group row">
              <label for="inputBookingRef" class="col-sm-3 col-form-label">Ref No</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="inputBookingRef" v-model="bookingRef" disabled>
              </div>
            </div>

            <div class="form-group row">
              <label for="senderName" class="col-sm-3 col-form-label">Sender Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="senderName" placeholder="Sender Name" v-model="sender.name">
              </div>
            </div>

            <div class="form-group row">
              <label for="senderPhone" class="col-sm-3 col-form-label">Sender Phone</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="senderPhone" placeholder="Sender Phone" v-model="sender.phone">
              </div>
            </div>

            <div class="form-group row">
              <label for="senderAddress" class="col-sm-3 col-form-label">Sender address</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="senderAddress" placeholder="Sender address" v-model="sender.address">
              </div>
            </div>


            <div class="form-group row">
              <label for="receiverName" class="col-sm-3 col-form-label">Receiver Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="receiverName" placeholder="Receiver Name" v-model="receiver.name">
              </div>
            </div>

            <div class="form-group row">
              <label for="receiverPhone" class="col-sm-3 col-form-label">Receiver Phone</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="receiverPhone" placeholder="Receiver Phone" v-model="receiver.phone">
              </div>
            </div>

            <div class="form-group row">
              <label for="receiverAddress" class="col-sm-3 col-form-label">Receiver address</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="receiverAddress" placeholder="Receiver address" v-model="receiver.address">
              </div>
            </div>
            
           <!--  <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-3 pt-0">Home Delivery</legend>
                <div class="col-sm-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="Yes" v-model="homeDelivery">
                    <label class="form-check-label" for="gridRadios1">
                      Yes
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="No" v-model="homeDelivery">
                    <label class="form-check-label" for="gridRadios2">
                      No
                    </label>
                  </div>
                  
                </div>
              </div>
            </fieldset>    --> 
            <div class="form-group row">
              <div class="col-sm-3">Home Delivery</div>
              <div class="col-sm-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="gridCheck1" v-model="homeDelivery">
                  <!-- <label class="form-check-label" for="gridCheck1">
                    Example checkbox
                  </label> -->
                </div>
              </div>
            </div>        

            <!-- <div class="receiving-address" v-show="(homeDelivery == 'Yes') ? false : true"> -->
            <div class="receiving-address" v-show="!homeDelivery">
              <div class="form-group row">
                <label for="receivingAddress" class="col-sm-3 col-form-label">Receiving address</label>
                
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="divisionName">Division Name</label>
                      <select v-model="selectedDivision" class="form-control" id="divisionName">
                          <option disabled value="">Please select one</option>
                          <option v-for="division in divisionList" v-bind:value="{ id: division.id, name: division.name }">
                            {{ division.name }}
                          </option>                             
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="cityName">City Name </label>                       
                      <select v-model="selectedCity" class="form-control" id="cityName">
                          <option disabled value="">Please select one</option>                          
                          <option v-for="city in cityList" v-bind:value="{ id: city.id, name: city.name }">
                            {{ city.name }}
                          </option> 
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="areaName">Area Name </label>
                      <input type="text" v-model="areaName" class="form-control" id="areaName">                        
                      </input>
                    </div>
                  </div>
              </div>              
            </div>
            
            <div class="form-group row">
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary" v-on:click.prevent="saveBookingInfo()">Save</button>
              </div>
            </div>
         </form> 
        </div>
      </div>
    </section>

  </div>      
</template>

<script>
    export default {
        data() {
          return {
            areaName: '',
            bookingRef: '',
            cityList: [],
            divisionList: [],
            error: '',
            homeDelivery: false,
            //receivingAddress: '',
            selectedCity: '',
            selectedDivision: '',
            sender: {
                name: '',
                address: '',
                phone: ''
            },
            receiver: {
                name: '',
                address: '',
                phone: ''
            },
          }
        },
        mounted() {          
          this.setBookingRef();
          this.fetchDivisions();          
        },
        watch: {
            selectedDivision() {
                this.fetchCitiesByDivision(this.selectedDivision.id); // this.selectedDivisionId
            },            
        },
        methods: {
           fetchCitiesByDivision(divisionId) {
            //this.loading = true;
            //this.cityList= [];            
            var vm = this;                      
            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
            axios.get('/api/districts?q=' + divisionId)  //--> /api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.cityList = response.data;
                   //vm.loading = false;                  
            });
          },  
          fetchDate() {

            // generate 6 digits random string 
            //Math.floor(100000 + Math.random() * 900000)  
            var today = new Date();
            var date = today.getFullYear()+''+(today.getMonth()+1)+''+today.getDate();
            var time = today.getHours() + '' + today.getMinutes() + '' + today.getSeconds();
            // console.log(date);
            // console.log(time);
            var dateTime = date+time;
            return dateTime;
          },
          fetchDivisions() {
            //this.loading = true;
            this.divisionList= [];            
            var vm = this;                      
            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
            axios.get('/api/divisions')  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.divisionList = response.data;
                   //vm.loading = false;                  
            });
          },
          saveBookingInfo() {
            var vm = this;
            var receivingAddress = 'N/A';
            /*if (this.homeDelivery == 'No') {
                var receivingAddress = this.areaName + ', ' + 
                                        this.selectedCity.name + ', ' + 
                                        this.selectedDivision.name;

            }*/
            if (this.homeDelivery == false) {
                var receivingAddress = this.areaName + ', ' + 
                                        this.selectedCity.name + ', ' + 
                                        this.selectedDivision.name;

            }


            console.log('radddd=', receivingAddress);
            
            axios.post('/booking', {
                booking_ref: this.bookingRef,
                sender: this.sender,
                receiver: this.receiver,
                home_delivery: this.homeDelivery,
                receiving_address: receivingAddress,
            })          
            .then(function (response) {
                //console.log(response.data);
                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                // if (vm.response) {
                //    //console.log(vm.response);
                //    vm.fetchBusAvailableToCities();
                //    vm.SortByCityNameBusAvailableToCityList(vm.busAvailableToCityList);
                //    vm.loading = false;
                //    vm.disableSaveButton = true;
                //    vm.cityAddedAlert(vm.selectedCity.name);
                //    vm.reset();
                //    return;                   
                // }
                // vm.loading = false;
                //vm.disableSaveButton = true;
            });
          },
          setBookingRef() {
            this.bookingRef = this.fetchDate();
          },
        }
    }
</script>