<template>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <label for="monthSelect">Filter By</label>
                <select class="form-control-sm" id="monthSelect" v-model="filterby">
                    <option value="encounter_date">Encounter Date</option>
                    <option value="created_at">Submission Date</option>
                </select>
            </div>
            <div class="col-3">
                <label for="monthSelect">Select Month</label>
                <select class="form-control-sm" id="monthSelect" v-model="selectedMonth">
                    <option v-for="(month, index) in months" :key="index" :value="month">{{ month }}
                    </option>
                </select>
            </div>
            <div class="col-3">
                <label for="yearSelect">Select Year</label>
                <select class="form-control-sm" id="yearSelect" v-model="selectedYear">
                    <option v-for="year in years" :key="year" :value="year">{{ year }}
                    </option>
                </select>
            </div>

            <div class="col-3">
                <button class="btn btn-primary m-0" @click="applyFilter">Fetch Orders</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedMonth: '',
            selectedYear: '',
            filterby: '',
            months: [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ],
            years: []
        };
    },
    mounted() {
        this.initializeYears();

        this.filterby = 'encounter_date';

        const currentDate = new Date();
        this.selectedYear = currentDate.getFullYear();
        this.selectedMonth = this.months[currentDate.getMonth()];


        this.applyFilter();

    },
    methods: {
        initializeYears() {
            const currentYear = new Date().getFullYear();
            for (let i = currentYear; i >= currentYear - 5; i--) {
                this.years.push(i);
            }
        },
        applyFilter() {
            this.$emit('filter', { filter_by: this.filterby, month: this.selectedMonth, year: this.selectedYear });
        }
    }
};
</script>
