<template>
    <div class="person-form">
        <div>
            <h3>Information</h3>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>First Name
                        <input class="form-control" :name="`fName-${index}`" type="text"></label>
                </div>
                <div class="form-group col-lg-6">
                    <label>Name
                        <input class="form-control" :name="`name-${index}`" type="text"></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>Date of Birth
                        <input class="form-control" :name="`dob-${index}`"
                               type="daterange-single-dob"></label>
                </div>
                <div class="form-group col-lg-6">
                    <label>Gender
                        <select class="form-control" :name="`gender-${index}`">
                            <option style="display:none;" disabled selected value> -- select an option --</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>Attendance Language
                        <select class="form-control" :name="`language-${index}`">
                            <option value="EN">English</option>
                            <option value="NL">Nederlands</option>
                            <option value="FR">Français</option>
                        </select>
                    </label>
                </div>
                <div class="form-group col-lg-6">
                    <label>Diet
                        <select class="form-control" :name="`diet-${index}`">
                            <option style="display:none;" disabled selected value> -- select an option --</option>
                            <option value="standard">Standard</option>
                            <option value="vegetarian">Vegetarian</option>
                            <option value="halal">Halal</option>
                            <option value="self-catering">Self-catering</option>
                        </select>
                    </label>
                </div>
            </div>
        </div>
        <div>
            <h3>Stay</h3>
            <span class="help-block">The Summer School lasts from Friday 6th of July noon, to Tuesday 10th of July 4 pm. A commemoration for the martydom of the Báb will be held on Tuesday at 1 pm.</span>
            <div class="row">
                <div class="form-group col-lg-6">
                    <h4>Duration of Stay</h4>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" @change="hideMeals" :name="`stay-${index}`" type="radio"
                                   checked value="entire">
                            Entire Stay
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" @change="showMeals" :name="`stay-${index}`" type="radio"
                                   value="partial">
                            Partial Stay
                        </label>
                    </div>
                    <div :class="`stay-meals-${index}`">
                        <div class="form-group col-lg-12">
                            <h4>Arrival</h4>
                            <div class="form-group">
                                <label>Days
                                    <input class="form-control" :name="`daysArrival-${index}`"
                                           type="daterange-single-stay"></label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" checked type="radio" :name="`arrivalMeal-${index}`"
                                           value="arrivalLunch">
                                    Before Lunch
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" :name="`arrivalMeal-${index}`"
                                           value="arrivalDinner">
                                    Before Dinner
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" :name="`arrivalMeal-${index}`"
                                           value="arrivalNoMeal">
                                    After Dinner
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <h4>Departure</h4>
                            <div class="form-group">
                                <label>Days
                                    <input class="form-control" :name="`daysDeparture-${index}`"
                                           type="daterange-single-stay"></label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" checked type="radio"
                                           :name="`departurelMeal-${index}`"
                                           value="departureLunch">
                                    Before Lunch
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" :name="`departurelMeal-${index}`"
                                           value="departureDinner">
                                    Before Dinner
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" :name="`departurelMeal-${index}`"
                                           value="departureNoMeal">
                                    After Dinner
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h3>Accommodation</h3>
            <span class="help-block">This year, you have the choice between a regular room in the main building or a deluxe room in the Bed&Breakfast across the street.</span>
            <div class="row">
                <div class="form-group col-lg-12">
                    <h4>Prices</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th colspan="2" scope="col">Regular</th>
                            <th colspan="2" scope="col">Deluxe</th>
                            <th scope="col">No Accommodation</th>
                        </tr>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Full (incl. meals)</th>
                            <th scope="col">Partial (per day, incl. meals)</th>
                            <th scope="col">Full (incl. meals)</th>
                            <th scope="col">Partial (per day, incl. meals)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">Adults and children over 13</th>
                            <td>190 euros</td>
                            <td>50 euros</td>
                            <td>300 euros</td>
                            <td>80 euros</td>
                            <td>6 euros</td>
                        </tr>
                        <tr>
                            <th scope="row">Children under 2</th>
                            <td>Free</td>
                            <td>Free</td>
                            <td>Free</td>
                            <td>Free</td>
                            <td>Free</td>
                        </tr>
                        <tr>
                            <th scope="row">Children from 3 to 5 (50%)</th>
                            <td>95 euros</td>
                            <td>25 euros</td>
                            <td>150 euros</td>
                            <td>40 euros</td>
                            <td>6 euros</td>
                        </tr>
                        <tr>
                            <th scope="row">Children from 6 to 12 (30%)</th>
                            <td>133 euros</td>
                            <td>35 euros</td>
                            <td>210 euros</td>
                            <td>64 euros</td>
                            <td>6 euros</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>Type
                        <select class="form-control" :name="`accommodation-${index}`">
                            <option style="display:none;" disabled selected value> -- select an option --</option>
                            <option value="standard">Standard</option>
                            <option value="deluxe">Deluxe</option>
                            <option value="none">No Accommodation</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" value="singlePreferred">
                    Single-room preferred
                </label>
            </div>
            <div :id="`free-child-${index}`" class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" value="freeChild"/>
                    This child is accompanied by a parent. I wish their stay to be free of charge. (Only one child per
                    parent)
                </label>
            </div>
        </div>
        <div>
            <h3>Meals (reservation required)</h3>
            <div class="row">
                <div class="form-group col-lg-12">
                    <h4>Prices</h4>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Lunch</th>
                            <th scope="col">Dinner</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">Adults and children over 13</th>
                            <td>9 euros</td>
                            <td>12 euros</td>
                        </tr>
                        <tr>
                            <th scope="row">Children from 3 to 5</th>
                            <td>6 euros</td>
                            <td>7,20 euros</td>
                        </tr>
                        <tr>
                            <th scope="row">Children from 6 to 12</th>
                            <td>7 euros</td>
                            <td>9 euros</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['index'],
        name: "person-form",
        mounted: function () {
            initializeDates();
            $("input[name=dob-" + this.index + "]").on('apply.daterangepicker', () => {
                let dob = $("input[name=dob-" + this.index + "]").data("daterangepicker").startDate;
                let age = Math.floor((new Date() - dob) / (365.25 * 24 * 60 * 60 * 1000));
                console.log(age);
                if (age <= 15) {
                    $("#free-child-" + this.index).slideDown();
                } else {
                    $("#free-child-" + this.index).slideUp();
                }
            });
        },
        methods: {
            showMeals: function () {
                $(".stay-meals-" + this.index).slideDown()
            },
            hideMeals: function () {
                $(".stay-meals-" + this.index).slideUp()
            }
        }
    }
</script>

<style scoped>
</style>