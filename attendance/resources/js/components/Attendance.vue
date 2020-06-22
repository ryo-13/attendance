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
        <ajax
          :displayDayData="displayDayData"
          :index="index"
          :attendancesDbDates="attendancesDbDates"
          :parentProcessing="processing"
          @callGetAttendance="getAttendnaceData"
          @parentMethod="updateProcessing"
        ></ajax>
      </tbody>
    </table>
  </div>
</template>

<script>
import dayjs from "dayjs";
dayjs.locale("ja");
export default {
  created() {
    this.getAttendnaceData();
  },
  data() {
    return {
      displayDaysData: "",
      attendancesDbDates: "",
      processing: ""
    };
  },
  methods: {
    falseDisblead() {
      this.processing = false;
    },
    isProcessing() {
      this.processing = true;
      setTimeout(this.falseDisblead, 3000);
    },
    updateProcessing(processing) {
      this.processing = processing;
      this.isProcessing();
    },
    getAttendnaceData() {
      axios.get("/api/attendances").then(response => {
        this.displayDaysData = response.data;
        this.attendancesDbDates = response.data;
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
