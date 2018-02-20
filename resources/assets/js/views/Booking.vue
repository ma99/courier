<template>
<!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2>
        Booking
        <!-- <small>Optional description</small> -->
      </h2>
      <hr>      
      <div class="alert-area">
        <show-alert :show.sync="showAlert" :type="alertType"> 
              <!-- altert type can be info/warning/danger -->
              <strong>Booking </strong> has been 
              <strong> Added </strong> successfully!
            </show-alert>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">       
     <!-- Your Page Content Here -->   
     <!-- <p> Booking Page </p>  -->
      <div class="row justify-content-center">
        <div class="col-8">          
         <form>
            <div class="form-group row">
              <label for="inputBookingRef" class="col-sm-3 col-form-label">Reference No.</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="inputBookingRef" v-model="bookingRef" disabled>
              </div>
            </div>

            <div class="booking-info">
              <span class="sender">Sender</span>
              <div class="form-group row">
                <label for="senderName" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="senderName" placeholder="Sender Name" v-model="sender.name">
                </div>
              </div>

              <div class="form-group row">
                <label for="senderPhone" class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="senderPhone" placeholder="Sender Phone" v-model="sender.phone">
                </div>
              </div>

              <div class="form-group row">
                <label for="senderAddress" class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="senderAddress" placeholder="Sender address" v-model="sender.address">
                </div>
              </div>
            </div>

            <div class="booking-info">    
              <span class="receiver">Receiver</span>
              <div class="form-group row">
                <label for="receiverName" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="receiverName" placeholder="Receiver Name" v-model="receiver.name">
                </div>
              </div>

              <div class="form-group row">
                <label for="receiverPhone" class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="receiverPhone" placeholder="Receiver Phone" v-model="receiver.phone">
                </div>
              </div>

              <div class="form-group row">
                <label for="receiverAddress" class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="receiverAddress" placeholder="Receiver address" v-model="receiver.address">
                </div>
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
                </div>
              </div>
            </div>        

            <!-- <div class="receiving-address" v-show="(homeDelivery == 'Yes') ? false : true"> -->
            <div class="receiving-address" v-show="!homeDelivery">
              <div class="form-group row">
                <label for="receivingAddress" class="col-sm-3 col-form-label">Receiving Address</label>
                
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="divisionName">Division</label>
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
                      <label for="cityName">District</label>                       
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
                      <label for="areaName">Area</label>
                      <input type="text" v-model="areaName" class="form-control" id="areaName">                        
                      </input>
                    </div>
                  </div>
              </div>              
            </div>
            <loader :show="loading"></loader>
            <div class="form-group row">
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary btn-lg" v-on:click.prevent="saveBookingInfo()" :disabled="!isValid">Save</button>
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
            alertType: 'success',
            bookingRef: '',
            cityList: [],
            divisionList: [],
            error: '',
            homeDelivery: false,
            loading: false,
            //receivingAddress: '',
            showAlert: false,
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
        computed: {
          isValid() {   
            if (this.homeDelivery == false) {
              return this.sender.name != '' && 
                    this.sender.address != '' &&
                    this.sender.phone != '' &&
                    this.receiver.name != '' && 
                    this.receiver.address != '' &&
                    this.receiver.phone != '' &&
                    this.selectedDivision != '' &&
                    this.selectedCity != '' &&
                    this.areaName != ''
            }

            return this.sender.name != '' && 
                    this.sender.address != '' &&
                    this.sender.phone != '' &&
                    this.receiver.name != '' && 
                    this.receiver.address != '' &&
                    this.receiver.phone != '' 

          }
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
                  // vm.loading = false;                  
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
            this.loading = true;
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
                vm.loading = false;
                vm.alertType = 'info';                          
                vm.showAlert= true;
                vm.reset();
                vm.setBookingRef();
                //vm.disableSaveButton = true;
            });
          },
          reset() {
                this.sender.name = '' ; 
                this.sender.address = '' ;
                this.sender.phone = '' ;
                this.receiver.name = '' ; 
                this.receiver.address = '' ;
                this.receiver.phone = '' ;
                this.selectedDivision = '' ;
                this.selectedCity = '' ;
                this.areaName = '';
                this.homeDelivery = false;
;        },
          setBookingRef() {
            this.bookingRef = this.fetchDate();
          },
        }
    }
</script>

<style lang="scss" scoped>
  .booking-info {
      border: 1px dashed lightblue;
      // padding: 25px 10px;
      // margin: 25px 25px 50px 25px;
      padding: 30px 10px 10px 15px;
      margin: 40px 0px;
      position: relative;
      text-align: center; 
      span {
        /* background-color: lightblue; */
        display: block;
        font-weight: 600;
        letter-spacing: 1px;        
        left: 14px;
        top: -16px;
        position: absolute;
        padding: 5px 10px;
        width: auto;
      }
      .sender {
        @extend span;
        background-color: lightblue;
      }
      .receiver {
        @extend span;
        background-color: lightgreen;
      }
  } 

</style>