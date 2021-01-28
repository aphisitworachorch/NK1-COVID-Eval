<template>
    <b-card v-bind:title="choices_title" v-bind:style="{margin: '10px'}">
        <b-card-text>กรุณาตอบทุกคำถามตามความเป็นจริง</b-card-text>
        <b-row>
            <div v-for="rad in type">
                <b-col>
                    <label>
                        <input type="radio" v-bind:name="'choices_'+choices_num" v-on:change="collectChoice(this.value)" v-bind:value="rad"/>
                        {{ choiceThai(rad) }}
                    </label>
                </b-col>
            </div>
        </b-row>
    </b-card>
</template>

<script>
export default {
    name: "CardChoice",
    props:{
        choices_num: Number,
        choices_title: String,
        type: Array
    },
    data(){
        return{
            choiceThai: (arr) => {
                let thaiLang = {
                    'true' : 'ใช่',
                    'false' : 'ไม่ใช่'
                }
                return thaiLang[arr]
            },
            choiceCollect: []
        }
    },
    methods:{
        collectChoice:(ch) => {
            this.choiceCollect.push(ch);
        }
    }
}
</script>

<style scoped>

</style>
