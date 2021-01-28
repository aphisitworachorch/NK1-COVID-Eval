<template>
    <div>
        <b-container>
            <div v-for="(frm,i) in renderJSONForm(form)">
                <b-container>
                    <b-card>
                        <b-card-title class="py-1" v-bind:title="frm.questionaire_title"></b-card-title>
                        <b-card-text>
                            <div v-for="(qs,i,cnt) in frm.choices">
                                <CardChoice v-bind:choices_title="qs.title" v-bind:choices_num="cnt" v-bind:type="qs.choices_type"></CardChoice>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-container>
            </div>
            <b-button v-on:click="collectAllFrm">ส่งแบบสอบถาม</b-button>
        </b-container>
    </div>
</template>

<script>
import CardChoice from "@/Pages/COVID/components/CardChoice";
export default {
    name: "Evaluation",
    components: {CardChoice},
    props: {
        form: String
    },
    methods: {
        renderJSONForm: (data) => {
            let forms = JSON.parse(data);
            let ret = [];
            for (let v in forms) {
                if(forms[v]['questionaire_id'] === forms[v]["question_prototype"]['id']){
                    let s = [forms[v]['question_prototype']['sections_id']][v] = {
                        "id": forms[v]['id'],
                        "questionaire_id": forms[v]['questionaire_id'],
                        "choices": JSON.parse(forms[v]['choices']),
                        "questionaire_title": forms[v]['question_prototype']['question_title']
                    };
                    ret.push(s);
                }
            }
            return ret;
        },
        collectAllFrm: (data) => {

        }
    }
}
</script>

<style scoped>

</style>
