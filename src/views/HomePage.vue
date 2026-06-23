<template>
  <div class="home-page">
    <!-- Hero Section -->
    <HeroSection />

    <!-- Story Section -->
    <StorySection />

    <!-- Profiles Section -->
    <ProfilesSection />

    <!-- Wedding Details Section -->
    <DetailsSection />

    <!-- Gallery Section -->
    <GallerySection />

    <!-- Timeline Section -->
    <TimelineSection />

    <!-- RSVP Section -->
    <RSVPSection />
  </div>
</template>

<script setup>
import HeroSection from '@/components/sections/HeroSection.vue'
import StorySection from '@/components/sections/StorySection.vue'
import ProfilesSection from '@/components/sections/ProfilesSection.vue'
import DetailsSection from '@/components/sections/DetailsSection.vue'
import GallerySection from '@/components/sections/GallerySection.vue'
import TimelineSection from '@/components/sections/TimelineSection.vue'
import RSVPSection from '@/components/sections/RSVPSection.vue'
</script>

<style scoped>
.home-page {
  width: 100%;
}
</style>

