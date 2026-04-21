<template>
  <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    <div class="relative">
      <img
        :src="imageUrl"
        alt="Service image"
        class="w-full h-48 object-cover"
      />

      <span
        class="absolute top-4 left-4 bg-slate-800 text-white text-xs font-medium px-3 py-1 rounded-full"
      >
        {{ service.category }}
      </span>

      <button
        type="button"
        class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white flex items-center justify-center shadow"
      >
        <span :class="isFavourited ? 'text-red-500' : 'text-slate-400'">
          {{ isFavourited ? '♥' : '♡' }}
        </span>
      </button>
    </div>

    <div class="p-5">
      <h3 class="text-2xl font-semibold text-slate-900 mb-3">
        {{ service.title }}
      </h3>

      <div class="flex items-center gap-3 mb-4">
        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-medium text-slate-600">
          {{ userInitial }}
        </div>
        <p class="text-slate-600">{{ service.user?.name || 'Unknown User' }}</p>
      </div>

      <p class="text-slate-500 mb-5 leading-7">
        {{ shortDescription }}
      </p>

      <div class="flex items-end justify-between">
        <div>
          <p class="text-3xl font-bold text-slate-900">${{ service.rate }}</p>
          <p class="text-slate-500">{{ service.rate_type }}</p>
        </div>

        <router-link
          :to="`/services/${service.id}`"
          class="px-5 py-3 bg-sky-500 text-white rounded-xl font-medium hover:bg-sky-600"
        >
          View Details
        </router-link>
      </div>
    </div>
  </div>
</template>




<script setup>
import { computed } from 'vue'

const props = defineProps({
  service: {
    type: Object,
    required: true,
  },
  isFavourited: {
    type: Boolean,
    default: false,
  },
})

const imageUrl = computed(() => {
  if (!props.service.photo) {
    return 'https://via.placeholder.com/600x400?text=Service+Image'
  }

  if (props.service.photo.startsWith('http')) {
    return props.service.photo
  }

  return `/storage/${props.service.photo}`
})

const userInitial = computed(() => {
  const name = props.service.user?.name || 'U'
  return name.charAt(0).toUpperCase()
})

const shortDescription = computed(() => {
  if (!props.service.description) {
    return 'No description available.'
  }

  if (props.service.description.length > 95) {
    return props.service.description.slice(0, 95) + '...'
  }

  return props.service.description
})
</script>