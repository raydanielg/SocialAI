<script setup>
const { counter } = defineProps(["counter"]);
</script>

<template>
  <div class="tp-counter-area tp-counter-space p-relative pb-140">
    <div class="tp-counter-shape-2">
      <img src="/assets/img/counter/counter-shape-2.png" alt="" />
    </div>
    <div class="tp-counter-shape-3">
      <img src="/assets/img/counter/counter-shape-1.png" alt="" />
    </div>
    <div class="tp-counter-shape-4 d-none d-sm-block">
      <img src="/assets/img/counter/counter-shape-4.png" alt="" />
    </div>
    <div class="container">
      <div class="tp-counter-wrapper p-relative">
        <div class="row gx-0">
          <div class="col-xl-4 col-lg-4 col-md-4">
            <div class="tp-counter-wrap d-flex justify-content-center">
              <div class="tp-counter-item">
                <h4>
                  <span
                    data-purecounter-duration="1"
                    data-purecounter-end="350"
                    class="purecounter"
                    >{{ counter.one_title }}</span
                  >
                </h4>
                <p>{{ counter.one_subtitle }}</p>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-4">
            <div class="tp-counter-wrap d-flex justify-content-center">
              <div class="tp-counter-item">
                <h4>
                  <span
                    data-purecounter-duration="1"
                    data-purecounter-end="10"
                    class="purecounter"
                    >{{ counter.two_title }}</span
                  >
                </h4>
                <p>{{ counter.two_subtitle }}</p>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-4">
            <div class="tp-counter-wrap d-flex justify-content-center">
              <div class="tp-counter-item">
                <h4>
                  <span
                    data-purecounter-duration="1"
                    data-purecounter-end="500"
                    class="purecounter"
                    >{{ counter.three_title }}</span
                  >
                </h4>
                <p>{{ counter.three_subtitle  }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
