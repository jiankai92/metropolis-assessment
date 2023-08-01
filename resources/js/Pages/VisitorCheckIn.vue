<template>
  <nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <div class="shrink-0 flex items-center">
            <Link :href="route('dashboard')">
              <ApplicationLogo
                  class="block h-9 w-auto fill-current text-gray-800"
              />
            </Link>
          </div>

          <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <NavLink :href="route('visitor.checkin.show')" :active="route().current('visitor.checkin.show')">
              Visitor Check In
            </NavLink>
            <NavLink v-if="$page.props.auth.user" :href="route('dashboard')" :active="route().current('dashboard')">
              Dashboard
            </NavLink>
            <template v-else>
              <NavLink :href="route('login')" :active="route().current('login')">
                Log in
              </NavLink>
            </template>
          </div>
        </div>
        <!-- Hamburger -->
        <div class="-mr-2 flex items-center sm:hidden">
          <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
          >
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path
                  :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
              />
              <path
                  :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div
        :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
        class="sm:hidden"
    >
      <div class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink :href="route('visitor.checkin.show')" :active="route().current('visitor.checkin.show')">
          Visitor Check In
        </ResponsiveNavLink>
      </div>
      <div class="pt-2 pb-3 space-y-1" v-if="$page.props.auth.user">
        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
          Dashboard
        </ResponsiveNavLink>
      </div>
      <div class="pt-2 pb-3 space-y-1" v-else>
        <ResponsiveNavLink :href="route('login')" :active="route().current('login')">
          Log in
        </ResponsiveNavLink>
      </div>

      <!-- Responsive Settings Options -->
      <div class="pt-4 pb-1 border-t border-gray-200" v-if="$page.props.auth.user">
        <div class="px-4">
          <div class="font-medium text-base text-gray-800">
            {{ $page.props.auth.user.name }}
          </div>
          <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
        </div>

        <div class="mt-3 space-y-1">
          <ResponsiveNavLink :href="route('profile.edit')"> Profile</ResponsiveNavLink>
          <ResponsiveNavLink :href="route('logout')" method="post" as="button">
            Log Out
          </ResponsiveNavLink>
        </div>
      </div>
    </div>
  </nav>
  <div class="min-h-screen flex flex-col sm:justify-center items-center sm:pt-0 bg-gray-100">
    <div>
      <h2 class="text-4xl text-gray-700 p-6 font-semibold">Visitor Check-In</h2>
    </div>
    <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
      <form @submit.prevent="submit">
        <div>
          <InputLabel for="name" value="Name"/>

          <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
          />

          <InputError class="mt-2" :message="form.errors.name"/>
        </div>
        <div class="mt-4">
          <label for="type" class="block font-medium text-sm text-gray-700">Visitor Type</label>
          <select v-model="form.type" id="type" @change="visitorTypeChanged()"
                  class="border border-gray-300 text-sm rounded-lg focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full p-2.5">
            <option value="walk_in">Walk-In</option>
            <option value="vehicle">Vehicle</option>
          </select>
        </div>
        <div class="mt-4" v-if="isVehicle">
          <InputLabel for="vehicle_reg_no" value="Vehicle Registration No"/>

          <TextInput
              id="vehicle_reg_no"
              type="text"
              class="mt-1 block w-full"
              v-model="form.vehicle_reg_no"
              required
              autocomplete="vehicle_reg_no"
          />

          <InputError class="mt-2" :message="form.errors.vehicle_reg_no"/>
        </div>

        <div class="mt-4">
          <label for="remarks" class="block mb-2 text-sm font-medium">Remarks</label>
          <textarea v-model="form.remarks" id="remarks" rows="4"
                    class="block p-2.5 w-full text-sm rounded-lg border focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    placeholder="Remarks"></textarea>

          <InputError class="mt-2" :message="form.errors.remarks"/>
        </div>


        <div class="flex items-center justify-center mt-4">
          <PrimaryButton class="w-full text-center" :class="{ 'opacity-25': form.processing }"
                         :disabled="form.processing">
            Check In
          </PrimaryButton>
        </div>
      </form>
      <Transition>
        <div class="mt-2" v-if="flashErrorMessage !== ''|| flashSuccessMessage!== ''">
          <span class="error text-red-700">{{ flashErrorMessage }}</span>
          <span class="success text-green-700">{{ flashSuccessMessage }}</span>
        </div>
      </Transition>
    </div>
  </div>
</template>

<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {ref, reactive, watch} from 'vue';

const props = defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  errorMessage: {
    type: String,
  },
  successMessage: {
    type: String,
  }
});
const showingNavigationDropdown = ref(false);
const form = useForm({
  name: '',
  type: 'walk_in',
  vehicle_reg_no: '',
  remarks: '',
});
const submit = () => {
  form.post(route('visitor.checkin.create'), {});
};
watch(() => props.errorMessage, (newErrorMessage, oldErrorMessage) => {
  flashErrorMessage.value = newErrorMessage;
});
watch(() => props.successMessage, (newSuccessMessage, oldSuccessMessage) => {
  flashSuccessMessage.value = newSuccessMessage;
  if (flashSuccessMessage.value !== "") {
    form.reset('name', 'type', 'vehicle_reg_no', 'remarks')
    visitorTypeChanged();
    setTimeout(function () {
      flashSuccessMessage.value = "";
    }, 5000);
  }
});
let flashErrorMessage = ref(props.errorMessage)
let flashSuccessMessage = ref(props.successMessage)
const isVehicle = ref(form.type === 'vehicle')
const state = reactive({
  isVehicle: form.type === 'vehicle',
  flashErrorMessage: '',
  flashSuccessMessage: ''
});
const visitorTypeChanged = () => {
  isVehicle.value = form.type === 'vehicle';
}
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