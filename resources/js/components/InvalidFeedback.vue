<template>
    <ul class="invalid-feedback" style="display:block" v-if="errors">
        <li v-for="fieldError in errors">
            {{ fieldError }}
        </li>
    </ul>
</template>

<script>
    export default {
        props: [
            'errors',
        ],
    }
</script>
