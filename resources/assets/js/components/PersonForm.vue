<template>
    <div class="person-form">
        <div>
            <h3>Information</h3>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>First Name
                        <input class="form-control" name="firstName" type="text"></label>
                </div>
                <div class="form-group col-lg-6">
                    <label>Name
                        <input class="form-control" name="name" type="text"></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>Birthdate
                        <input class="form-control" name="birthdate" type="daterange-single"></label>
                </div>
                <div class="form-group col-lg-6">
                    <label>Gender
                        <select class="form-control" name="gender">
                            <option style="display:none;" disabled selected value> -- select an option --</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select></label>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>Attendance Language
                        <select class="form-control" name="language">
                            <option value="EN">English</option>
                            <option value="NL">Nederlands</option>
                            <option value="FR">Français</option>
                        </select>
                    </label>
                </div>
                <div class="form-group col-lg-6">
                    <label>Diet
                        <select class="form-control" name="diet">
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
            <div class="row">
                <div class="form-group col-lg-12">
                    <label>Days
                        <input class="form-control" name="stay" type="daterange-stay">
                    </label>
                </div>
            </div>
            <div class="stay-meals">
                <div class="form-group col-lg-12">
                    <h4>Arrival</h4>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="arrivalLunch">
                            Lunch
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="arrivalDinner">
                            Dinner
                        </label>
                    </div>
                </div>
                <div class="form-group col-lg-12">
                    <h4>Departure</h4>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="departureLunch">
                            Lunch
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="departureDinner">
                            Dinner
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h3>Accommodation</h3>
            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="gender">Type</label>
                    <select class="form-control" name="accommodation">
                        <option style="display:none;" disabled selected value> -- select an option --</option>
                        <option value="standard">Standard</option>
                        <option value="deluxe">Deluxe</option>
                    </select>
                </div>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" value="singlePreferred">
                    Single-room preferred
                </label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "person-form",
        mounted: function () {
            initializeDates();
        }
    }
</script>

<style scoped>

</style>