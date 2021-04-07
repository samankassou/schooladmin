<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Academic Years
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div v-for="(academicYear, index) in academicYears" :key="index">
                        <div class="w-1/4 shad">
                            <p>{{ academicYear.name }}</p>
                            <p>début: {{ academicYear.start_date }}</p>
                            <p>fin: {{ academicYear.end_date }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import AcademicYear from '@/Components/AcademicYear'

    export default {
        props: ["academicYears"],
        components: {
            AppLayout,
            AcademicYear
        },
    }
</script>
