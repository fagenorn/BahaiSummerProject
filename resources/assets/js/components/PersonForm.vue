<template>
    <div class="person-form">
        <div>
            <h3>{{ $t('index.information') }}</h3>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>{{ $t('index.first_name') }}
                        <input required class="form-control" :name="`rows[${index}][first_name]`" type="text"></label>
                </div>
                <div class="form-group col-lg-6">
                    <label>{{ $t('index.name') }}
                        <input required class="form-control" :name="`rows[${index}][last_name]`" type="text"></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>{{ $t('index.date_of_birth') }}
                        <input required class="form-control" :name="`rows[${index}][dob]`"
                               type="daterange-single-dob"></label>
                </div>
                <div class="form-group col-lg-6">
                    <label>{{ $t('index.gender') }}
                        <select required class="form-control" :name="`rows[${index}][gender]`">
                            <option style="display:none;" disabled selected value>-- {{ $t('index.select_option') }}
                                --
                            </option>
                            <option value="0">{{ $t('index.male') }}</option>
                            <option value="1">{{ $t('index.female') }}</option>
                        </select></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>{{ $t('index.attendance_language') }}
                        <select required class="form-control" :name="`rows[${index}][language]`">
                            <option value="0">{{ $t('index.english') }}</option>
                            <option value="1">{{ $t('index.dutch') }}</option>
                            <option value="2">{{ $t('index.french') }}</option>
                        </select>
                    </label>
                </div>
                <div class="form-group col-lg-6">
                    <label>{{ $t('index.diet') }}
                        <select required class="form-control" :name="`rows[${index}][diet]`">
                            <option style="display:none;" disabled selected value> -- {{ $t('index.select_option') }}
                                --
                            </option>
                            <option value="0">{{ $t('index.standard') }}</option>
                            <option value="1">{{ $t('index.vegetarian') }}</option>
                            <option value="2">{{ $t('index.self_catering') }}</option>
                        </select>
                    </label>
                </div>
            </div>
        </div>
        <div>
            <h3>{{ $t('index.stay') }}</h3>
            <span class="help-block">{{ $t('index.stay_message') }}</span>
            <div class="row">
                <div class="form-group col-lg-6">
                    <h4>{{ $t('index.duration_stay') }}</h4>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" @change="hideMeals" :name="`rows[${index}][full_stay]`"
                                   type="radio"
                                   checked value="1">
                            {{ $t('index.entire_stay') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" @change="showMeals" :name="`rows[${index}][full_stay]`"
                                   type="radio"
                                   value="0">
                            {{ $t('index.partial_stay') }}
                        </label>
                    </div>
                    <div :class="`stay-meals-${index}`">
                        <div class="form-group col-lg-12">
                            <h4>{{ $t('index.arrival') }}</h4>
                            <div class="form-group">
                                <label>{{ $t('index.days') }}
                                    <input class="form-control" :name="`rows[${index}][arrival_date]`"
                                           type="daterange-single-stay"></label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio"
                                           :name="`rows[${index}][arrival_meal]`"
                                           value="0">
                                    {{ $t('index.before_lunch') }}
                                    <small>({{ $t('index.bring_own_lunch') }})</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" :name="`rows[${index}][arrival_meal]`"
                                           value="1">
                                    {{ $t('index.before_dinner') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" :name="`rows[${index}][arrival_meal]`"
                                           value="2">
                                    {{ $t('index.after_dinner') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <h4>{{ $t('index.departure') }}</h4>
                            <div class="form-group">
                                <label>{{ $t('index.days') }}
                                    <input class="form-control" :name="`rows[${index}][departure_date]`"
                                           type="daterange-single-stay"></label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio"
                                           :name="`rows[${index}][departure_meal]`"
                                           value="0">
                                    {{ $t('index.before_lunch') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio"
                                           :name="`rows[${index}][departure_meal]`"
                                           value="1">
                                    {{ $t('index.before_dinner') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio"
                                           :name="`rows[${index}][departure_meal]`"
                                           value="2">
                                    {{ $t('index.after_dinner') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h3>{{ $t('index.accommodation') }}</h3>
            <span class="help-block">{{ $t('index.accommodation_message') }}</span>
            <div class="row">
                <div class="form-group col-lg-12">
                    <div class="card">
                        <div class="card-header" role="tab" :id="`heading-prices-${index}`">
                            <h5 class="mb-0">
                                <a class="collapsed btn btn-primary" data-toggle="collapse" :href="`#prices-${index}`"
                                   aria-expanded="false" :aria-controls="`prices-${index}`">
                                    {{ $t('index.show_prices') }}
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
                                        <th colspan="2" scope="col">{{ $t('index.regular') }}</th>
                                        <th colspan="2" scope="col">{{ $t('index.deluxe') }}</th>
                                        <th scope="col">{{ $t('index.no_accommodation') }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">{{ $t('index.full_with_meal') }}</th>
                                        <th scope="col">{{ $t('index.partial_with_meal') }}</th>
                                        <th scope="col">{{ $t('index.full_with_meal') }}</th>
                                        <th scope="col">{{ $t('index.partial_with_meal') }}</th>
                                        <th scope="col">{{ $t('index.per_day_without_meal') }} (<span
                                                :id="`heading-meal-prices-${index}`">{{ $t('index.meal_prices') }}</span>)
                                            <table :id="`meal-prices-${index}`"
                                                   class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{ $t('index.meal_warning') }}
                                                    </th>
                                                    <th scope="col">{{ $t('index.lunch') }}</th>
                                                    <th scope="col">{{ $t('index.dinner') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <th scope="row">{{ $t('index.adults_and_kids') }}</th>
                                                    <td>9 {{ $t('index.euros') }}</td>
                                                    <td>12 {{ $t('index.euros') }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{{ $t('index.children_3_5') }}</th>
                                                    <td>6 {{ $t('index.euros') }}</td>
                                                    <td>7,20 {{ $t('index.euros') }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{{ $t('index.children_6_12') }}</th>
                                                    <td>7 {{ $t('index.euros') }}</td>
                                                    <td>9 {{ $t('index.euros') }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">{{ $t('index.adults_and_kids') }}</th>
                                        <td>190 {{ $t('index.euros') }}</td>
                                        <td>50 {{ $t('index.euros') }}</td>
                                        <td>300 {{ $t('index.euros') }}</td>
                                        <td>80 {{ $t('index.euros') }}</td>
                                        <td>6 {{ $t('index.euros') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ $t('index.children_2') }}</th>
                                        <td>{{ $t('index.free') }}</td>
                                        <td>{{ $t('index.free') }}</td>
                                        <td>{{ $t('index.free') }}</td>
                                        <td>{{ $t('index.free') }}</td>
                                        <td>{{ $t('index.free') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ $t('index.children_3_5') }} (50%)</th>
                                        <td>95 {{ $t('index.euros') }}</td>
                                        <td>25 {{ $t('index.euros') }}</td>
                                        <td>150 {{ $t('index.euros') }}</td>
                                        <td>40 {{ $t('index.euros') }}</td>
                                        <td>6 {{ $t('index.euros') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ $t('index.children_6_12') }} (30%)</th>
                                        <td>133 {{ $t('index.euros') }}</td>
                                        <td>35 {{ $t('index.euros') }}</td>
                                        <td>210 {{ $t('index.euros') }}</td>
                                        <td>64 {{ $t('index.euros') }}</td>
                                        <td>6 {{ $t('index.euros') }}</td>
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
                    <label>{{ $t('index.type') }}
                        <select required class="form-control" :name="`rows[${index}][acc_type]`">
                            <option style="display:none;" disabled selected value> -- {{ $t('index.select_option') }}
                                --
                            </option>
                            <option value="0">{{ $t('index.standard') }}</option>
                            <option value="1">{{ $t('index.deluxe') }}</option>
                            <option value="2">{{ $t('index.no_accommodation') }}</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type='hidden' :name="`rows[${index}][acc_single_room]`" value='0'>
                    <input class="form-check-input" :name="`rows[${index}][acc_single_room]`" type="checkbox" value="1">
                    {{ $t('index.single_room_preferred') }}
                </label>
            </div>
            <div :id="`free-child-${index}`" class="form-check">
                <label class="form-check-label">
                    <input type='hidden' :name="`rows[${index}][acc_free_parent]`" value='0'>
                    <input class="form-check-input" type="checkbox" :name="`rows[${index}][acc_free_parent]`"
                           value="1"/>
                    {{ $t('index.child_with_parent') }}
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