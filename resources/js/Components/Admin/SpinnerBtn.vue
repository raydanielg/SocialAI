<script setup>
import { computed } from "vue"

const defaultClasses = computed(() => {
  return location.pathname.startsWith("/admin")
    ? "btn btn-primary flex items-center"
    : "tp-btn d-flex align-items-center justify-content-center"
})

const props = defineProps({
  processing: {
    type: Boolean,
    default: false,
  },
  btnText: {
    type: String,
    default: "Save",
  },
  classes: {
    type: String,
    default: "btn btn-primary flex items-center", // for admin end default btn
  },
  size: {
    type: Number,
    default: 30,
  },
  icon: {
    type: String,
    default: "bx bx-save",
  },
})
</script>

<template>
  <button type="submit" :class="classes == '' ? defaultClasses : classes" :disabled="processing">
    <template v-if="processing">
      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
        height="24px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <g transform="rotate(0 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.9285714285714286s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(25.714285714285715 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.8571428571428571s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(51.42857142857143 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.7857142857142857s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(77.14285714285714 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.7142857142857143s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(102.85714285714286 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.6428571428571429s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(128.57142857142858 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5714285714285714s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(154.28571428571428 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5s"
              repeatCount="indefinite">
            </animate>
          </rect>
        </g>
        <g transform="rotate(180 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.42857142857142855s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(205.71428571428572 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.35714285714285715s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(231.42857142857142 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.2857142857142857s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(257.14285714285717 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.21428571428571427s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(282.85714285714283 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.14285714285714285s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(308.57142857142856 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.07142857142857142s"
              repeatCount="indefinite"></animate>
          </rect>
        </g>
        <g transform="rotate(334.2857142857143 50 50)">
          <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#fff">
            <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite">
            </animate>
          </rect>
        </g>
      </svg>
    </template>
    <i v-else-if="icon" :class="icon"></i>
    <span v-html="sanitizeHtml(btnText)"></span>
  </button>
</template>
