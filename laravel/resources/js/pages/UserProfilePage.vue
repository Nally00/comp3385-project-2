<template>
  <div>
    <div v-if="user">
    
      <!-- User Details Section -->
      <section class="bg-gradient-to-r from-slate-950 to-sky-900 text-white">
        <div class="max-w-7xl mx-auto px-4 py-14">
          <div class="flex flex-col md:flex-row md:items-center gap-8">
            <div>
              <img
                v-if="photoUrl"
                :src="photoUrl"
                alt="User photo"
                class="w-32 h-32 rounded-full object-cover border-4 border-white/20"
              />

              <div
                v-else
                class="w-32 h-32 rounded-full bg-white/20 flex items-center justify-center text-4xl font-semibold"
              >
                {{ userInitial }}
              </div>
            </div>

            <div class="flex-1">
              <h1 class="text-5xl font-bold mb-3">{{ user.name }}</h1>

              <p class="text-slate-300 text-lg mb-4">
                 {{ user.location || 'Location not provided' }}
                <span class="mx-2">·</span>
                Member since {{ memberSince }}
              </p>

              <p class="text-slate-200 max-w-3xl leading-8 mb-8">
                {{ user.biography || 'No biography available.' }}
              </p>

              <div class="flex gap-12">
                <div>
                  <p class="text-4xl font-bold">{{ userServices.length }}</p>
                  <p class="text-slate-300">Services</p>
                </div>

                <div>
                  <p class="text-4xl font-bold">{{ favouriteServices.length }}</p>
                  <p class="text-slate-300">Favourites</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- User's Services Section-->
      <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="mb-6">
          <h2 class="text-3xl font-bold text-slate-900">{{ user.name }}'s Services</h2>
        </div>

        <div v-if="userServices.length" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <ServiceCard
            v-for="service in userServices"
            :key="service.id"
            :service="service"
          />
        </div>

        <p v-else class="text-slate-500">This user has not listed any services yet.</p>
      </section>

      <!-- User's Favourites Section -->
      <section class="max-w-7xl mx-auto px-4 pb-12">
        <div class="mb-6">
          <h2 class="text-3xl font-bold text-slate-900">{{ user.name }}'s Favourites</h2>
        </div>

        <div v-if="favouriteServices.length" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <ServiceCard
            v-for="service in favouriteServices"
            :key="service.id"
            :service="service"
          />
        </div>

        <p v-else class="text-slate-500">This user has not favourited any services yet.</p>
      </section>
    </div>
  </div>
</template>







<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import ServiceCard from '../components/ServiceCard.vue'

const route = useRoute()

const user = ref(null)
const userServices = ref([])
const favouriteServices = ref([])
const loading = ref(true)
const errorMessage = ref('')

const fetchProfile = async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    const token = localStorage.getItem('token')

    const userResponse = await fetch(`/api/v1/users/${route.params.user_id}`, {
      headers: {
        Accept: 'application/json',
        Authorization: token ? `Bearer ${token}` : '',
      },
    })

    const userData = await userResponse.json()

    if (!userResponse.ok) {
      errorMessage.value = userData.message || 'Failed to load user profile.'
      loading.value = false
      return
    }

    user.value = userData
    userServices.value = userData.services || []

    const favouritesResponse = await fetch(`/api/v1/users/${route.params.user_id}/favourites`, {
      headers: {
        Accept: 'application/json',
        Authorization: token ? `Bearer ${token}` : '',
      },
    })

    const favouritesData = await favouritesResponse.json()

    if (favouritesResponse.ok) {
      favouriteServices.value = Array.isArray(favouritesData) ? favouritesData : []
    }
  } catch (error) {
    errorMessage.value = 'Something went wrong.'
  } finally {
    loading.value = false
  }
}

const photoUrl = computed(() => {
  if (!user.value?.photo) return ''

  if (user.value.photo.startsWith('http')) {
    return user.value.photo
  }

  return `/storage/${user.value.photo}`
})

const userInitial = computed(() => {
  return user.value?.name ? user.value.name.charAt(0).toUpperCase() : 'U'
})

const memberSince = computed(() => {
  if (!user.value?.created_at) return ''

  const date = new Date(user.value.created_at)

  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
  })
})

onMounted(() => {
  fetchProfile()
})
</script>