<template>

<div class="row gx-3 mb-3">
<!-- Form Group (organization name)-->
<div class="col-md-6">
    <label class="small mb-1" for="inputOrgName" >Pays</label>
    <select
        class="form-select"
        :class="[
          'country-inp-select--' + countryBgColor,
          'country-inp-select--' + countrySize,
          {
            'country-inp-select--rounded': countryRounded,
          },
        ]"
        aria-label="Default select country"
        v-model="selectedCountry"
        @change="fireState()"
        :value="value" @input="$emit('input', $event.target.value)"
      >
        <option selected hidden>Open this select menu</option>
        <option
          :value="country.id"
          v-for="country in countries"
          :key="country.id"
          :data-name="country.name"
        >
          {{ country.name }}
        </option>
      </select>

</div>
<!-- Form Group (location)-->
<div class="col-md-6">
    <label class="small mb-1" for="inputLocation">Gouvernorat</label>
    <select
        class="form-select"
        :class="[
          'state-inp-select--' + stateBgColor,
          'state-inp-select--' + stateSize,
          {
            'state-inp-select--rounded': stateRounded,
          },
        ]"
        :disabled="selectedCountry == ''"
        aria-label="Default select country"
        v-model="selectedState"
        @change="fireCity()"
      >
        <option hidden selected>Open this select menu</option>
        <option :value="state.id" v-for="state in states" :key="state.id" :data-name="state.name">
          {{ state.name }}
        </option>
      </select>
</div>
</div>

  </template>

  <script>
  import listCountries from "../../json/country.json";
  import listStates from "../../json/state.json";
  import listCities from "../../json/city.json";

  export default {
    data() {
      return {
        countries: listCountries,
        selectedCountry: "",
        selectedState: "",
        selectedCity: "",
        states: [],
        cities: [],
      };
    },
    computed: {
    selectedCountryName() {
        const selectedOption = this.countries.find(
        (country) => country.id === this.selectedCountry
        );
        return selectedOption ? selectedOption.name : '';
    },
    selectedStateName() {
    const selectedOption = this.states.find(
      (state) => state.id === this.selectedState
    );
    return selectedOption ? selectedOption.name : '';
  },
    },
    mounted() {},
    methods: {
      fireState() {
        this.states = [];
        listStates.map((state) => {
          if (state.country_id == this.selectedCountry) {
            this.states.push(state);
          } else {
            this.arrayRemove(this.states, state);
          }
        });
      },
      fireCity() {
        this.cities = [];
        listCities.map((city) => {
          if (city.state_id == this.selectedState) {
            this.cities.push(city);
          } else {
            this.arrayRemove(this.cities, city);
          }
          //pass the data
          const selectedCountryName = this.selectedCountryName;
          const selectedStateName = this.selectedStateName;
          this.$emit('countryStateChanged', {
            selectedCountry: selectedCountryName,
            selectedState: selectedStateName,
            // selectedCountry: this.selectedCountry.name,
            // selectedState: this.selectedState.name,

            });
            // console.log("value:"+this.selectedCountry);
        });
      },
      arrayRemove(arr, value) {
        return arr.filter(function (ele) {
          return ele != value;
        });
      },
    },
  };
  </script>

  <style >

  </style>
