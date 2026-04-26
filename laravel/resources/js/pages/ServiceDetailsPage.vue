<template>
  <div class="max-w-7xl mx-auto px-4 py-10">
    <p v-if="loading" class="text-slate-500">Loading service...</p>
    <p v-if="errorMessage" class="text-red-600">{{ errorMessage }}</p>

    <div v-if="service" class="grid lg:grid-cols-[2fr_1fr] gap-8">

      <!-- Photo and Service Detils -->
      <div>
        <div class="relative rounded-2xl overflow-hidden border border-slate-200 mb-6">
          <img
            :src="imageUrl"
            alt="Service image"
            class="w-full h-[420px] object-cover"
          />

          <span
            class="absolute top-4 left-4 bg-sky-500 text-white text-sm font-medium px-4 py-2 rounded-full"
          >
            {{ service.category }}
          </span>
        </div>

        <div class="flex items-center justify-between mb-6">
          <h1 class="text-4xl font-bold text-slate-900">
            {{ service.title }}
          </h1>

          <button
            type="button"
            @click="handleFavourite"
            class="px-5 py-3 border-2 rounded-xl font-medium"
            :class="isFavourited ? 'border-red-400 text-red-500' : 'border-slate-300 text-slate-600'"
          >
            {{ isFavourited ? '♥ Favourited' : '♡ Favourite' }}
          </button>
        </div>

        <hr class="mb-6" />

        <div>
          <h2 class="text-2xl font-semibold text-slate-900 mb-4">About This Service</h2>
          <p class="text-slate-600 leading-8">
            {{ service.description }}
          </p>
        </div>
      </div>

     
      <div class="space-y-6">
        <!-- Price Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
          <div class="mb-6">
            <span class="text-5xl font-bold text-slate-900">${{ service.rate }}</span>
            <span class="text-slate-500 ml-2">{{ service.rate_type }}</span>
          </div>

          <div class="space-y-3 text-sm mb-6">
            <div class="flex justify-between">
              <span class="text-slate-500">Category</span>
              <span class="font-medium text-slate-800">{{ service.category }}</span>
            </div>

            <div class="flex justify-between">
              <span class="text-slate-500">Listed</span>
              <span class="font-medium text-slate-800">{{ formattedDate }}</span>
            </div>
          </div>

          <button
            type="button"
            class="w-full bg-sky-500 text-white py-3 rounded-xl font-medium hover:bg-sky-600"
          >
            Contact Provider
          </button>

          
        </div>

        <!-- Provider Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
          <h2 class="text-2xl font-semibold text-slate-900 mb-4">About the Provider</h2>
          <hr class="mb-5" />

          <div class="flex items-center gap-4 mb-4">
            <img
              v-if="providerPhotoUrl"
              :src="providerPhotoUrl"
              alt="Provider photo"
              class="w-16 h-16 rounded-full object-cover"
            />

            <div
              v-else
              class="w-16 h-16 rounded-full bg-slate-200 flex items-center justify-center text-lg font-medium text-slate-600"
            >
              {{ providerInitial }}
            </div>

            <div>
              <p class="font-semibold text-slate-900 text-lg">
                {{ service.user?.name || 'Unknown User' }}
              </p>
              <p class="text-slate-500 text-sm">
                {{ service.user?.location || 'Location not provided' }}
              </p>
            </div>
          </div>

          <p class="text-slate-600 leading-7 mb-6">
            {{ service.user?.biography || 'No biography available.' }}
          </p>

          <router-link
            :to="`/users/${service.user?.id}`"
            class="block w-full text-center border-2 border-sky-500 text-sky-500 py-3 rounded-xl font-medium hover:bg-sky-50"
          >
            View Profile
          </router-link>
        </div>
      </div>
    </div>

    <p v-if="successMessage" class="text-green-600 mt-6">{{ successMessage }}</p>
  </div>
</template>





<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const service = ref(null)
const loading = ref(true)
const errorMessage = ref('')
const successMessage = ref('')
const isFavourited = ref(false)

const fetchService = async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    const token = localStorage.getItem('token')

    const response = await fetch(`/api/v1/services/${route.params.service_id}`, {
      headers: {
        Accept: 'application/json',
        Authorization: token ? `Bearer ${token}` : '',
      },
    })

    const data = await response.json()

    if (!response.ok) {
      errorMessage.value = data.message || 'Failed to load service.'
      return
    }

    service.value = data
  } catch (error) {
    errorMessage.value = 'Something went wrong.'
  } finally {
    loading.value = false
  }
}

const handleFavourite = async () => {
  successMessage.value = ''
  errorMessage.value = ''

  const token = localStorage.getItem('token')

  if (!token) {
    errorMessage.value = 'You must be logged in to favourite a service.'
    return
  }

  try {
    const response = await fetch(`/api/v1/services/${route.params.service_id}/favourite`, {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${token}`,
      },
    })

    const data = await response.json()

    if (!response.ok) {
      errorMessage.value = data.message || 'Failed to favourite service.'
      return
    }

    isFavourited.value = true
    successMessage.value = 'Service added to favourites.'
  } catch (error) {
    errorMessage.value = 'Something went wrong.'
  }
}



const imageUrl = computed(() => {
  if (!service.value?.photo) {
    return 'https://via.placeholder.com/900x500?text=Service+Image'
  }

  if (service.value.photo.startsWith('http')) {
    return service.value.photo
  }

  if (service.value.photo.startsWith('demo/')) {
    return `/${service.value.photo}`
  }

  return `/storage/${service.value.photo}`
})

const providerPhotoUrl = computed(() => {
  if (!service.value?.user?.photo) {
    return ''
  }

  if (service.value.user.photo.startsWith('http')) {
    return service.value.user.photo
  }

  if (service.value.user.photo.startsWith('demo/')) {
    return `/${service.value.user.photo}`
  }

  return `/storage/${service.value.user.photo}`
})

const providerInitial = computed(() => {
  const name = service.value?.user?.name || 'U'
  return name.charAt(0).toUpperCase()
})

const formattedDate = computed(() => {
  if (!service.value?.created_at) {
    return ''
  }

  const date = new Date(service.value.created_at)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
})

onMounted(() => {
  fetchService()
})
</script>