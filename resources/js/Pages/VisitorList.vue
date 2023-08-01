<template>
  <Head title="Visitor List"/>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Visitor List</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
          <div class="p-6">
            <h3 class="font-semibold text-lg text-gray-800 leading-tight">List of checkins</h3>
            <div v-if="checkIns.length > 0" class="overflow-x">
              <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                  <th scope="col" class="p-2">#</th>
                  <th scope="col" class="p-2">Name</th>
                  <th scope="col" class="p-2">Contact No</th>
                  <th scope="col" class="p-2">Check In Type</th>
                  <th scope="col" class="p-2">Vehicle No</th>
                  <th scope="col" class="p-2">Check In Time</th>
                  <th scope="col" class="p-2">Check Out Time</th>
                  <th scope="col" class="p-2">Action</th>
                </tr>
                <tr>
                  <th scope="col" class="p-2"></th>
                  <th scope="col" class="">
                    <div class="pb-2 bg-white">
                      <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                               xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                          </svg>
                        </div>
                        <input type="text" id="name-search" v-model="filters.name" @change="search()"
                               class="p-2 pl-7 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Search By Name">
                      </div>
                    </div>
                  </th>
                  <th scope="col" class="">
                    <div class="pb-2 bg-white">
                      <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                               xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                          </svg>
                        </div>
                        <input type="text" id="contact-search" v-model="filters.contact_no" @change="search()"
                               class="p-2 pl-7 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Search By Contact">
                      </div>
                    </div>
                  </th>
                  <th scope="col" class="p-2">
                    <select id="type-search" v-model="filters.type" @change="search()"
                            class="border border-gray-300 text-sm rounded-lg focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full p-2.5">
                      <option value="">Select Type</option>
                      <option value="walk_in">Walk-In</option>
                      <option value="vehicle">Vehicle</option>
                    </select>
                  </th>
                  <th scope="col" class="">
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                      </div>
                      <input type="text" id="vehicle-no-search" v-model="filters.vehicle_reg_no" @change="search()"
                             class="p-2 pl-7 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                             placeholder="Search By Vehicle No">
                    </div>
                  </th>
                  <th scope="col" colspan="2" class="p-2">
                    <select id="status-search" v-model="filters.status" @change="search()"
                            class="border border-gray-300 text-sm rounded-lg focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full p-2.5">
                      <option value="">Status</option>
                      <option value="1">Checked Out</option>
                      <option value="0">Not Checked Out</option>
                    </select>
                  </th>
                  <th scope="col" class="p-2"></th>
                </tr>
                </thead>
                <tr v-if="dataCheckIns.length > 0" v-for="(checkIn,index) in dataCheckIns" class="border-b">
                  <td class="whitespace-nowrap p-2 font-medium">{{ index + 1 }}</td>
                  <td class="whitespace-nowrap p-2">{{ checkIn.name }}</td>
                  <td class="whitespace-nowrap p-2">{{ checkIn.contact_no }}</td>
                  <td class="whitespace-nowrap p-2" v-if="checkIn.type === 'walk_in'">Walk In</td>
                  <td class="whitespace-nowrap p-2" v-else-if="checkIn.type === 'vehicle'">Vehicle</td>
                  <td class="whitespace-nowrap p-2" v-else>Invalid Type</td>
                  <td class="whitespace-nowrap p-2" v-if="checkIn.vehicle_reg_no !== null">
                    {{ checkIn.vehicle_reg_no }}
                  </td>
                  <td class="whitespace-nowrap p-2" v-else>-</td>
                  <td class="whitespace-nowrap p-2">{{ checkIn.created_at }}</td>
                  <td class="whitespace-nowrap p-2" v-if="checkIn.checkout_at !== null">
                    {{ checkIn.checkout_at }}
                  </td>
                  <td class="whitespace-nowrap p-2" v-else>-</td>
                  <td class="whitespace-nowrap p-2">
                    <form @submit.prevent="checkout(checkIn)" :id="'checkout_'+checkIn.id"
                          :name="'checkout_'+checkIn.id">
                      <input type="hidden" :value="checkIn.id" name="check_in_id" ref="check_in_id"/>
                      <DangerButton type="submit" :disabled="checkIn.checkout_at !== null">Checkout</DangerButton>
                    </form>
                  </td>
                </tr>
                <tr v-else>
                  <td colspan="8">No Results Found</td>
                </tr>
              </table>

            </div>
            <div v-else>
              No Checkins Found
            </div>
            <Transition>
              <div class="mt-2" v-if="errorMessage !== ''|| successMessage!== ''">
                <span class="error text-red-700">{{ errorMessage }}</span>
                <span class="success text-green-700">{{ successMessage }}</span>
              </div>
            </Transition>
          </div>

        </div>

      </div>
    </div>

  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import {Head, useForm} from '@inertiajs/vue3';
import {onMounted, ref} from 'vue';

const props = defineProps({
  checkIns: {
    type: Array
  }
})
const filters = useForm({
  name: '',
  contact_no: '',
  type: '',
  vehicle_reg_no: '',
  status: '',
})
const dataCheckIns = ref("");
let errorMessage = ref("")
let successMessage = ref("")

const flashSuccessMessage = (message) => {
  successMessage.value = message
  setTimeout(function () {
    successMessage.value = "";
  }, 5000);
}
const clearStatusMessages = () => {
  successMessage.value = '';
  errorMessage.value = '';
}
const showErrorMessage = (message) => {
  errorMessage.value = message
}
const checkout = (checkIn) => {
  clearStatusMessages();
  axios.post('/admin/checkout', {id: checkIn.id})
      .then((response) => {
            checkIn.checkout_at = response.data.checkout_at
            flashSuccessMessage('Successfully Checked out Visitor')
          }
      )
      .catch((error) => {
            showErrorMessage('Failed to Check out Visitor');
          }
      )
}
const search = () => {
  clearStatusMessages();
  axios.post('/visitor/checkin/search', filters)
      .then((response) => {
            dataCheckIns.value = response.data;
          }
      )
      .catch((error) => {
            showErrorMessage('Failed to Fetch search results');
          }
      )
}

onMounted(() => {
  dataCheckIns.value = props.checkIns
});
</script>

<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>