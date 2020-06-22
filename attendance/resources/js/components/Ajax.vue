<template>
  <tr>
    <td>{{ currentMonth}}/{{ index+1}}</td>
    <td>
      <input
        type="time"
        :disabled="isset(parentProcessing) ? parentProcessing : false"
        @change="storeOrUpdateArrival"
        v-model="displayDayData.arrival"
      />
      <button
        type="button"
        :disabled="isset(parentProcessing) ? parentProcessing : false"
        @click="resetArrival"
        class="btn btn-danger ml-3"
      >リセット</button>
    </td>
    <td>
      <input
        type="time"
        :disabled="isset(parentProcessing) ? parentProcessing : false"
        @change="storeOrUpdateLeave"
        v-model="displayDayData.leave"
      />
      <button
        type="button"
        :disabled="isset(parentProcessing) ? parentProcessing : false"
        @click="resetLeave"
        class="btn btn-danger ml-3"
      >リセット</button>
    </td>
  </tr>
</template>

<script>
import dayjs from "dayjs";
dayjs.locale("ja");
export default {
  props: ["displayDayData", "index", "attendancesDbDates", "parentProcessing"],
  data() {
    return {
      attendancesDates: this.attendancesDbDates,
    };
  },
  methods: {
    isset(data) {
      if (data === "" || data === null || data === undefined) {
        return false;
      } else {
        return true;
      }
    },
    storeDaysData() {
      axios
        .post("/api/attendances", {
          displayDaysData: this.attendancesDates
        })
        .then(response => {
          console.log("success");
          this.$emit("callGetAttendance");
          this.$emit("parentMethod", this.processing);
        })
        .catch(err => {
          console.log("error");
        });
    },
    updateArrival() {
      axios
        .put("/api/attendances/update_arrival/" + this.displayDayData.id, {
          attendanceTime: this.displayDayData
        })
        .then(response => {
          console.log("success");
        })
        .catch(err => {
          console.log("error");
        });
    },
    updateLeave() {
      axios
        .put("/api/attendances/update_leave/" + this.displayDayData.id, {
          attendanceTime: this.displayDayData
        })
        .then(response => {
          console.log("success");
        })
        .catch(err => {
          console.log("error");
        });
    },
    resetArrival() {
      axios
        .put("/api/attendances/reset_arrival/" + this.displayDayData.id)
        .then(response => {
          this.displayDayData.arrival = response.data.arrival;
          console.log("success");
        })
        .catch(err => {
          console.log("error");
        });
    },
    resetLeave() {
      axios
        .put("/api/attendances/reset_leave/" + this.displayDayData.id)
        .then(response => {
          this.displayDayData.leave = response.data.leave;
          console.log("success");
        })
        .catch(err => {
          console.log("error");
        });
    },
    updateArrivalOrUpdateLeave(method) {
      let currentDate = dayjs().format("YYYY") + "-" + dayjs().format("MM");
      let attendancesDbDate =
        this.attendancesDbDates[0].date === undefined
          ? null
          : this.attendancesDbDates[0].date.slice(0, -3);

      if (currentDate === attendancesDbDate) {
        console.log("update");
        method();
      } else {
        this.storeDaysData();
        console.log("store");
      }
    },
    storeOrUpdateArrival() {
      this.updateArrivalOrUpdateLeave(this.updateArrival);
    },
    storeOrUpdateLeave() {
      this.updateArrivalOrUpdateLeave(this.updateLeave);
    }
  },
  computed: {
    currentMonth() {
      return dayjs().format("M");
    },
    currentMonth() {
      return dayjs().format("M");
    }
  }
};
</script>
