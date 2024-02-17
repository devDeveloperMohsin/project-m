<script setup>
import { onMounted, onUnmounted, watch } from 'vue';

// Props
const props = defineProps({
	id: {
		type: String,
		required: true,
	},
	show: {
		type: Boolean,
		default: false,
	},
	closeOnEscape: {
		type: Boolean,
		default: true,
	},
});
// End Props

let modal;
const emit = defineEmits(['closed']);

// Watchers
watch(
	() => props.show,
	() => {
		if (props.show) {
			showModal();
		} else {
			hideModal();
		}
	}
);
// End Watchers

// Methods
const showModal = () => {
	modal.show();
};

const hideModal = () => {
	modal.hide();
};
// End Methods

// Lifecycle hooks
onMounted(() => {
	let modalDom = document.getElementById('modal-' + props.id);
	modal = new bootstrap.Modal(modalDom, {
		keyboard: props.closeOnEscape,
	});

	modalDom.addEventListener('hide.bs.modal', function (event) {
		emit('closed');
	})
});

onUnmounted(() => {
	if (modal) {
		modal.dispose();
	}
})
// End Lifecycle hooks

</script>

<template>
	<div class="modal fade" :id="'modal-' + props.id" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel1">
						<slot name="title"></slot>
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<slot></slot>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
						Close
					</button>

					<slot name="action-btns"></slot>
				</div>
			</div>
		</div>
	</div>
</template>
