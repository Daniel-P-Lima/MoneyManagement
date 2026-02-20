<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    transactionMonth: Number,
    transactionYear: Number,
    route: String,
});

const months = [
    'Janeiro','Fevereiro','Março','Abril','Maio','Junho',
    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro',
];

const prevMonth = computed(() => props.transactionMonth === 1 ? 12 : props.transactionMonth - 1);
const prevYear  = computed(() => props.transactionMonth === 1 ? props.transactionYear - 1 : props.transactionYear);
const nextMonth = computed(() => props.transactionMonth === 12 ? 1 : props.transactionMonth + 1);
const nextYear  = computed(() => props.transactionMonth === 12 ? props.transactionYear + 1 : props.transactionYear);

function buildUrl(m, y) {
    return `${props.route}?month=${m}&year=${y}`;
}
</script>

<template>
    <div class="flex items-center justify-between bg-white rounded-xl px-4 py-3 shadow-sm">
        <Link :href="buildUrl(prevMonth, prevYear)"
              class="p-2 rounded-full hover:bg-gray-100 active:bg-gray-200">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </Link>

        <span class="text-base font-semibold text-gray-800">
            {{ months[transactionMonth - 1] }} {{ transactionYear }}
        </span>

        <Link :href="buildUrl(nextMonth, nextYear)"
              class="p-2 rounded-full hover:bg-gray-100 active:bg-gray-200">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </Link>
    </div>
</template>
