
<script setup>
import { ref } from 'vue';
import Modal from '../Modal.vue';
const props = defineProps(['id']);

// Add Column Modal
const shownAddColumnModal = ref(false);
// End Add Column Modal

// Columns
const newColumnName = ref("");
let columns = ref([
  'Task',
  'Status',
  'Priority',
  'Notes',
]);

const addNewColumn = () => {
  if (newColumnName.value.trim() != "") {
    columns.value.push(newColumnName.value);
    newColumnName.value = "";
    shownAddColumnModal.value = false;
  }
}
// End Columns
</script>

<template>
  <div class="group-header mb-2">
    <div>
      <h5 class="mb-0">Group Title</h5>
    </div>
    <div>
      <!-- Add Column Btn -->
      <button @click="() => shownAddColumnModal = true" type="button" class="btn btn-primary btn-sm">
        <span class="bx bx-plus text-sm"></span> Add Column
      </button>
      <!-- End Add Column Btn -->
    </div>
  </div>

  <!-- Add Column Modal -->
  <Modal :show="shownAddColumnModal" :id="props.id" @closed="() => shownAddColumnModal = false">
    <template v-slot:title>Add New Column</template>
    <template v-slot:action-btns>
      <button @click="addNewColumn" type="button" class="btn btn-primary">Save changes</button>
    </template>

    <div class="row">
      <div class="col mb-3">
        <label for="column-name-input" class="form-label">Name</label>
        <input type="text" v-model="newColumnName" id="column-name-input" class="form-control" placeholder="Enter Name" />
      </div>
    </div>
    <div class="row">
      <div class="col mb-3">
        <label for="nameBasic" class="form-label">Type</label>
        <div class="form-check">
          <input name="default-radio-1" class="form-check-input" type="radio" value="" id="type_1" checked />
          <label class="form-check-label" for="type_1"> Text </label>
        </div>
        <div class="form-check">
          <input name="default-radio-1" class="form-check-input" type="radio" value="" id="type_2" />
          <label class="form-check-label" for="type_2"> Select/Dropdown Field </label>
        </div>
        <div class="form-check">
          <input name="default-radio-1" class="form-check-input" type="radio" value="" id="type_3" />
          <label class="form-check-label" for="type_3"> Datepicker </label>
        </div>
      </div>
    </div>
  </Modal>
  <!-- End: Add Column Modal -->

  <div class="board-wrapper mb-4">
    <div class="board-row board-header">
      <div class="board-column" :class="index == 0 ? 'sticky' : ''" v-for="(column, index) in columns" :key="index">
        {{ column }}
      </div>
    </div>
    <div class="board-row">
      <div class="board-column" :class="index == 0 ? 'sticky' : ''" v-for="(column, index) in columns" :key="index">
        {{ column }}
      </div>
    </div>
    <div class="board-row">
      <div class="board-column" :class="index == 0 ? 'sticky' : ''" v-for="(column, index) in columns" :key="index">
        {{ column }}
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Group Header */
.group-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
/* End Group Header */

.board-wrapper {
  overflow-x: scroll;
  background-color: #fff;
  border-radius: 10px;
  border: 1px solid #e8e8f1;
}

.board-header,
.board-row {
  display: flex;
  width: fit-content;
  min-width: 100%;
}

.board-column {
  position: relative;
  min-width: 300px;
  padding: 5px 20px;
}

.board-column+.board-column {
  border-left: 1px solid #e8e8f1;
}

.board-row+.board-row {
  border-top: 1px solid #e8e8f1;
}

.board-header {
  border-bottom: 2px solid #e8e8f1;
  font-weight: 600;
}

.sticky {
  position: absolute;
  background-color: #fff;
  border-right: 1px solid #e8e8f1;
  z-index: 10;
}

.board-row .sticky:first-child {
  border-top-left-radius: 10px;
}

.board-row .sticky:last-child {
  border-bottom-left-radius: 10px;
}

.board-column.sticky+.board-column {
  margin-left: 300px;
}

::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}

/* Track */
::-webkit-scrollbar-track {
  background-color: transparent;
}

::-webkit-scrollbar-track:hover {
  background-color: #e8e8f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #d7d7e6;
  border-radius: 5px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #bbbcd5;
}
</style>