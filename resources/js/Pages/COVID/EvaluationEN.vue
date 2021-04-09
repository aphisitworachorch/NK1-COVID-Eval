<template>
    <div>
        <b-container class="py-2">
            <b-container class="py-1">
                <h3 style="text-align: center">NEXUS NAKHONRATCHASIMA 1</h3>
            </b-container>
            <b-container class="py-1">
                <h4 style="text-align: center">COVID-19 Evaluation Form</h4>
            </b-container>
            <form id="covnex">
            <b-container class="py-1" fluid="lg">
                <b-row>
                    <b-col sm>
                        <b-form-group id="fieldset-name" label="Name" label-for="info_name">
                            <b-form-input id="info_name" v-model="info.name" trim required></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col sm>
                        <b-form-group id="fieldset-surname" label="Surname" label-for="info_surname">
                            <b-form-input id="info_surname" v-model="info.surname" trim required></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col sm>
                        <b-form-group id="fieldset-care" label="Care Group" label-for="info_care">
                            <b-form-select v-model="info.care" :options="care" required></b-form-select>
                        </b-form-group>
                    </b-col>
                    <b-col sm>
                        <b-form-group id="fieldset-church" label="Church" label-for="info_church">
                            <b-form-select v-model="info.church" :options="church" required></b-form-select>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-container>
            <div v-for="(frm,x) in renderJSONForm(form)" class="py-3">
                <b-container>
                    <b-card>
                        <b-card-title class="py-1" v-bind:title="frm.questionaire_title"></b-card-title>
                        <b-card-text>
                            <div v-for="(qs,i,cnt) in frm.choices">
                                <b-container>
                                    <b-row>
                                        <b-form-group v-bind:label="qs.title">
                                            <b-form-radio-group
                                                v-model="choicesFrm[i]"
                                                v-bind:id="i"
                                                v-bind:name="i" required>
                                                <div v-for="rad in qs.choices_type">
                                                    <b-form-radio
                                                        :value="{'answer':rad,'questionaire_id':frm.questionaire_id,'choice':i,'weight':qs.weight}">
                                                        <span v-html="choiceThai(rad)"></span>
                                                    </b-form-radio>
                                                </div>
                                            </b-form-radio-group>
                                        </b-form-group>
                                    </b-row>
                                </b-container>
                            </div>
                        </b-card-text>
                    </b-card>
                </b-container>
            </div>
            </form>
            <b-container>
                <b-row>
                    <b-col>
                        <b-container>
                            <b-button class="btn btn-success" v-on:click="collectAllFrm">Send Form</b-button>
                        </b-container>
                    </b-col>
                </b-row>
            </b-container>
        </b-container>
    </div>
</template>

<script>
export default {
    name: "Evaluation",
    props: {
        form: String,
        care: Array,
        church: Array
    },
    metaInfo: {
        title: "COVID-19 Evaluation"
    },
    data() {
        return {
            choicesFrm: [],
            info:{
                name:'',
                surname:'',
                care:'',
                church:''
            },
            choiceThai: (arr) => {
                let thaiLang = {
                    'true': 'Yes',
                    'false': 'No'
                }
                return (thaiLang[arr]).toString()
            },
            getRiskToThai: (arr) => {
                let riskScore = 0;
                if(arr['weight'] >= 40){
                    riskScore = "high";
                }else if(arr['weight'] >= 30){
                    riskScore = "medium";
                }else if(arr['weight'] >= 10){
                    riskScore = "low";
                }else if(arr['weight'] <= 5){
                    riskScore = "no_risk";
                }
                if(arr['risk_province'] >= 1){
                    riskScore = "high_prov";
                }
                return ({
                    "high_prov":"High Risk ! Because You're from Controlled Area , Please Quarantine and Beware Yourself for 14 Days",
                    "high":"High Risk ! Please Quarantine and Beware Yourself for 14 Days",
                    "medium":"Medium Risk ! Please Quarantine and Beware Yourself for 14 Days",
                    "low":"Lower Risk ! Please Beware Yourself and Wear Masks",
                    "no_risk":"No Risk ! Please Beware Yourself and Wear Masks"
                })[riskScore];
            },
            thaiChana:function(){
                window.location.href = 'https://qr.thaichana.com/?appId=0001&shopId=SYWNmOWY2ZGNmNWZjNGY1YjhlNmRkODVjMmUwM2YxYjkwMDAwMjQxMzM1';
            }
        }
    },
    methods: {
        renderJSONForm: (data) => {
            let forms = JSON.parse(data);
            let ret = [];
            for (let v in forms) {
                if (forms[v]['questionaire_id'] === forms[v]["question_prototype"]['id']) {
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
        collectAllFrm: function () {
            let data = {
                "info":this.info,
                "choices":this.choicesFrm
            }
            if(this.info.name === '' || this.info.surname === '' || this.info.church === '' || this.info.care === '') {
                this.$swal({
                    'icon': 'error',
                    'title': 'Notice',
                    'text': 'Please Enter Information !'
                })
            }else{
                if (this.riskAssessment(data)){
                    console.log(this.riskAssessment(data))
                    this.$swal({
                        'icon':'info',
                        'title':'Risk Assessment',
                        'text':this.getRiskToThai(this.riskAssessment(data)),
                        'footer':'<a href="tel:+6644235000">Maharat Nakhon Ratchasima Hospital</a>'
                    }).then((result)=>{
                        if(result.isConfirmed){
                            this.$inertia.post('/covidans', {
                                "name":this.info.name,
                                "surname":this.info.surname,
                                "church":this.info.church,
                                "care_group":this.info.care,
                                "answers":this.riskAssessment(data),
                                "risk_score":this.riskAssessment(data)['weight'],
                                "risk_type":this.riskAssessment(data)['risk_province'],
                                "lang":"EN"
                            });
                        }
                    });
                }
            }

        },
        riskAssessment: (body) => {
            let choices = [];
            let weightscore = [];
            let veryhighrisk = [];
            for(let b in body.choices){
                choices.push(body.choices[b].answer);
                if(body.choices[b].answer === true){
                    if(body.choices[b].choice === "choice_1_4" || body.choices[b].choice === "choice_2_4"){
                        veryhighrisk.push(body.choices[b].answer);
                    }
                    weightscore.push(body.choices[b].weight);
                }else{
                    weightscore.push(0);
                }
            }
            let riskscore = {
                "true_false":(choices.filter(Boolean).length),
                "weight":(weightscore.reduce((cumulate,arr) => cumulate + arr,0)),
                "risk_province":(veryhighrisk.filter(Boolean).length)
            }
            return riskscore;
        }
    }
}
</script>

<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600&display=swap');
    body{
        font-family: 'Poppins', sans-serif;
    }
</style>
