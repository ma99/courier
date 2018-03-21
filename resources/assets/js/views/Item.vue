<template>
  <div>    
     <section class="content-header">
      <h2>Add/Remove Item</h2> 
      <hr>        
    </section>

    <section class="content">      
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-default">
              <div class="card-header">
                <!-- Add New City -->
                <span class="btn-group" role="group">
                    <button class="btn btn-success" type="button" @click="expandAddItemPanel" v-show="!show">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-warning" type="button" @click="expandAddItemPanel" v-show="show">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                </span>
              </div>
              <div class="card-body" v-show="show">
                <form>
                    <div class="col-sm-10">
                      <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input v-model="itemName" type="text" class="form-control" name="code" id="itemName">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="button-group">
                        <button v-on:click.prevent="saveItems()" class="btn btn-primary" :disabled="disableSaveButton">Save</button>                        
                      </div>
                    </div>                      
                </form>
              </div>
          </div>
        </div>  
      </div>
      
      <loader :show="loading"></loader>

      <div class="row justify-content-center item-list">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header">Available Items Name</div>
            <div class="card-body">
                <div id="scroll-items">
                  <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th scope="col">Sl. No.</th>
                          <th scope="col">Name
                               <!-- <span type="button" @click="isSortingAvailableBy('name')" :disabled="disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                              </span> -->
                          </th>                        
                          <th scope="col">Action</th>                                                         
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="(item, index) in availableItemList">                              
                          <td>{{ index+1 }}</td>                              
                          <td>{{ item.name }}</td>                                                      
                          <td> 
                              <button v-on:click.prevent="removeItem(item)" class="btn btn-danger">
                                <i class="fa fa-trash fa-fw"></i>Remove
                              </button>  
                          </td>                        
                        </tr>                            
                      </tbody>
                  </table>      
                </div>
            </div>
            <!-- {{-- card-footer --}} -->
            <div class="card-footer">                    
              <!-- <show-alert :show="showAlert" :type="alertType" @cancel="showAlert=false">  -->
              <show-alert :show.sync="showAlert" :type="alertType"> 
                <!-- altert type can be info/warning/danger -->
                <!-- <strong>{{ itemName }} </strong> has been  -->
                <strong>{{ itemNameForAction }} </strong> has been 
                <strong> {{ actionStatus }} </strong> successfully!
              </show-alert>
            </div>
          </div>
        </div>
      </div>
       
    </section>        
  </div>      
</template>
<script>
    export default {
        data() {
          return {
            actionStatus: '',
            alertType: '',
            itemList: [],
            itemName: '',
            itemNameForAction: '',
            availableItemList: [], //bus service availble to the cities
            //divisionList: [],
            disableSaveButton: true,
            disableResetButton: true,
            //disableSorting: true,
            error: '',
            loading: false,
            response: '',
            //selectedCityId: '',
            //selectedCity: '',
            //selectedDivisionId: '',
            //selectedDivision: '',
            show: false,
            showAlert: false,  
          }
        },
        mounted() {           
           //this.fetchDivisions();
           this.fetchAvailableItems();           
           this.enableSlimScroll();
        },
        watch: {
            // selectedDivision() {
            //     this.fetchCitiesByDivision(this.selectedDivision.id); // this.selectedDivisionId
            // },
            // itemList() {                
            //     this.disableSaveButton = (this.itemList.length < 1) ? true : false; 
            // },
            itemName() {
              this.disableSaveButton = (this.itemName == '') ? true : false; 
            } 
        },
        methods: {
          enableSlimScroll() {
                $('#scroll-items').slimScroll({
                  color: '#00f',
                  size: '8px',
                  height: '500px', //300px
                  //height: auto,
                  wheelStep: 10                  
                });
          },
          expandAddItemPanel() {
            this.show = !this.show;
          },
         
          fetchAvailableItems() {
            this.loading = true;
            this.availableItemList= [];            
            var vm = this;                
            axios.get('/api/items')  //--> api/bus?q=xyz        (right)
                .then(function (response) {                  
                   response.data.error ? vm.error = response.data.error : vm.availableItemList = response.data;
                   vm.loading = false;
                  //vm.availableItemsSortByItemName(vm.busAvailableToCityList); 
                  vm.availableItemsSortByItemName(vm.availableItemList);                 
            });
          },
          /*isSortingAvailableBy(val) {
            if (val== 'name') {
                this.availableItemsSortByItemName(this.busAvailableToCityList);
                this.disableSorting = true;
                return;
            }
            this.SortByDivisionBusAvailableToCityList(this.busAvailableToCityList);
            this.disableSorting = false;
          },*/

          removeItem(item) {  // role id of user/staff in roles table
            var vm = this;
            //this.itemName = item.name; 
            this.itemNameForAction = item.name; 
            swal({
              title: "Are you sure?",
              text: "This item will be Removed!",
              icon: "error",                 
              dangerMode: true,
              buttons: {
                  cancel: "cancel",
                  confirm: {
                    text: "Remove It!",
                    value: true,
                  },                                
              },
            })
            .then((value) => {
              if (value) {

                vm.loading = true;
                vm.response = '';
                vm.showAlert = false;
                axios.post('/delete', {                            
                    item_id: item.id, 
                })          
                .then(function (response) {                                           
                    // response.data.error ? vm.error = response.data.error : vm.busAvailableToCityList = response.data;
                    response.data.error ? vm.error = response.data.error : vm.response = response.data;

                    if (vm.response) {                                
                        vm.removeItemFromAvailableItemList(item.id); // update the array after removing
                        vm.loading = false;
                        vm.actionStatus = 'Removed';
                        vm.alertType = 'danger';
                        vm.showAlert= true;
                        return;                                                      
                    }                            
                    vm.loading = false;

                });       
                
              } 
              
            }); 
          },
         
          removeItemFromAvailableItemList(itemId) {
            var indx = this.availableItemList.findIndex(function(item){ 
                // here 'city' is array object 
                 return item.id == itemId;
            });        
            this.availableItemList.splice(indx, 1);
            //return;
          },
          saveItems() {
            var vm = this;
            //this.loading = true;
            // console.log('itemId',this.selectedCity.id);
            // console.log('itemName',this.selectedCity.name);
            axios.post('/items', {
                //item_id: this.item.id,
                item_name: this.itemName,               

            })          
            .then(function (response) {
                //console.log(response.data);
                response.data.error ? vm.error = response.data.error : vm.response = response.data;
                if (vm.response) {
                   //console.log(vm.response);
                   vm.fetchAvailableItems();
                   vm.availableItemsSortByItemName(vm.availableItemList);
                   vm.loading = false;
                   vm.disableSaveButton = true;
                   vm.itemAddedAlert(vm.itemName);
                   vm.reset();
                   return;                   
                }
                vm.loading = false;
                vm.disableSaveButton = true;
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
          reset() {
            this.itemName = '';
          },         
          itemAddedAlert(itemName) {
              swal({
                //title: "Sorry! Not Available",
                //title: '<span style="color:#A5DC86"> <strong>'+itemName+'</strong></span></br> Added successfully!',
                title: itemName,
                text: 'Added successfully!', 
                //text: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span> Not Available.',
                //html: true,
                //type: "info",
                icon: "success",
                timer: 2000,
                closeOnClickOutside: false,
              });
          }
        }
    }
</script>

<style lang="scss" scoped>
    .item-list {
      margin-top: 2.5rem;
    }
    #scroll-items {
        span {
            cursor: pointer;
            margin-left: 5px;
        }
        span[disabled] {
            cursor: not-allowed;
            opacity: 0.65;
        }
    } 

</style>