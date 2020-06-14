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
      <tbody>
        <tr v-for="(displayDayData, index) in displayDayDatas" :key="index">
          <td>{{ currentMonth}}/{{ index+1}}</td>
          <td>
            <input type="time" @change="storeOrUpdate" v-model="displayDayData.arrival" />
          </td>
          <td>
            <input type="time" @change="storeOrUpdate" v-model="displayDayData.leave" />
          </td>
        </tr>
      </tbody>
    </table>

    <p v-if="message">{{ message }}</p>
  </div>
</template>

<script>
import dayjs from "dayjs";
dayjs.locale("ja");

export default {
  created() {
    this.getAttendnace();
  },
  data() {
    return {
      displayDayDatas: "",
      userId: "",
      attendancesDatas: "",
      message: ""
    };
  },
  methods: {
    getAttendnace() {
      axios.get("/api/attendances").then(response => {
        this.displayDayDatas = response.data;
        this.userId = response.data[0].user_id;
        this.attendancesDatas = response.data;
      });
    },
    storeDaysData() {
      axios
        .post("/api/attendances", {
          displayDayDatas: this.displayDayDatas
        })
        .then(response => {
          this.displayDayData = "";
        })
        .catch(err => {
          this.message = err;
        });
    },
    updateDaysData() {
      axios
        .put("/api/attendances/" + this.userId, {
          displayDayDatas: this.displayDayDatas
        })
        .then(response => {
          this.displayDayData = "";
        })
        .catch(err => {
          this.message = err;
        });
    },
    storeOrUpdate() {
      let date = dayjs().format("YYYY") + "-" + dayjs().format("MM");
      let attendancesDate =
        this.attendancesDatas[0].date === undefined
          ? null
          : this.attendancesDatas[0].date.slice(0, -3);

      if (attendancesDate === date) {
        this.updateDaysData();
      } else {
        this.storeDaysData();
      }
    }
  },
  computed: {
    currentDayjs() {
      return dayjs();
    },
    daysData() {
      const numOfMonth = this.currentDayjs.endOf("month").date();
      const daysOfMonth = [...Array(numOfMonth).keys()].map(i => ++i);
      return daysOfMonth;
    },
    currentMonth() {
      return dayjs().format("M");
    },
    currentDayOfWeek() {
      return dayjs().format("ddd");
    }
  }
};
</script>