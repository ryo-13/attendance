<template>
  <div>
    <h1>タイムカード</h1>
    <span>{{ $dayjs().format('YYYY[年]MM[月]DD[日]')}}({{ currentDayOfWeek }})</span>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>日付</th>
          <th>出社</th>
          <th>退社</th>
        </tr>
      </thead>
      <tbody v-for="(displayDayData, index) in displayDaysData" :key="index">
        <timecard-row
          :displayDayData="displayDayData"
          :index="index"
          :attendancesDbDates="attendancesDbDates"
          @callGetAttendance="getAttendnaceData"
        ></timecard-row>
      </tbody>
    </table>
  </div>
</template>

<script>
import TimecardRow from "./TimecardRow.vue";
import dayjs from "dayjs";
dayjs.locale("ja");
export default {
  components: {
    "timecard-row": TimecardRow
  },
  created() {
    this.getAttendnaceData();
  },
  data() {
    return {
      displayDaysData: "",
      attendancesDbDates: ""
    };
  },
  methods: {
    getAttendnaceData() {
      let loader = Vue.$loading.show();
      axios
        .get("/api/attendances")
        .then(response => {
          this.displayDaysData = response.data;
          this.attendancesDbDates = response.data;
        })
        .finally(() => {
          loader.hide();
        });
    }
  },
  computed: {
    currentDayjs() {
      return dayjs();
    },
    currentDayOfWeek() {
      return dayjs().format("ddd");
    }
  }
};
</script>
