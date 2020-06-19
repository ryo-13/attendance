<template>
  <tr>
    <td>{{ currentMonth}}/{{ index+1}}</td>
    <td>
      <input type="time" @change="storeOrUpdateArrival" v-model="displayDayData.arrival" />
      <button type="button" @click="resetArrival" class="btn btn-danger ml-3">リセット</button>
    </td>
    <td>
      <input type="time" @change="storeOrUpdateLeave" v-model="displayDayData.leave" />
      <button type="button" @click="resetLeave" class="btn btn-danger ml-3">リセット</button>
    </td>
  </tr>
</template>

<script>
import dayjs from "dayjs";
dayjs.locale("ja");
export default {
  props: ["displayDayData", "index", "attendancesDbDates"],
  data() {
    return {
      attendancesDates: this.attendancesDbDates
    };
  },
  methods: {
    storeDaysData() {
      axios
        .post("/api/attendances", {
          displayDaysData: this.attendancesDates
        })
        .then(response => {
          console.log("success");
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
      console.log(this.displayDayData);
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
    storeOrUpdateArrival() {
      let currentDate = dayjs().format("YYYY") + "-" + dayjs().format("MM");
      let attendancesDbDate =
        this.attendancesDbDates[0].date === undefined
          ? null
          : this.attendancesDbDates[0].date.slice(0, -3);

      if (currentDate === attendancesDbDate) {
        this.updateArrival();
      } else {
        this.storeDaysData();
        this.$emit("callGetAttendance");
      }
    },
    storeOrUpdateLeave() {
      let currentDate = dayjs().format("YYYY") + "-" + dayjs().format("MM");
      let attendancesDbDate =
        this.attendancesDbDates[0].date === undefined
          ? null
          : this.attendancesDbDates[0].date.slice(0, -3);

      if (currentDate === attendancesDbDate) {
        this.updateLeave();
      } else {
        this.storeDaysData();
        this.$emit("callGetAttendance");
      }
    }
  },
  computed: {
    currentMonth() {
      return dayjs().format("M");
    }
  },
  computed: {
    currentMonth() {
      return dayjs().format("M");
    }
  }
};
</script>