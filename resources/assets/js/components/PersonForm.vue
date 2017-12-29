<template>
    <div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="firstName">First Name</label>
                <input class="form-control" name="firstName" type="text" id="firstName">
            </div>
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input class="form-control" name="name" type="text" id="name">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="birthdate">Birthdate</label>
                <input class="form-control" name="birthdate" type="date" id="birthdate">
            </div>
            <div class="form-group col-md-6">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="M" selected="selected">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="language">Language</label>
            <select class="form-control" id="language" name="language">
                <option value="EN">English</option>
                <option value="NL">Nederlands</option>
                <option value="FR">French</option>
            </select>
        </div>
        <div class="form-group col-md-12">
            <div class="form-check">
                <input class="form-check-input" id="veg" name="veg" type="checkbox" value="veg">
                <label for="veg" class="form-check-label">Vegetarian</label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "person-form"
    }
</script>

<style scoped>

</style>