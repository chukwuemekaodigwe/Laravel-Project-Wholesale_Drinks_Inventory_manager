<template>
  <!-- Mobile -->
  <div class="px-4 py-3 flex items-center justify-between sm:px-6">
    <div class="flex-1 flex justify-between sm:hidden">
      <a :href="pagination.prev_page_url" :class="pagination.prev_page_url == null
        ? 'relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-white bg-opacity-30 hover:cursor-text'
        : 'relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50'
      "> Previous </a>
      <a :href="pagination.next_page_url" :class="pagination.next_page_url == null
        ? 'ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-white bg-opacity-30 hover:cursor-text'
        : 'relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50'
      "> Next </a>
    </div>

    <!-- Showing x to x of xx -->
    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          {{ ' ' }}
          <span class="font-medium">{{ pagination.from || 0 }}</span>
          {{ ' ' }}
          to
          {{ ' ' }}
          <span class="font-medium">{{ pagination.to || 0 }}</span>
          {{ ' ' }}
          of
          {{ ' ' }}
          <span class="font-medium">{{ pagination.total || 0 }}</span>
          {{ ' ' }}
          results
        </p>
      </div>

      <!-- Pages -->
      <div>
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <!-- Loop over links -->
          <template v-for="(link, key) in pagination.links">

            <!-- Custom links for < Previous and Next > -->
            <a v-if="createLabel(link.label) == 'Previous'" :href="link.url" :class="link.url === null
              ? 'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white bg-opacity-30 text-sm font-medium text-gray-200 hover:cursor-text'
              : 'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50'
            ">
              <span class="sr-only">Previous</span>
              <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
            </a>
            <a v-else-if="createLabel(link.label) == 'Next'" :href="link.url" :class="link.url === null
              ? 'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white bg-opacity-30 text-sm font-medium text-gray-200 hover:cursor-text'
              : 'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50'
            ">
              <span class="sr-only">Next</span>
              <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
            </a>

            <!-- Link -->
            <a v-else :href="link.url" :class="link.active
              ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium'
              : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium'
            ">
              <!-- Label -->
              {{ createLabel(link.label) }}
            </a>

          </template>
        </nav>
      </div>
    </div>
  </div>
</template>
  
<script>
//import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid'
import { Link } from "@inertiajs/inertia-vue3";
import { smartPagination } from '@/paginate.js'
export default {
  components: {
    Link,
    ChevronLeftIcon,
    ChevronRightIcon
  },
  methods: {
    createLabel(label) {
      if (label.includes('Previous')) {
        return 'Previous'
      } else if (label.includes('Next')) {
        return 'Next'
      } else {
        return label
      }
    }
  },
  props: {
    pagination: Object,
  },
};
</script>