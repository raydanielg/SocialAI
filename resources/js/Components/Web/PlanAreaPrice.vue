

<script setup>

const plan_content = {
  tp_title: "Compare our plans",
  tp_des: `Comparing our pricing plans side-by-side so you can choose the best <br /> one for yourself.`,
  feature_title: "Features and Services",
  feature_items: [
    { id: 1, cls: "", title: "BASIC", btn_text: "Get Basic" },
    { id: 2, cls: "active", title: "Growth", btn_text: "Get Growth" },
    { id: 3, cls: "", title: "Premium", btn_text: "Get Premium" },
  ],
  feature_lists: [
    {
      id: 1,
      title: "Version history",
      features: [`<span>30days</span>`, `<i class="far fa-check"></i>`, `<i class="far fa-check"></i>`,],
    },
    {
      id: 2,
      title: "Send invoices and quotes",
      features: [`<i class="far fa-check"></i>`, `<i class="far fa-check"></i>`, `<i class="far fa-check"></i>`,],
    },
    {
      id: 3,
      title: "Cross platform",
      features: [`<i class="far fa-check"></i>`, `<i class="far fa-check"></i>`, `<i class="far fa-check"></i>`,],
    },
    {
      id: 4,
      title: "Scan receipts and bills",
      features: [`<i class="far fa-check"></i>`, `<i class="far fa-check"></i>`, `<i class="far fa-check"></i>`,],
    },
    {
      id: 5,
      title: "Storage",
      features: [`<span>50gb</span>`, `<span>100gb</span>`, `<span>Unlimited</span>`,],
    },
    {
      id: 6,
      title: "Advanced analytics",
      features: [`<i class="far fa-times times"></i>`, `<i class="far fa-times times"></i>`, `<i class="far fa-check"></i>`,],
    },
    {
      id: 7,
      title: "Projections dashboard",
      features: [`<i class="far fa-times times"></i>`, `<i class="far fa-check"></i>`, `<i class="far fa-check"></i>`,],
    },
    {
      id: 8,
      title: "Invoice tracking and payments",
      features: [`<i class="far fa-check"></i>`, `<i class="far fa-times times"></i>`, `<i class="far fa-check"></i>`,],
    },
    {
      id: 9,
      title: "Collaboration",
      features: [`<span>100</span>`, `<span>1000</span>`, `<span>Unlimited</span>`,],
    },
    {
      id: 10,
      title: "Unlimited single-use virtual cards",
      features: [`<i class="far fa-check"></i>`, `<i class="far fa-check"></i>`, `<i class="far fa-check"></i>`,],
    },
    {
      id: 11,
      title: "Cross platform",
      features: [`<i class="far fa-times times"></i>`, `<i class="far fa-times times"></i>`, `<i class="far fa-check"></i>`,],
    },
    {
      id: 12,
      title: "Multi-currency functionality",
      features: [`<i class="far fa-check"></i>`, `<i class="far fa-times times"></i>`, `<i class="far fa-check"></i>`,],
    },
  ],

}
const { tp_title, tp_des, feature_title, feature_items, feature_lists } = plan_content
</script>

 
 
<template>
  <!--plan-area-start -->
  <div class="plan-area pb-110">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-6">
          <div class="plan-section-box text-center pb-20">
            <h3 class="tp-section-title tp-section-title-shape p-relative">
              {{ tp_title }}
              <svg width="220" height="9" viewBox="0 0 220 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M202.386 1.05664C197.577 0.824859 192.769 0.654425 187.96 0.456733C186.373 0.388562 184.779 0.388584 183.192 0.354499C179.748 0.279516 176.303 0.211338 172.859 0.136347C170.943 0.0954477 169.02 0.0477334 167.105 0.013648C166.545 0.00683097 165.995 0 165.436 0C164.187 0 162.937 0.0136128 161.687 0.0204299C156.007 0.027247 150.319 0.0340772 144.639 0.0340772C143.282 0.0340772 141.934 0.0613441 140.577 0.0749782C137.223 0.109064 133.878 0.149987 130.532 0.184073C126.751 0.224978 122.977 0.238574 119.196 0.320384C113.08 0.443086 106.973 0.572644 100.856 0.695352C97.3133 0.770343 93.7786 0.811219 90.2352 0.927108C84.1358 1.13162 78.0444 1.32932 71.945 1.52701C68.6158 1.63609 65.2783 1.72472 61.949 1.88151C55.644 2.17465 49.3389 2.46094 43.0338 2.75408C39.6635 2.91087 36.2931 3.02676 32.931 3.26536C26.6506 3.70846 20.3784 4.15158 14.098 4.59469C12.7416 4.69013 11.3853 4.78555 10.0289 4.88099C7.31613 5.07187 4.61987 5.37184 1.91535 5.62407C1.74272 5.64452 1.57832 5.66498 1.40569 5.67862C1.0851 5.75361 0.797379 5.88993 0.558988 6.08762C0.205511 6.38076 0 6.78978 0 7.20565C0 7.62145 0.205511 8.0305 0.558988 8.33044C0.879583 8.59627 1.43857 8.84172 1.91535 8.79405C5.17886 8.48722 8.43411 8.16683 11.6976 7.9351C14.731 7.72375 17.7561 7.50558 20.7894 7.29424C24.094 7.0625 27.3986 6.8307 30.7033 6.5989C32.0349 6.50346 33.3667 6.38077 34.7066 6.31942C39.8608 6.08083 45.015 5.84902 50.1692 5.61042C53.3834 5.46045 56.5976 5.31732 59.8117 5.16734C61.1435 5.10598 62.4669 5.03099 63.7986 4.98326C68.9035 4.81284 74.0167 4.65603 79.1215 4.49924C82.2207 4.4038 85.3112 4.30155 88.4104 4.20611C89.4545 4.17203 90.4907 4.13111 91.534 4.11066C97.05 4.00159 102.566 3.89936 108.082 3.7971C111.165 3.73575 114.239 3.68121 117.322 3.61986C118.415 3.5994 119.516 3.5653 120.61 3.55848C126.298 3.51077 131.987 3.46307 137.675 3.41535C141.226 3.38127 144.77 3.35399 148.321 3.36081C154.363 3.37444 160.405 3.38124 166.439 3.39488C167.631 3.39488 168.823 3.43581 170.015 3.4699C173.352 3.55171 176.682 3.6335 180.019 3.71531C182.518 3.77666 185.017 3.83798 187.524 3.89934C189.299 3.94023 191.067 4.04932 192.843 4.13114C198.062 4.36291 203.283 4.60834 208.494 4.87421C209.818 4.94238 211.141 5.02416 212.465 5.10597C213.887 5.18777 215.309 5.2764 216.723 5.40592C216.945 5.43319 217.158 5.46729 217.381 5.50819C217.94 5.60363 218.474 5.57636 218.975 5.33776C219.436 5.1128 219.781 4.73786 219.929 4.30838C220.225 3.40853 219.567 2.4473 218.482 2.19507C217.529 1.97693 216.542 1.88834 215.564 1.80654C214.89 1.752 214.224 1.69065 213.55 1.63611C212.259 1.52704 210.961 1.47247 209.67 1.39066C207.245 1.26114 204.812 1.17252 202.386 1.05664Z"
                  fill="#6B14FA" />
              </svg>
            </h3>
            <p v-html="sanitizeHtml(tp_des)"></p>
          </div>
        </div>
      </div>
      <div class="pr-feature-box">
        <div class="pr-feature-main">
          <div class="pr-feature-wrapper">
            <div class="row gx-0 align-items-center">
              <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="pr-feature-head">
                  <div class="pr-feature-title-box">
                    <h5 class="pr-feature-title">{{ feature_title }}</h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-8 col-lg-8 col-md-8">
                <div class="pr-feature-head">
                  <ul>

                    <li v-for="(item, i) in feature_items" :key="i">
                      <div :class="`pr-feature-item ${i === 1 ? 'active' : ''}`">
                        <h5>{{ item.title }}</h5>
                        <NuxtLink class="tp-btn-service black-bg text-white" to="/service-details">{{ item.btn_text }}
                        </NuxtLink>
                      </div>
                    </li>

                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="pr-feature-wrapper-2">


            <div v-for="(item, i) in feature_lists" :key="i" class="row gx-0 align-items-center pr-feature-height">
              <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="pr-feature-bottom">
                  <div class="pr-feature-title-box">
                    <h5 class="pr-feature-title-sm">{{ item.title }}</h5>
                  </div>
                </div>
              </div>
              <div class="col-xl-8 col-lg-8 col-md-8">
                <div class="pr-feature-bottom">
                  <ul>
                    <li v-for="(feature, index) in item.features" :key="index" v-html="sanitizeHtml(feature)"></li>
                  </ul>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!--plan-area-end -->
</template>

 