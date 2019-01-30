<template>
    <table class="table table-striped table-bordered">
        <tbody>
        <tr v-for="(val,key) in element">
            <td class="text-info">{{ key }}</td>
            <td>{{ val }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
	export default {
	    props: ['element'],
	}
</script>
