<template>
  <main class="container p-4 sm:p-6">
    <PageHeader
      :title="trans('Create Role')"
      
      :buttons="buttons"
    />
    <div class="space-y-6">
      <div class="card">
        <div class="card-body">
          <div class="mb-3">
            <label>{{ trans("Role Name") }}</label>
            <input
              type="text"
              class="input"
              required=""
              name="name"
              placeholder="sub admin"
              v-model="form.name"
            />
          </div>
          <ValidationErrors />
          <div>
            <label for="customCheck12" class="toggle toggle-sm">
              <input
                :checked="isAllSelected"
                @input="selectAll"
                class="toggle-input peer sr-only"
                id="customCheck12"
                type="checkbox"
              />
              <div class="toggle-body"></div>
              <span class="label label-md">{{
                trans("Check All Permissions")
              }}</span>
            </label>
          </div>
          <hr />
          <div
            class="mt-3"
            v-for="(group, key) in permissions_groups"
            :key="group.key"
          >
            <div class="grid grid-cols-12">
              <div class="col-span-3">
                <div class="flex items-center gap-2">
                  <input
                    @change="selectGroup(group.group_name)"
                    :checked="selectedGroup.includes(group.group_name)"
                    type="checkbox"
                    class="checkbox"
                    :id="key + 'Management'"
                    :value="group.group_name"
                    :data-class="`role-${key}-management-checkbox`"
                  />
                  <label class="label" :for="key + 'Management'">
                    {{ group.group_name }} name
                  </label>
                </div>
              </div>
              <div :class="`col-span-9 role-${key}-management-checkbox`">
                <div
                  class="flex items-center gap-2"
                  v-for="permission in group.permissions"
                  :key="permission.id"
                >
                  <input
                    @change="selectPermission(permission.name)"
                    :checked="form.permissions.includes(permission.name)"
                    type="checkbox"
                    class="checkbox"
                    name="permissions[]"
                    :id="`checkPermission${permission.id}`"
                    :value="permission.name"
                  />
                  <label
                    class="label"
                    :for="`checkPermission${permission.id}`"
                    >{{ permission.name }}</label
                  >
                </div>

                <br />
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button
            @click.prevent="submitRole"
            type="submit"
            class="btn btn-primary"
          >
            <i class="fa fa-save"></i> {{ trans("Save") }}
          </button>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import PageHeader from "@/Layouts/Admin/PageHeader.vue";
import ValidationErrors from "@/Components/Admin/ValidationErrors.vue";
import { useForm } from "@inertiajs/vue3";
const props = defineProps([ "buttons", "permissions_groups"]);

import { ref, computed } from "vue";
defineOptions({ layout: AdminLayout });
const form = useForm({
  permissions: [],
  name: null,
});
const selectedGroup = ref([]);
const isAllSelected = computed(
  () => props.permissions_groups.length === selectedGroup.value.length
);
const selectAll = () => {
  selectedGroup.value = [];
  if (form.permissions.length < 1) {
    props.permissions_groups.forEach((group) => {
      selectedGroup.value.push(group.group_name);
      group.permissions.forEach((permission) => {
        form.permissions.push(permission.name);
      });
    });
    return;
  }
  form.permissions = [];
};
const selectGroup = (name) => {
  const index = selectedGroup.value.indexOf(name);

  if (index !== -1) {
    selectedGroup.value.splice(index, 1);
  } else {
    selectedGroup.value.push(name);
  }

  const selectedPermissions = props.permissions_groups
    .filter((group) => selectedGroup.value.includes(group.group_name))
    .flatMap((group) => group.permissions.map((permission) => permission.name));

  form.permissions = selectedGroup.value.length >= 1 ? selectedPermissions : [];
};
const selectPermission = (name) => {
  const index = form.permissions.indexOf(name);
  if (index !== -1) {
    form.permissions.splice(index, 1);
  } else {
    form.permissions.push(name);
  }
};
const submitRole = () => {
  form.post(route("admin.role.store"), {
    onSuccess: () => {
      form.reset();
      createToast(
        {
          title: "Created",
          description: "Role Created successfully",
        },
        {
          transition: "slide",
          position: "top-right",
        }
      );
    },
  });
};
</script>
