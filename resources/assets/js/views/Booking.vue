<template>
<!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>Booking</h3>
      <hr>      
      <div class="alert-area">
        <show-alert :show.sync="showAlert" :type="alertType"> 
              <!-- altert type can be info/warning/danger -->
            <div v-show="response">              
              <strong>Booking </strong> has been 
              <strong> Saved </strong> successfully!
            </div>
            <div v-show="error">              
              <strong>Oops!! </strong> Something is  
              <strong> Wrong. </strong> Pls check again!
            </div>    
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

            <!-- <div class="booking-info">    
              <span class="items">Item List</span>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="cosmetics" value="Cosmetics" v-model="items">
                <label class="form-check-label" for="cosmetics">Cosmetics</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="dryBabyFood" value="Dry/Baby food" v-model="items">
                <label class="form-check-label" for="dryBabyFood">Dry/Baby food</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="electronicsItem" value="Electronics Item" v-model="items">
                <label class="form-check-label" for="electronicsItem">Electronics Item</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="mixCloth" value="Mix Cloth" v-model="items">
                <label class="form-check-label" for="mixCloth">Mix Cloth</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="kidsItem" value="Kids Item" v-model="items">
                <label class="form-check-label" for="kidsItem">Kids Item</label>
              </div>
            
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="kitchenGadget" value="Kitchen Gadget" v-model="items">
                  <label class="form-check-label" for="kitchenGadget">Kitchen Gadget</label>
              </div>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="chocklate" value="Chocklate" v-model="items">
                  <label class="form-check-label" for="chocklate">Chocklate</label>
              </div>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="toys" value="Toys" v-model="items">
                  <label class="form-check-label" for="toys">Toys</label>
              </div>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="mobileLaptopTab" value="Mobile/ Laptop/ iPad/ Tab" v-model="items">
                  <label class="form-check-label" for="mobileLaptopTab">Mobile/ Laptop/ iPad/ Tab</label>
              </div>
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="others" value="Others" v-model="items">
                  <label class="form-check-label" for="others">Others</label>
              </div>
              <br>             
            </div> -->

            <div class="booking-info">    
              <span class="items">Item List</span>
              <div class="form-check form-check-inline" v-for="(item, index) in itemList">
                <input class="form-check-input" type="checkbox" :id="item.name" :value="item.name" v-model="items">
                <label class="form-check-label" :for="item.name">{{item.name}}</label>
              </div>              
            </div>
            
            <div class="parcel-quantity">
              <fieldset class="form-group">
                <div class="row">
                  <legend class="col-form-label col-sm-4 pt-0">Quantity of Parcel</legend>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="quantityRadios" id="quantityRadios1" value="One" v-model="parcelQuantity">
                      <label class="form-check-label" for="quantityRadios1">
                        One
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="quantityRadios" id="quantityRadios2" value="Two" v-model="parcelQuantity">
                      <label class="form-check-label" for="quantityRadios2">
                        Two
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="quantityRadios" id="quantityRadios3" value="Three" v-model="parcelQuantity">
                      <label class="form-check-label" for="quantityRadios3">
                        Three
                      </label>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>

            <div class="parcel-type">
              <fieldset class="form-group">
                <div class="row">
                  <legend class="col-form-label col-sm-4 pt-0">Type of Parcel</legend>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Carton" id="parcelCheck1" v-model="parcelType">
                      <label class="form-check-label" for="parcelCheck1">
                        Carton
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Packet" v-model="parcelType">
                      <label class="form-check-label" for="parcelCheck2">
                        Packet 
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="Luggage" id="parcelCheck3" v-model="parcelType">
                      <label class="form-check-label" for="parcelCheck3">
                       Luggage
                      </label>
                    </div>
                  </div>
                </div>
              </fieldset>               
            </div>
           
            <div class="home-delivery">
              <div class="form-group row">
                <!-- <div class="col-sm-4">Home Delivery</div> -->
                <legend class="col-form-label col-sm-4 pt-0">Home Delivery</legend>              
                <div class="col-sm-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck1" v-model="homeDelivery">                  
                  </div>
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
            <div class="form-group row justify-content-center">
              <div class="col-sm-4">
                <div class="btn-group mr-2" role="group" aria-label="Third group">
                  <button type="submit" class="btn btn-primary btn-lg" v-on:click.prevent="saveBookingInfo()" :disabled="!isValid">Save</button>
              </div>
              <div class="btn-group mr-2" role="group" aria-label="Third group">
                <button type="button" class="btn btn-warning btn-lg" v-on:click.prevent="reset">Cancel</button>
              </div>  
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
            error: false,
            homeDelivery: false,
            itemList: [],
            items: [],
            loading: false,
            //receivingAddress: '',
            parcelQuantity: 'One',
            parcelType: [],
            response: false,
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
          this.fetchItems();
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
                    this.areaName != '' &&                    
                    this.items.length > 0 &&
                    this.parcelType.length > 0 
            }

            return this.sender.name != '' && 
                    this.sender.address != '' &&
                    this.sender.phone != '' &&
                    this.receiver.name != '' && 
                    this.receiver.address != '' &&
                    this.receiver.phone != '' &&
                    this.items.length > 0 &&
                    this.parcelType.length > 0 
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
          fetchItems() {
            //this.loading = true;
            this.itemList= [];            
            var vm = this;                      
            //axios.get('api/bus?q=' + busId) //--> admin/api/bus?q=xyz  (wrong)
            axios.get('/api/all-items')  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.itemList = response.data;
                   //vm.loading = false;
                   vm.availableItemsSortByItemName(vm.itemList);                  
            });
          },
          availableItemsSortByItemName(arr) {
            // sort by name            
                arr.sort(function(a, b) {
                  var nameA = a.name.toUpperCase(); // ignore upper and lowercase
                  var nameB = b.name.toUpperCase(); // ignore upper and lowercase
                  if (nameA < nameB) {
                    return -1;
                  }
                  if (nameA > nameB) {
                    return 1;
                  }

                  // names must be equal
                  return 0;
                });
          },
          saveBookingInfo() {
            var vm = this;
            this.loading = true;
            this.error = false;
            this.response = false;
            var receivingAddress = 'N/A';
            var items = this.items.toString();
            var parcelType = this.parcelType.toString();
            
            if (this.homeDelivery == false) {
                var receivingAddress = this.areaName + ', ' + 
                                        this.selectedCity.name + ', ' + 
                                        this.selectedDivision.name;

            }
            axios.post('/booking', {
                booking_ref: this.bookingRef,
                items: items,
                parcel_quantity: this.parcelQuantity,
                parcel_type: parcelType,
                home_delivery: this.homeDelivery,
                sender: this.sender,
                receiver: this.receiver,
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
                //console.log(vm.response);
                vm.loading = false;
                vm.alertType = 'info';                          
                vm.showAlert= true;
                vm.response = true;
                vm.reset();
                vm.setBookingRef();
                //vm.disableSaveButton = true;
            })
            .catch(function (error) {
                        vm.error = error.response.data.errors;
                        console.log(error.response.data.errors);
                        vm.loading = false;
                        vm.alertType = 'danger';
                        vm.showAlert= true;
                        vm.error = true;
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
                this.items = [];
                this.parcelType = [];
                this.parcelQuantity = 'One';
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
      .items {
        @extend span;
        background-color: lightcoral;
      }
      .form-check-inline .form-check-input, .form-check-label {
        margin-bottom: 1rem;
      }


  } 
  .parcel-quantity, .parcel-type, .home-delivery {
    // background-color:lightblue;
    border-bottom: 1px dashed lightgray;
    margin-bottom: 1.5rem;
  }
  .receiving-address {
   margin-bottom: 2.5rem; 
  }
  .alert-area {    
    padding-left: 5rem;
    text-align: center;
    padding-right: 5rem;
  }

</style>