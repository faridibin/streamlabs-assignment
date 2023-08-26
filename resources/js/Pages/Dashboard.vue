<script setup>
    import { ref, onBeforeMount } from 'vue';
    import { CheckCircleIcon } from '@heroicons/vue/24/solid'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { startCase, join } from 'lodash';

    const loading = ref(false);

    const statistics = ref({
        followers: 0,
        total_revenue: '0.00 USD',
        top_items: ['N/A']
    });

    const events = ref([]);
    const page = ref(null);

    const activity = [
        { id: 1, type: 'created', person: { name: 'Chelsea Hagon' }, date: '7d ago', dateTime: '2023-01-23T10:32' },
        { id: 2, type: 'edited', person: { name: 'Chelsea Hagon' }, date: '6d ago', dateTime: '2023-01-23T11:03' },
        { id: 3, type: 'sent', person: { name: 'Chelsea Hagon' }, date: '6d ago', dateTime: '2023-01-23T11:24' },
        {
            id: 4,
            type: 'commented',
            person: {
            name: 'Chelsea Hagon',
            imageUrl:
                'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            },
            comment: 'Called client, they reassured me the invoice would be paid by the 25th.',
            date: '3d ago',
            dateTime: '2023-01-23T15:56',
        },
        { id: 5, type: 'viewed', person: { name: 'Alex Curren' }, date: '2d ago', dateTime: '2023-01-24T09:12' },
        { id: 6, type: 'paid', person: { name: 'Alex Curren' }, date: '1d ago', dateTime: '2023-01-24T09:20' },
    ]

    const getStatistics = async () => {
        loading.value = true;

        const { data } = await axios.get('/api/statistics');

        statistics.value = data;
        loading.value = false;
    };

    const getEvents = async (url = '/api/events') => {
        const { data: {data, next_page_url} } = await axios.get(url);

        events.value = {
            ...events.value,
            ...data,
        };

        page.value = next_page_url;
    };


    onBeforeMount(() => Promise.all([getStatistics(), getEvents()]));
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hello {{ $page.props.auth.user.name }}!</h2>
        </template>

        <div class="py-12">
            <div v-if="!loading" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto px-4 sm:px-0 mb-12">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Last 30 days</h3>
                    <dl class="mt-5 grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow md:grid-cols-3 md:divide-x md:divide-y-0">
                        <div v-for="(value, key) in statistics" :key="key" class="px-4 py-5 sm:p-6">
                            <dt class="text-base font-normal text-gray-900">{{ startCase(key) }}</dt>
                            <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                                <div class="flex items-baseline text-2xl font-semibold text-indigo-600">
                                    {{ value instanceof Array ? join(value, ', ') : value }}
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="max-w-4xl mx-auto px-4 sm:px-0">
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="px-4 py-5 sm:px-6">
                            Recent Activity
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <ul role="list" class="space-y-4 max-h-[400px] scrolling-component" ref="scrollComponent">
                                <li v-for="(event, index) in events" :key="event.id" class="relative flex gap-x-4">
                                    <div :class="[index === events.length - 1 ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center']">
                                    <div class="w-px bg-gray-200" />
                                    </div>
                                   <!--  <template v-if="event.type === 'commented'">
                                        <img :src="activityItem.person.imageUrl" alt="" class="relative mt-3 h-6 w-6 flex-none rounded-full bg-gray-50" />
                                        <div class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200">
                                            <div class="flex justify-between gap-x-4">
                                                <div class="py-0.5 text-xs leading-5 text-gray-500">
                                                    <span class="font-medium text-gray-900">{{ activityItem.person.name }}</span> commented
                                                </div>
                                                <time :datetime="activityItem.dateTime" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ activityItem.date }}</time>
                                            </div>
                                            <p class="text-sm leading-6 text-gray-500">{{ activityItem.comment }}</p>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                        <CheckCircleIcon v-if="activityItem.type === 'paid'" class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                                        <div v-else class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300" />
                                        </div>
                                        <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                            <span class="font-medium text-gray-900">{{ activityItem.person.name }}</span> {{ activityItem.type }} the invoice.
                                        </p>
                                        <time :datetime="activityItem.dateTime" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ activityItem.date }}</time>
                                    </template> -->
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
