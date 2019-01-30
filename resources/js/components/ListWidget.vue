<template>
    <table class="table">
        <thead>
        <tr>
            <th v-for="(val,fieldName) in elements[Object.keys(elements)[0]]">
                {{ fieldName }}
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="element in elements">
            <td v-for="(val,fieldName) in element">
                <template v-if="fieldName === 'Actions'">
                    <span v-for="action in val">
                        <router-link :class="action.class" :to="action.to"></router-link>
                    </span>
                </template>
                <template v-else>
                    {{ val }}
                </template>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props:['elements'],
    }
</script>
