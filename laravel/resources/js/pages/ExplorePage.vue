<template>
  <div>
    <!-- Search Section -->
    <section class="bg-gradient-to-r from-slate-950 to-sky-900 text-white">
      <div class="max-w-7xl mx-auto px-4 py-16">
        <h1 class="text-5xl font-bold mb-4">Explore Services</h1>
        <p class="text-lg text-slate-300 mb-10">
          Discover talented freelancers ready to bring your project to life
        </p>

        <div class="flex flex-col md:flex-row gap-4 max-w-3xl">
          <div class="relative flex-1">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"</span>
            <input
              v-model="searchTerm"
              @input="applyFilters"
              type="text"
              placeholder="Search by title, category, keyword, or user..."
              class="w-full pl-12 pr-4 py-4 rounded-xl bg-slate-700/70 border border-slate-500 text-white placeholder-slate-300 outline-none"
            />
          </div>

          <select
            v-model="selectedCategory"
            @change="applyFilters"
            class="px-4 py-4 rounded-xl bg-slate-700/70 border border-slate-500 text-white outline-none md:w-56"
          >
            <option value="">All Categories</option>
            <option v-for="category in categories" :key="category" :value="category">
              {{ category }}
            </option>
          </select>
        </div>
      </div>
    </section>

    <!-- Recently Added Secton-->
    <section class="max-w-7xl mx-auto px-4 py-12">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h2 class="text-3xl font-bold text-slate-900">Recently Added</h2>
          <p class="text-slate-500">The latest services from our community</p>
        </div>

        <span class="bg-sky-500 text-white text-sm font-medium px-4 py-2 rounded-full">
          NEW
        </span>
      </div>

      <div v-if="recentServices.length" class="grid md:grid-cols-3 gap-6">
        <RecentServiceCard
          v-for="service in recentServices"
          :key="service.id"
          :service="service"
          :is-favourited="favouriteIds.includes(service.id)"
        />
      </div>

      <p v-else class="text-slate-500">No recent services found.</p>
    </section>

    <!-- All Services Section -->
    <section class="max-w-7xl mx-auto px-4 pb-12">
      <div class="mb-6">
        <h2 class="text-3xl font-bold text-slate-900">All Services</h2>
        <p class="text-slate-500">{{ filteredServices.length }} services found</p>
      </div>

      <div v-if="filteredServices.length" class="grid md:grid-cols-3 gap-6">
        <ServiceCard
          v-for="service in filteredServices"
          :key="service.id"
          :service="service"
          :is-favourited="favouriteIds.includes(service.id)"
        />
      </div>

      <p v-else class="text-slate-500">No services found.</p>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import ServiceCard from '../components/ServiceCard.vue'
import RecentServiceCard from '../components/RecentServiceCard.vue'

const categories = [
  'Web Development',
  'Graphic Design',
  'Photography',
  'Video Editing',
  'Writing & Editing',
  'Tutoring',
  'Music & Audio',
  'Data Entry',
  'Social Media Management',
  'Translation',
]

const allServices = ref([])
const recentServices = ref([])
const filteredServices = ref([])
const favouriteIds = ref([])

const searchTerm = ref('')
const selectedCategory = ref('')

const fetchServices = async () => {
  try {
    const token = localStorage.getItem('token')

    const response = await fetch('/api/v1/services', {
      headers: {
        Accept: 'application/json',
        Authorization: token ? `Bearer ${token}` : '',
      },
    })

    const data = await response.json()

    allServices.value = Array.isArray(data) ? data : data.services || []

    allServices.value.sort((a, b) => {
      return new Date(b.created_at) - new Date(a.created_at)
    })

    recentServices.value = allServices.value.slice(0, 3)
    filteredServices.value = allServices.value
  } catch (error) {
    console.log('Error fetching services:', error)
  }
}

const fetchFavourites = async () => {
  try {
    const token = localStorage.getItem('token')
    const userId = localStorage.getItem('user_id')

    if (!token || !userId) {
      favouriteIds.value = []
      return
    }

    const response = await fetch(`/api/v1/users/${userId}/favourites`, {
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${token}`,
      },
    })

    const data = await response.json()

    if (response.ok && Array.isArray(data)) {
      favouriteIds.value = data.map((service) => service.id)
    } else {
      favouriteIds.value = []
    }
  } catch (error) {
    console.log('Error fetching favourites:', error)
    favouriteIds.value = []
  }
}


//Search Bar Filter 
const applyFilters = () => {
  const term = searchTerm.value.toLowerCase().trim()
  const category = selectedCategory.value.toLowerCase().trim()

  filteredServices.value = allServices.value.filter((service) => {
    const title = service.title ? service.title.toLowerCase() : ''
    const description = service.description ? service.description.toLowerCase() : ''
    const serviceCategory = service.category ? service.category.toLowerCase() : ''
    const userName = service.user && service.user.name
      ? service.user.name.toLowerCase()
      : ''

    const matchesSearch =
      !term ||
      title.includes(term) ||
      description.includes(term) ||
      serviceCategory.includes(term) ||
      userName.includes(term)

    const matchesCategory =
      !category ||
      serviceCategory === category

    return matchesSearch && matchesCategory
  })
}

onMounted(async () => {
  await fetchServices()
  await fetchFavourites()
})
</script>