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
        <tr v-for="(displayDayData, index) in displayDaysData" :key="index">
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
    this.getAttendnaceData();
  },
  data() {
    return {
      displayDaysData: "",
      attendancesDbDates: "",
      userId: "",
      message: ""
    };
  },
  methods: {
    getAttendnaceData() {
      axios.get("/api/attendances").then(response => {
        this.displayDaysData = response.data;
        this.userId = response.data[0].user_id;
        this.attendancesDbDates = response.data;
      });
    },
    storeDaysData() {
      axios
        .post("/api/attendances", {
          displayDaysData: this.displayDaysData
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
          displayDaysData: this.displayDaysData
        })
        .then(response => {
          this.displayDayData = "";
        })
        .catch(err => {
          this.message = err;
        });
    },
    storeOrUpdate() {
      let currentDate = dayjs().format("YYYY") + "-" + dayjs().format("MM");
      let attendancesDbDate = this.attendancesDbDates[0].date === undefined ? null : this.attendancesDbDates[0].date.slice(0, -3);

      if (currentDate === attendancesDbDate) {
        this.updateDaysData();
      } else {
        this.storeDaysData();
        this.getAttendnaceData();
      }
    }
  },
  computed: {
    currentDayjs() {
      return dayjs();
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
