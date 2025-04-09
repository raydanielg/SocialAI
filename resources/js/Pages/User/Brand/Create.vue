<script setup>
import UserLayout from '@/Layouts/User/UserLayout.vue'
import PageHeader from '@/Layouts/Admin/PageHeader.vue'
import Modal from '@/Components/Modal.vue'
import { computed, onMounted, ref } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import { useModalStore } from '@/Store/modalStore'
import axios from 'axios'
import { fabric } from 'fabric'
import sharedComposable from '@/Composables/sharedComposable'
import toast from '@/Composables/toastComposable'
const props = defineProps(['segments', 'buttons', 'categories'])
defineOptions({ layout: UserLayout })

const { countWordsAndChars } = sharedComposable()
const isSpeechRecognitionSupported = ref(false)
const recognition = (() => {
  try {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition
    if (SpeechRecognition) {
      isSpeechRecognitionSupported.value = true
      const recognition = new SpeechRecognition()
      recognition.continuous = true
      recognition.interimResults = true
      recognition.lang = 'en-US'
      return recognition
    }
    return null
  } catch (e) {
    console.warn('Speech recognition not supported in this browser')
    return null
  }
})()
const isListening = ref(false)
const voicedDescription = ref(false)
const modal = useModalStore()
const form = useForm({
  name: '',
  description: '',
  colors: {},
  logo: '',
  categories: []
})
let canvas = null
const chatContainer = ref(null)
const currentOrder = ref(0)
const timeout = ref(200)
const userMessage = ref('')
const userActions = ref({
  hasImage: false,
  hasColor: false,
  primaryColor: '#ffffff',
  secondaryColor: '#000000',
  isBase64: false
})
const chats = ref([])
const loading = ref(false)
const isInputAllowed = computed(() => {
  return currentOrder.value > 3
})
const questions = [
  {
    order: 1,
    text: 'Welcome to the brand setup! To optimize content for your brand, we need some?'
  },
  { order: 2, text: "Firstly, what's the exact name of your brand?" },
  {
    order: 3,
    text: 'Great! Now, can you provide a detailed description of your brand? Think about the main product or service you offer, who your primary customers are, and what sets you apart from others.'
  },
  {
    order: 4,
    text: "A visual identity starts with a logo. If you have a logo, feel free to share it, or we'll begin with a temporary placeholder logo."
  },
  {
    order: 5,
    text: "Are primary and secondary colors already on your mind for your brand? If not, don't worry. We'll generate it for you."
  },
  {
    order: 6,
    text: 'What type of brand do you have?'
  },
  {
    order: 7,
    text: 'Please wait.....'
  }
]
const brandQuotes = [
  'Let us help you create a brand that is authentic, memorable, and true to yourself.',
  "We're here to help you transform your vision into a reality.",
  'Your personal brand is your most valuable asset.',
  'Your personal brand is the foundation of your business. Build it wisely.'
]
const activeBrandQuote = ref("We're here to help you transform your vision into a reality.")
const currentBrandQuoteIndex = ref(0)
const chatContainerScroll = () => {
  chatContainer.value.scrollTop = chatContainer.value.scrollHeight
}

const toggleListening = () => {
  if (!recognition) {
    toast.warning('Speech recognition is not supported in your browser')
    return
  }
  isListening.value = !isListening.value
  if (isListening.value) {
    recognition.start()
  } else {
    recognition.stop()
  }
}

const findOrder = (order) => {
  return questions.find((q) => q.order === order)
}

function addMessage(message, isBot = true, isError = false) {
  loading.value = true
  chats.value.push({
    order: null,
    message: '',
    isBot: isBot,
    loading: true,
    isError: isError
  })

  setTimeout(async () => {
    const index = chats.value.length - 1
    chats.value[index].loading = false
    chats.value[index].message = message
    chats.value[index].order = currentOrder.value

    loading.value = false
    chatContainerScroll()
  }, timeout.value)
}

function askNextQuestion(order) {
  const nextQuestion = findOrder(order)
  setTimeout(() => addMessage(nextQuestion.text, true), 500)
  currentOrder.value = order
}

onMounted(() => {
  addMessage(findOrder(1).text, true)
  setTimeout(() => askNextQuestion(2), timeout.value)

  if (recognition) {
    recognition.onresult = (event) => {
      const transcript = Array.from(event.results)
        .map((result) => result[0])
        .map((result) => result.transcript)
        .join('')
      voicedDescription.value = transcript
    }
    recognition.onspeechend = () => {
      userMessage.value += voicedDescription.value
    }
  }
  canvas = new fabric.StaticCanvas()
})

const addUserMessage = (message, isFile = false) => {
  userMessage.value = ''

  const validationParams = {
    2: [
      'name',
      1,
      10,
      "Sorry, Make it a minimum of 1 and a maximum of 10 words. What's the exact name of your brand?"
    ],
    3: [
      'description',
      20,
      100,
      'Sorry, Make it a minimum of 20 and a maximum of 100 words. What does your company do? Who are your customers? What are your products or services?'
    ]
  }

  chats.value.push({
    order: null,
    message: message,
    isBot: false,
    loading: false,
    isError: false,
    isFile: isFile
  })

  chatContainerScroll()

  if (currentOrder.value === 2 || currentOrder.value === 3) {
    const [fieldName, minLength, maxLength, errorMessage] = validationParams[currentOrder.value]

    if (
      countWordsAndChars(message).words > maxLength ||
      countWordsAndChars(message).words < minLength
    ) {
      addMessage(errorMessage, true, true)
      return
    }
    form[fieldName] = message
  }

  askNextQuestion(currentOrder.value + 1)
}

const handleUserLogo = (e, placeholder = false) => {
  if (placeholder) {
    form.logo = '/assets/images/brand.png'
  } else {
    form.logo = e.target.files[0]
  }
  addUserMessage(form.logo, true)
}

const handleUserColor = () => {
  if (userActions.value.hasColor) {
    const colors = {
      primary: userActions.value.primaryColor,
      secondary: userActions.value.secondaryColor
    }
    form.colors = colors

    addUserMessage(`${userActions.value.primaryColor} ${userActions.value.secondaryColor}`)
  } else {
    addUserMessage('AI Will generate colors for you.')
  }
}

const handleUserCategories = (cat) => {
  if (form.categories.includes(cat)) {
    const index = form.categories.findIndex((category) => category === cat)
    form.categories.splice(index, 1)
  } else {
    form.categories.push(cat)
  }
}
const changeName = async (data) => {
  return new Promise((resolve) => {
    let dataObjects = JSON.parse(data).objects

    for (let obj of dataObjects) {
      if (obj.id == 'slogan') {
        obj.text = form.name ?? 'Name'
      }
      if (obj.type === 'i-text' && obj.left < 51) {
        let left

        if (obj.left < 50) {
          left = Math.abs(obj.left + 50)
        }
        if (obj.left < 0) {
          left = Math.abs(obj.left + 100)
        }
        obj.left += left
      }
    }
    let parsedData = JSON.parse(data)
    parsedData.objects = dataObjects
    let updatedData = JSON.stringify(parsedData)

    canvas.loadFromJSON(updatedData, function () {
      canvas.renderAll()
      form.logo = canvas.toDataURL({
        width: 500,
        height: 500
      })
      resolve()
    })
  })
}
const submit = async () => {
  modal.open('brand')
  let brandLogo = null

  if (!(form.logo instanceof File)) {
    try {
      const res = await axios.get(
        route('api-brand-logo', {
          categories: form.categories
        })
      )
      brandLogo = res.data.logo
      if (brandLogo) {
        await changeName(brandLogo.canvas)
        userActions.value.isBase64 = true
      }
    } catch (e) {
      brandLogo = null
    }
  }

  setInterval(() => {
    activeBrandQuote.value = brandQuotes[currentBrandQuoteIndex.value]
    currentBrandQuoteIndex.value++

    if (currentBrandQuoteIndex.value === brandQuotes.length) currentBrandQuoteIndex.value = 0
  }, 4000)

  router.post(
    route('user.brand.store'),
    {
      form: form,
      actions: userActions.value
    },
    {
      onSuccess: () => modal.close(),
      onError: (errors) => {
        const error = errors?.e || 'Something went wrong..'
        modal.close()
        setTimeout(() => addMessage(error, true, true), 500)
      }
    }
  )
}
const saveCategories = () => {
  let categories = ''
  form.categories.forEach((cat) => {
    const category = props.categories.find((c) => c.id === cat)
    if (category) {
      categories += category.title + ', '
    }
  })
  addUserMessage(categories)
  submit()
}

const setImageURL = (value) => {
  return URL.createObjectURL(value)
}

const orderState = (chat, order) => {
  return chat.order && chat.order === order && chat.order === currentOrder.value
}
</script>

<template>
  <Modal
    :state="modal.states['brand']"
    :backdrop-close="false"
    :close-btn="false"
    :bg-blur="true"
    bg-color="bg-transparent"
  >
    <div class="flex justify-center">
      <div class="half-circle-spinner">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
      </div>
    </div>
    <p class="mt-6 text-center">{{ activeBrandQuote }}</p>
  </Modal>
  <main class="container flex-grow p-4 sm:p-6">
    <PageHeader title="Brand Create" :buttons="buttons" />
    <div class="m-auto max-w-6xl rounded-2xl border pb-3 shadow-lg dark:border-gray-800">
      <div
        class="card mb-5 flex items-center justify-between rounded-t-2xl p-4 dark:border-gray-700"
      >
        <div class="flex items-center">
          <div
            class="mr-4 flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-400 bg-opacity-10 text-emerald-500"
          >
            <i class="bx bx-flag text-2xl"></i>
          </div>
          <h5 class="mr-1">Create New Brand</h5>
        </div>
      </div>

      <div
        class="styled-scrollbar h-[calc(100vh-23rem)] overflow-y-auto p-5 pt-0"
        ref="chatContainer"
      >
        <ul class="mb-20 space-y-5">
          <!-- Friend Chat -->
          <li class="group" :class="chat.isBot ? '' : 'user'" v-for="(chat, i) in chats" :key="i">
            <div class="flex gap-x-3 group-[.user]:flex-row-reverse">
              <div class="avatar avatar-circle avatar-sm shrink-0">
                <img
                  class="avatar-img"
                  :src="`https://ui-avatars.com/api/?name=${'user'}`"
                  alt="profile-img"
                />
              </div>
              <div
                class="flex max-w-2xl flex-col items-start gap-y-2 rounded-primary rounded-tl-none p-3 group-[.user]:items-end group-[.user]:rounded-tl-primary group-[.user]:rounded-tr-none group-[.user]:bg-primary-500"
                :class="[
                  chat.loading ? '' : 'bg-slate-100 dark:bg-slate-700',
                  chat.isError && !chat.loading ? 'border border-red-500' : ''
                ]"
              >
                <template v-if="chat.isFile && !chat.isBot">
                  <img
                    class="w-40"
                    :src="
                      userActions['hasImage']
                        ? setImageURL(chat.message)
                        : '/assets/images/brand.png'
                    "
                    alt="logo"
                  />
                </template>
                <template v-else>
                  <div class="hollow-dots-spinner" v-if="chat.loading">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                  </div>
                  <p
                    v-else
                    class="group-[.user]:text-slate-100"
                    :class="chat.isError ? 'text-red-500' : 'text-slate-600 dark:text-slate-300'"
                  >
                    {{ chat.message }}
                    <template v-if="orderState(chat, 7) && chat.isError">
                      <Link
                        :href="route('user.brand.create')"
                        class="btn btn-outline-danger btn-xs mt-3 block max-w-min"
                      >
                        Reset
                      </Link>
                    </template>
                  </p>
                </template>
                <!-- logo -->
                <template v-if="orderState(chat, 4)">
                  <div
                    class="w-full space-x-2 border-t border-gray-600 pt-3"
                    v-if="!userActions.hasImage"
                  >
                    <button class="btn btn-primary" @click="userActions.hasImage = true">
                      Yes, I have
                    </button>
                    <button
                      class="btn btn-outline-primary"
                      @click="
                        () => {
                          userActions.hasImage = false
                          handleUserLogo(e, true)
                        }
                      "
                    >
                      {{ trans('Please generate for me') }}
                    </button>
                  </div>
                  <div v-if="userActions.hasImage" class="w-full border-t border-gray-600 pt-3">
                    <input
                      class="input"
                      accept="image/*"
                      @input="handleUserLogo"
                      type="file"
                      name="file"
                    />

                    <button
                      class="btn btn-outline-primary mt-3"
                      @click="
                        () => {
                          userActions.hasImage = false
                          handleUserLogo(e, true)
                        }
                      "
                    >
                      No, I'll use a placeholder for now
                    </button>
                  </div>
                </template>
                <!-- color -->
                <template v-if="orderState(chat, 5)">
                  <div
                    class="w-full space-x-2 border-t border-gray-600 pt-3"
                    v-if="!userActions.hasColor"
                  >
                    <button class="btn btn-primary" @click="userActions.hasColor = true">
                      Yes, I have
                    </button>
                    <button
                      class="btn btn-outline-primary"
                      @click="
                        () => {
                          userActions.hasColor = false
                          handleUserColor()
                        }
                      "
                    >
                      Not now, let AI generate it for me
                    </button>
                  </div>
                  <div v-if="userActions.hasColor" class="w-full border-t border-gray-600 pt-3">
                    <div class="grid grid-cols-2 gap-x-4">
                      <div>
                        <label class="label mb-1">Primary Color</label>
                        <div class="flex items-center gap-x-2">
                          <div class="h-9 w-10 overflow-hidden rounded-md">
                            <input
                              v-model="userActions.primaryColor"
                              class="h-24 w-24 -translate-x-5 -translate-y-4 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
                              type="color"
                              name="file"
                            />
                          </div>
                          <input type="text" v-model="userActions.primaryColor" class="input" />
                        </div>
                      </div>
                      <div>
                        <label class="label mb-1">Secondary Color</label>
                        <div class="flex items-center gap-x-2">
                          <div class="h-9 w-10 overflow-hidden rounded-md">
                            <input
                              v-model="userActions.secondaryColor"
                              class="h-24 w-24 -translate-x-5 -translate-y-4 rounded-xl bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:ring-0 focus:ring-primary-500 dark:text-slate-200"
                              type="color"
                              name="file"
                            />
                          </div>
                          <input type="text" v-model="userActions.secondaryColor" class="input" />
                        </div>
                      </div>
                    </div>

                    <button class="btn btn-primary mt-3" @click="handleUserColor">Save</button>
                    <button class="btn btn-outline-dark ml-3" @click="userActions.hasColor = false">
                      Cancel
                    </button>
                  </div>
                </template>
                <!-- categories -->
                <template v-if="orderState(chat, 6)">
                  <div class="flex flex-wrap items-center gap-2">
                    <button
                      v-for="cat in categories"
                      :key="cat.id"
                      class="btn btn-xs"
                      @click="handleUserCategories(cat.id)"
                      :class="
                        form.categories.includes(cat.id) ? 'btn-primary' : 'btn-outline-primary'
                      "
                    >
                      {{ cat.title }}
                    </button>
                  </div>
                  <button
                    class="btn btn-primary mt-3"
                    :disabled="form.categories < 1"
                    @click="saveCategories"
                  >
                    Save
                  </button>
                </template>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="flex items-center gap-2 p-4 pb-2">
        <div class="relative flex w-full items-center">
          <input
            v-model="userMessage"
            @keyup.enter="addUserMessage(userMessage)"
            :disabled="loading || isInputAllowed"
            type="text"
            class="w-full rounded-full border border-gray-200 bg-transparent px-6 py-4 text-sm text-slate-700 shadow-md outline-none placeholder:text-slate-400 focus:ring-1 focus:ring-primary-400 disabled:cursor-not-allowed dark:border-gray-700 dark:text-slate-200"
            placeholder="Write Something"
          />
          <button
            :disabled="loading || isInputAllowed"
            class="btn btn-primary absolute right-1 h-12 w-12 rounded-full"
            @click="toggleListening"
          >
            <div class="looping-rhombuses-spinner" v-if="isListening">
              <div class="rhombus bg-white"></div>
              <div class="rhombus bg-white"></div>
              <div class="rhombus bg-white"></div>
            </div>
            <i class="bx bx-microphone text-lg" v-else></i>
          </button>
        </div>
        <button
          :disabled="loading || isInputAllowed || userMessage.length < 2"
          @click="addUserMessage(userMessage)"
          class="btn btn-dark h-12 w-12 rounded-full"
        >
          <i class="bx bx-send text-lg"></i>
        </button>
      </div>
      <p class="pb-2 pl-6 text-xs">
        Words:
        {{ countWordsAndChars(userMessage ?? '').words }}
      </p>
    </div>
  </main>
</template>
