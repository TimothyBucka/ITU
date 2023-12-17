<!-- Asi nevyuzijeme, ale mozno sa bude hodit v buducnosti -->
<template>
    <div class="time-picker-popup">
      <div class="viewport" @wheel.prevent="handleScroll">
        <div class="scroll-container" :style="{ transform: `translateY(${getOffset()}px)` }">
          <div v-for="value in timeRanges.hours" :key="value" class="time-unit" @click="selectValue(value)">
            {{ value }}
          </div>
        </div>
      </div>
      <div class="selected-time">
        Selected Time: {{ getSelectedTime() }}
      </div>
      <button class="btn btn-primary" @click="saveChanges">Save</button>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      initialValue: String,
    },
    data() {
      return {
        timeRanges: {
          hours: Array.from({ length: 24 }, (_, i) => i),
        },
        scrollOffsets: {
          hours: 0,
        },
        viewportHeight: 120, // Adjust this value based on your design
        unitHeight: 40, // Adjust this value based on your design
        scrollLock: false,
      };
    },
    methods: {
      handleScroll() {
        if (this.scrollLock) return;
        
        this.scrollLock = true;
        const scrollAmount = event.deltaY;
        const totalValues = this.timeRanges.hours.length;
        const maxOffset = (totalValues - 3) * this.unitHeight;
  
        this.scrollOffsets.hours += scrollAmount;
  
        if (this.scrollOffsets.hours < 0) {
          this.scrollOffsets.hours = 0;
        } else if (this.scrollOffsets.hours > maxOffset) {
          this.scrollOffsets.hours = maxOffset;
        }
  
        setTimeout(() => {
          this.scrollLock = false;
        }, 300); // Adjust the timeout duration based on your preference
      },
      getOffset() {
        return -this.scrollOffsets.hours + this.unitHeight * 1.5; // Center the selected value
      },
      saveChanges() {
        const selectedHour = this.getSelectedValue();
        const selectedTime = `${selectedHour}:00`; // Example of formatting the time
        this.$emit("save", selectedTime);
      },
      getSelectedValue() {
        const index = Math.round((this.scrollOffsets.hours + this.unitHeight * 1.5) / this.unitHeight);
        return this.timeRanges.hours[index];
      },
      getSelectedTime() {
        const selectedHour = this.getSelectedValue();
        return `${selectedHour}:00`; // Example of formatting the time
      },
      selectValue(value) {
        // Center the selected value when directly clicking on it
        const index = this.timeRanges.hours.indexOf(value);
        this.scrollOffsets.hours = index * this.unitHeight - this.unitHeight * 1.5;
      },
    },
  };
  </script>
  
  <style scoped>
  .time-picker-popup {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .viewport {
    height: 120px; /* Adjust this value based on your design */
    overflow-y: hidden;
    border: 1px solid #3498db; /* Bootstrap primary color */
    border-radius: 5px;
    margin-bottom: 20px;
  }
  
  .scroll-container {
    transition: transform 0.3s ease;
    will-change: transform;
  }
  
  .scroll-content {
    display: flex;
    flex-direction: column;
  }
  
  .time-unit {
    height: 40px; /* Adjust this value based on your design */
    line-height: 40px; /* Adjust this value based on your design */
    text-align: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .time-unit:hover {
    background-color: #3498db; /* Bootstrap primary color on hover */
    color: #fff; /* White text on hover */
  }
  
  .selected-time {
    font-size: 1.5rem;
    margin-bottom: 10px;
  }
  
  .btn-primary {
    background-color: #3498db; /* Bootstrap primary color */
    border-color: #3498db; /* Bootstrap primary color */
  }
  </style>