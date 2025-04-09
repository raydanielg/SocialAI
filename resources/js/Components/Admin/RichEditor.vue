<script setup>
import FloatingDropdown from './FloatingDropdown.vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Table from '@tiptap/extension-table'
import TableCell from '@tiptap/extension-table-cell'
import TableHeader from '@tiptap/extension-table-header'
import TableRow from '@tiptap/extension-table-row'
import Image from '@tiptap/extension-image'
import Link from '@tiptap/extension-link'
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: String
})

const emit = defineEmits(['update:modelValue'])
const insertImageDropdown = ref(null)
const insertLinkDropdown = ref(null)
const insertImageUrl = ref(null)
const insertLinkUrl = ref(null)
const editor = useEditor({
  content: props.modelValue,
  onUpdate: ({ editor }) => {
    emit('update:modelValue', editor.getHTML())
  },
  extensions: [
    StarterKit,
    Underline,
    Table.configure({
      resizable: true
    }),
    TableRow,
    TableHeader,
    TableCell,
    Image.configure({
      allowBase64: true
    }),
    Link
  ],
  editorProps: {
    attributes: {
      class:
        'border dark:border-gray-600 dark:text-gray-400 p-3 min-h-[14rem] max-h-[30rem] overflow-y-auto outline-none prose max-w-none rounded-b'
    }
  }
})
watch(
  () => props.modelValue,
  (newValue) => {
    if (newValue) {
      setTimeout(() => editor.value.commands.setContent(newValue), 50)
    }
  }
)
function insertImage() {
  editor.value.chain().focus().setImage({ src: insertImageUrl.value }).run()
  insertImageUrl.value = null
  insertImageDropdown.value.toggleDropdown()
}
function insertLink() {
  editor.value.chain().focus().setLink({ href: insertLinkUrl.value, target: '_blank' }).run()
  insertLinkUrl.value = null
  insertLinkDropdown.value.toggleDropdown()
}
</script>

<template>
  <div>
    <section
      v-if="editor"
      class="buttons flex flex-wrap items-center gap-x-3 rounded-t border-l border-r border-t p-2 dark:border-gray-600"
    >
      <button
        type="button"
        class="tiptap_toolbar__button_one"
        @click="editor.chain().focus().undo().run()"
        :disabled="!editor.can().chain().focus().undo().run()"
      >
        <Icon class="text-lg" icon="mdi:undo" />
      </button>
      <button
        type="button"
        @click="editor.chain().focus().redo().run()"
        :disabled="!editor.can().chain().focus().redo().run()"
        class="tiptap_toolbar__button_one"
      >
        <Icon class="text-lg" icon="mdi:redo" />
      </button>
      |
      <button
        type="button"
        @click="editor.chain().focus().toggleBold().run()"
        :class="{ 'fn-active': editor.isActive('bold') }"
        class="tiptap_toolbar__button_one"
      >
        <Icon class="text-lg" icon="mdi:format-bold" />
      </button>
      <button
        type="button"
        @click="editor.chain().focus().toggleItalic().run()"
        :class="{ 'fn-active': editor.isActive('italic') }"
        class="tiptap_toolbar__button_one"
      >
        <Icon class="text-lg" icon="mdi:format-italic" />
      </button>
      <button
        type="button"
        @click="editor.chain().focus().toggleUnderline().run()"
        :class="{ 'fn-active': editor.isActive('underline') }"
        class="tiptap_toolbar__button_one"
      >
        <Icon class="text-lg" icon="mdi:format-underline" />
      </button>
      <FloatingDropdown
        btn-type="icon"
        icon-name="flowbite:paragraph-outline"
        icon-class="text-lg"
        btn-class="w-full space-x-2 tiptap_toolbar__button_one"
        active-class="fn-active"
      >
        <ul class="dropdown-list w-28 space-y-1 p-1 text-sm">
          <li class="dropdown-list-item">
            <button
              type="button"
              @click="editor.chain().focus().setParagraph().run()"
              :class="{
                'fn-active': editor.isActive('paragraph')
              }"
              class="tiptap_toolbar__button_one w-full space-x-2"
            >
              <Icon class="inline text-lg" icon="mdi:format-paragraph" />
              <span class="text-sm">Paragraph</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
              :class="{
                'fn-active': editor.isActive('heading', { level: 1 })
              }"
              class="tiptap_toolbar__button_one w-full space-x-2"
            >
              <Icon class="inline text-lg" icon="mdi:format-header-1" />
              <span class="text-sm">Heading 1</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
              :class="{
                'fn-active': editor.isActive('heading', { level: 2 })
              }"
              class="tiptap_toolbar__button_one w-full space-x-2"
            >
              <Icon class="inline text-lg" icon="mdi:format-header-2" />
              <span class="text-sm">Heading 2</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              class="tiptap_toolbar__button_one w-full space-x-2"
              @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
              :class="{ 'fn-active': editor.isActive('heading', { level: 3 }) }"
            >
              <Icon class="inline text-lg" icon="mdi:format-header-3" />
              <span class="text-sm">Heading 3</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              class="tiptap_toolbar__button_one w-full space-x-2"
              @click="editor.chain().focus().toggleHeading({ level: 4 }).run()"
              :class="{ 'fn-active': editor.isActive('heading', { level: 4 }) }"
            >
              <Icon class="inline text-lg" icon="mdi:format-header-4" />
              <span class="text-sm">Heading 4</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              class="tiptap_toolbar__button_one w-full space-x-2"
              @click="editor.chain().focus().toggleHeading({ level: 5 }).run()"
              :class="{ 'fn-active': editor.isActive('heading', { level: 5 }) }"
            >
              <Icon class="inline text-lg" icon="mdi:format-header-5" />
              <span class="text-sm">Heading 5</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              class="tiptap_toolbar__button_one w-full space-x-2"
              @click="editor.chain().focus().toggleHeading({ level: 6 }).run()"
              :class="{ 'fn-active': editor.isActive('heading', { level: 6 }) }"
            >
              <Icon class="inline text-lg" icon="mdi:format-header-6" />
              <span class="text-sm">Heading 6</span>
            </button>
          </li>
        </ul>
      </FloatingDropdown>

      <button
        type="button"
        @click="editor.chain().focus().toggleBulletList().run()"
        :class="{ 'fn-active': editor.isActive('bulletList') }"
        class="tiptap_toolbar__button_one"
      >
        <Icon class="text-lg" icon="mdi:format-list-bulleted" />
      </button>
      <button
        type="button"
        @click="editor.chain().focus().toggleOrderedList().run()"
        :class="{ 'fn-active': editor.isActive('orderedList') }"
        class="tiptap_toolbar__button_one"
      >
        <Icon class="text-lg" icon="mdi:format-list-numbered" />
      </button>
      <button
        type="button"
        @click="editor.chain().focus().toggleBlockquote().run()"
        :class="{ 'fn-active': editor.isActive('blockquote') }"
        class="tiptap_toolbar__button_one"
      >
        <Icon class="text-lg" icon="mdi:format-quote-close" />
      </button>
      <button
        type="button"
        @click="editor.chain().focus().toggleCode().run()"
        :class="{ 'fn-active': editor.isActive('code') }"
        class="tiptap_toolbar__button_one"
      >
        <Icon class="text-lg" icon="mdi:code-tags" />
      </button>
      <button
        type="button"
        @click="editor.chain().focus().setHorizontalRule().run()"
        class="tiptap_toolbar__button_one"
      >
        <Icon class="text-lg" icon="mdi:minus" />
      </button>

      <FloatingDropdown
        ref="insertLinkDropdown"
        btn-type="icon"
        icon-name="mdi:attachment-plus"
        icon-class="text-lg"
        btn-class="w-full space-x-2 tiptap_toolbar__button_one"
        active-class="fn-active"
      >
        <div class="p-3">
          <div class="flex flex-col gap-y-1">
            <label class="text-xs dark:text-gray-200">Link Url</label>
            <input
              v-model="insertLinkUrl"
              type="url"
              class="input"
              placeholder="https://example.com"
            />
          </div>
          <div class="flex justify-end gap-1 pt-2">
            <button
              type="button"
              class="btn btn-xs btn-outline-danger"
              @click="insertLinkDropdown.toggleDropdown()"
            >
              <Icon icon="mdi:close" /> Cancel
            </button>
            <button type="button" @click="insertLink" class="btn btn-xs btn-outline-primary">
              <Icon icon="mdi:check" /> Insert
            </button>
          </div>
        </div>
      </FloatingDropdown>
      <FloatingDropdown
        ref="insertImageDropdown"
        btn-type="icon"
        icon-name="mdi:image-plus"
        icon-class="text-lg"
        btn-class="w-full space-x-2 tiptap_toolbar__button_one"
        active-class="fn-active"
      >
        <div class="p-3">
          <div class="flex flex-col gap-y-1">
            <label class="text-xs dark:text-gray-200">Insert image via Url</label>
            <input
              v-model="insertImageUrl"
              type="text"
              class="input"
              placeholder="https://example.com/image.png"
            />
          </div>
          <div class="flex justify-end gap-1 pt-2">
            <button
              type="button"
              class="btn btn-xs btn-outline-danger"
              @click="insertImageDropdown.toggleDropdown()"
            >
              <Icon icon="mdi:close" /> Cancel
            </button>
            <button type="button" @click="insertImage" class="btn btn-xs btn-outline-primary">
              <Icon icon="mdi:check" /> Insert
            </button>
          </div>
        </div>
      </FloatingDropdown>

      <FloatingDropdown
        ref="tableDropdown"
        btn-type="icon"
        icon-name="mdi:table"
        icon-class="text-lg"
        btn-class="w-full space-x-2 tiptap_toolbar__button_one"
        active-class="fn-active"
      >
        <ul class="dropdown-list w-40 space-y-1 p-3 text-sm">
          <li class="dropdown-list-item">
            <button
              type="button"
              :class="{ 'fn-active': editor.isActive('table') }"
              class="tiptap_toolbar__button_one flex w-full gap-x-2"
              @click="
                editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()
              "
            >
              <Icon class="inline text-lg" icon="mdi:table-plus" />
              <span class="text-xs">Insert Table</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              @click="editor.chain().focus().addRowBefore().run()"
              :class="{ 'fn-active': editor.isActive('addRowBefore') }"
              class="tiptap_toolbar__button_one flex w-full gap-x-2"
              :disabled="!editor.can().addRowBefore()"
            >
              <Icon class="inline text-lg" icon="mdi:table-row-plus-before" />
              <span class="text-xs">Add Row Before</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              @click="editor.chain().focus().addRowAfter().run()"
              :class="{ 'fn-active': editor.isActive('addRowAfter') }"
              class="tiptap_toolbar__button_one flex w-full gap-x-2"
              :disabled="!editor.can().addRowAfter()"
            >
              <Icon class="inline text-lg" icon="mdi:table-row-plus-after" />
              <span class="text-xs">Add Row After</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              class="tiptap_toolbar__button_one flex w-full gap-x-2"
              @click="editor.chain().focus().deleteRow().run()"
              :disabled="!editor.can().deleteRow()"
            >
              <Icon class="inline text-lg" icon="mdi:table-row-remove" />
              <span class="text-xs">Delete Row</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              @click="editor.chain().focus().addColumnBefore().run()"
              :class="{ 'fn-active': editor.isActive('addColumnBefore') }"
              class="tiptap_toolbar__button_one flex w-full gap-x-2"
              :disabled="!editor.can().addColumnBefore()"
            >
              <Icon class="inline text-lg" icon="mdi:table-column-plus-before" />
              <span class="text-xs">Add Column Before</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              @click="editor.chain().focus().addColumnAfter().run()"
              :class="{ 'fn-active': editor.isActive('addColumnAfter') }"
              class="tiptap_toolbar__button_one flex w-full gap-x-2"
              :disabled="!editor.can().addColumnAfter()"
            >
              <Icon class="inline text-lg" icon="mdi:table-column-plus-after" />
              <span class="text-xs">Add Column After</span>
            </button>
          </li>
          <li class="dropdown-list-item">
            <button
              type="button"
              class="tiptap_toolbar__button_one flex w-full gap-x-2"
              @click="editor.chain().focus().deleteColumn().run()"
              :disabled="!editor.can().deleteColumn()"
            >
              <Icon class="inline text-lg" icon="mdi:table-column-remove" />
              <span class="text-xs">Delete Column </span>
            </button>
          </li>
        </ul>
      </FloatingDropdown>
      <button
        type="button"
        @click="
          () => {
            editor.chain().focus().clearContent().run()
            emit('update:modelValue', '')
          }
        "
        class="tiptap_toolbar__button_one"
        title="Clear Data"
      >
        <Icon class="text-lg" icon="bx:task-x" />
      </button>
    </section>
    <EditorContent class="text-gray-100" :editor="editor" />
  </div>
</template>
