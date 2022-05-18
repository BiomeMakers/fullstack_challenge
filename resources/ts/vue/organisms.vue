<template>

   
   <div>

       <h2> Organism list ({{ organisms.length }}) </h2>

        <table class="pure-table pure-table-horizontal">
            <thead>
                <tr>
                    <th>Genus</th>
                    <th>Species</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="organism of organisms" :key="organism.id">
                    <td>{{ organism.genus }}</td>
                    <td>{{ organism.species }}</td>
                </tr>
            </tbody>
        </table>
   </div>


</template>


<style lang="scss" scoped >


</style>


<script lang="ts">

import {Vue, Component, Prop, Watch} from 'vue-property-decorator';
import axios from 'axios';

/**
 * Type of the organism
 */
type OrganismType = {
    genus: string;
    species: string;
}

@Component({})
export default class OrganismsVue extends Vue {

    organisms: OrganismType[] = [];
    mounted() {
        this.loadOrganisms();
    }

    /*
    * Retrieve the organism list from the api
    */
    async loadOrganisms() {
        var organismsRequest = (await axios.get('/api/organisms')).data;

        while (organismsRequest.next_page_url) {
            this.organisms.push(...organismsRequest.data)
            organismsRequest = (await axios.get(organismsRequest.next_page_url)).data;
        }
        this.organisms.push(...organismsRequest.data)
    }
}
</script>
