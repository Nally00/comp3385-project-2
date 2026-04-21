<template>
  <div>
    <section class="bg-slate-900 text-white">
      <div class="max-w-6xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-8 items-center">
        <div>
          <h1 class="text-4xl font-bold mb-4">
            Find the skills you need,
            <span class="text-sky-400">offer the skills you have.</span>
          </h1>

          <p class="text-slate-300 mb-6">
            UniGigs is a freelance marketplace where users can browse services,
            connect with skilled people, and also offer their own services.
          </p>

          <div class="flex gap-4 flex-wrap">
            <router-link
              to="/explore"
              class="px-5 py-3 bg-sky-500 rounded-md font-medium hover:bg-sky-600"
            >
              Explore Services
            </router-link>

            <router-link
              to="/register"
              class="px-5 py-3 border border-white rounded-md font-medium hover:bg-white hover:text-slate-900"
            >
              Get Started
            </router-link>
          </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-4">
          <img
            src="/public/images/homepage_pic.jpg"
            alt="Homepage image"
            class="w-full h-[320px] object-cover rounded-lg"
          />
        </div>
      </div>
    </section>

    <section class="bg-white py-16">
      <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-10">
          <h2 class="text-3xl font-bold mb-2">Why Choose UniGigs?</h2>
          <p class="text-slate-600">
            Everything you need to find or offer freelance services
          </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-slate-50 border border-slate-200 rounded-xl p-6">
            <h3 class="font-semibold mb-2">Discover Talent</h3>
            <p class="text-sm text-slate-600">
              Browse different services and find someone that matches your needs.
            </p>
          </div>

          <div class="bg-slate-50 border border-slate-200 rounded-xl p-6">
            <h3 class="font-semibold mb-2">Save Favourites</h3>
            <p class="text-sm text-slate-600">
              Keep track of services you like and return to them later.
            </p>
          </div>

          <div class="bg-slate-50 border border-slate-200 rounded-xl p-6">
            <h3 class="font-semibold mb-2">Offer Your Skills</h3>
            <p class="text-sm text-slate-600">
              Add your own services and let other users discover what you offer.
            </p>
          </div>

          <div class="bg-slate-50 border border-slate-200 rounded-xl p-6">
            <h3 class="font-semibold mb-2">Easy to Use</h3>
            <p class="text-sm text-slate-600">
              A simple platform for students and professionals to connect.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="bg-sky-600 text-white py-16">
      <div class="max-w-6xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-3">Ready to get started?</h2>
        <p class="mb-6 text-sky-100">
          Join UniGigs today and start browsing or listing services.
        </p>

        <div class="flex justify-center gap-4 flex-wrap">
          <router-link
            to="/register"
            class="px-5 py-3 bg-white text-sky-700 rounded-md font-medium hover:bg-slate-100"
          >
            Create Account
          </router-link>

          <router-link
            to="/explore"
            class="px-5 py-3 border border-white rounded-md font-medium hover:bg-white hover:text-sky-700"
          >
            Browse Services
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
</script>