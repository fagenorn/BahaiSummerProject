<template>
    <div class="person-form">
        <div>
            <h3>Information</h3>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>First Name
                        <input required class="form-control" :name="`rows[${index}][first_name]`" type="text"></label>
                </div>
                <div class="form-group col-lg-6">
                    <label>Name
                        <input required class="form-control" :name="`rows[${index}][last_name]`" type="text"></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>Date of Birth
                        <input required class="form-control" :name="`rows[${index}][dob]`"
                               type="daterange-single-dob"></label>
                </div>
                <div class="form-group col-lg-6">
                    <label>Gender
                        <select required class="form-control" :name="`rows[${index}][gender]`">
                            <option style="display:none;" disabled selected value> -- select an option --</option>
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                        </select></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>Attendance Language
                        <select required class="form-control" :name="`rows[${index}][language]`">
                            <option value="0">English</option>
                            <option value="1">Nederlands</option>
                            <option value="2">Français</option>
                        </select>
                    </label>
                </div>
                <div class="form-group col-lg-6">
                    <label>Diet
                        <select required class="form-control" :name="`rows[${index}][diet]`">
                            <option style="display:none;" disabled selected value> -- select an option --</option>
                            <option value="0">Standard</option>
                            <option value="1">Vegetarian</option>
                            <option value="2">Halal</option>
                            <option value="3">Self-catering</option>
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
                            <input class="form-check-input" @change="hideMeals" :name="`rows[${index}][full_stay]`"
                                   type="radio"
                                   checked value="1">
                            Entire Stay
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" @change="showMeals" :name="`rows[${index}][full_stay]`"
                                   type="radio"
                                   value="0">
                            Partial Stay
                        </label>
                    </div>
                    <div :class="`stay-meals-${index}`">
                        <div class="form-group col-lg-12">
                            <h4>Arrival</h4>
                            <div class="form-group">
                                <label>Days
                                    <input class="form-control" :name="`rows[${index}][arrival_date]`"
                                           type="daterange-single-stay"></label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio"
                                           :name="`rows[${index}][arrival_meal]`"
                                           value="0">
                                    Before Lunch
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" :name="`rows[${index}][arrival_meal]`"
                                           value="1">
                                    Before Dinner
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" :name="`rows[${index}][arrival_meal]`"
                                           value="2">
                                    After Dinner
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <h4>Departure</h4>
                            <div class="form-group">
                                <label>Days
                                    <input class="form-control" :name="`rows[${index}][departure_date]`"
                                           type="daterange-single-stay"></label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio"
                                           :name="`rows[${index}][departure_meal]`"
                                           value="0">
                                    Before Lunch
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio"
                                           :name="`rows[${index}][departure_meal]`"
                                           value="1">
                                    Before Dinner
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio"
                                           :name="`rows[${index}][departure_meal]`"
                                           value="2">
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
                    <div class="card">
                        <div class="card-header" role="tab" :id="`heading-prices-${index}`">
                            <h5 class="mb-0">
                                <a class="collapsed btn btn-primary" data-toggle="collapse" :href="`#prices-${index}`"
                                   aria-expanded="false" :aria-controls="`prices-${index}`">
                                    Show Prices
                                </a>
                            </h5>
                        </div>
                        <div :id="`prices-${index}`" class="collapse" role="tabpanel"
                             :aria-labelledby="`heading-prices-${index}`">
                            <div class="card-block">
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
                                        <th scope="col">Per day, excl. meals (<span
                                                :id="`heading-meal-prices-${index}`">Meal Prices</span>)
                                            <table :id="`meal-prices-${index}`"
                                                   class="table table-striped table-bordered">
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
                                        </th>
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
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>Type
                        <select required class="form-control" :name="`rows[${index}][acc_type]`">
                            <option style="display:none;" disabled selected value> -- select an option --</option>
                            <option value="0">Standard</option>
                            <option value="1">Deluxe</option>
                            <option value="2">No Accommodation</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type='hidden' :name="`rows[${index}][acc_single_room]`" value='0'>
                    <input class="form-check-input" :name="`rows[${index}][acc_single_room]`" type="checkbox" value="1">
                    Single-room preferred
                </label>
            </div>
            <div :id="`free-child-${index}`" class="form-check">
                <label class="form-check-label">
                    <input type='hidden' :name="`rows[${index}][acc_free_parent]`" value='0'>
                    <input class="form-check-input" type="checkbox" :name="`rows[${index}][acc_free_parent]`"
                           value="1"/>
                    This child is accompanied by a parent. I wish their stay to be free of charge. (Only one child per
                    parent)
                </label>
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
            $("input[name=rows\\[" + this.index + "\\]\\[dob\\]]").on('apply.daterangepicker', (e, picker) => {
                picker.element.val(picker.startDate.format(picker.locale.format));
                let dob = $("input[name=rows\\[" + this.index + "\\]\\[dob\\]]").data("daterangepicker").startDate;
                let age = Math.floor((new Date() - dob) / (365.25 * 24 * 60 * 60 * 1000));
                console.log(age);
                if (age <= 15) {
                    $("#free-child-" + this.index).slideDown();
                } else {
                    $("#free-child-" + this.index).slideUp();
                    $("input[name=rows\\[" + this.index + "\\]\\[acc_free_parent\\]]").prop('checked', false);
                }
            });
            $("input[name=rows\\[" + this.index + "\\]\\[arrival_date\\]]").on('apply.daterangepicker', (e, picker) => {
                picker.element.val(picker.startDate.format(picker.locale.format));
            });
            $("input[name=rows\\[" + this.index + "\\]\\[departure_date\\]]").on('apply.daterangepicker', (e, picker) => {
                picker.element.val(picker.startDate.format(picker.locale.format));
            });
            $("#heading-meal-prices-" + this.index).hover(() => {
                $("#meal-prices-" + this.index).fadeIn(500);
            }, () => {
                $("#meal-prices-" + this.index).fadeOut(100);
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