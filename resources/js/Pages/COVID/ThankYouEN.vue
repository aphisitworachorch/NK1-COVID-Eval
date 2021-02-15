<template v-bind:style="{ backgroundColor: getRiskColor(id).dark }">
    <div>
        <b-container class="card py-2">
            <b-container class="py-2" style="text-align: center">
                <h3>Thankyou</h3>
                <h5>Please bring this QR Code before Enter to Church Area</h5>
            </b-container>
            <b-container class="py-2">
                <b-row align-v="center">
                    <b-col sm>

                    </b-col>
                    <b-col sm>
                        <vue-qrcode v-bind:value="getQRCodeInfo(id)" :type="image/png" :maskPattern="2" :width="400" :margin="0" :color="getRiskColor(id)" v-bind:style="{padding: '30px',important:true }"/>
                    </b-col>
                    <b-col sm>

                    </b-col>
                </b-row>
            </b-container>
            <b-container class="py-2" style="text-align: center">
                <h5>Risk Score : {{ id.risk_score }} / 100 (Point)</h5>
            </b-container>
            <b-container class="py-2" style="text-align: center">
                <b-button v-on:click="closeWindow">Close</b-button>
            </b-container>
        </b-container>
    </div>
</template>

<script>
import VueQrcode from 'vue-qrcode'
export default {
    name: "ThankYouEN",
    props:{
        id: Object
    },
    components: {
        VueQrcode,
    },
    metaInfo: {
        title: "Thank You"
    },
    methods: {
        getRiskColor: function(ob){
            let riskScore = '';
            if(ob['risk_score'] >= 40){
                riskScore = {
                    'dark':'#EF3340',
                    'light':'#FFFFFF'
                };
            }else if(ob['risk_score'] >= 30){
                riskScore = {
                    'dark':'#FEDD00',
                    'light':'#FFFFFF'
                };
            }else if(ob['risk_score'] >= 10){
                riskScore = {
                    'dark':'#6CC24A',
                    'light':'#FFFFFF'
                };
            }else if(ob['risk_score'] <= 5){
                riskScore = {
                    'dark':'#418FDE',
                    'light':'#FFFFFF'
                };
            }
            if(ob['risk_type'] >= 1){
                riskScore = {
                    'dark':'#9F5CC0',
                    'light':'#FFFFFF'
                };
            }
            console.log(ob);
            return riskScore;
        },
        getQRCodeInfo: function (body){
            return (window.location.hostname+'/info/'+body.id);
        },
        closeWindow: function(){
            let win = window.open("about:blank", "_self");
            win.close();
        }
    }
}
</script>

<style scoped lang="css">
    .card{
        background: rgba( 255, 255, 255, 0.45 );
        box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
        backdrop-filter: blur( 3.0px );
        -webkit-backdrop-filter: blur( 3.0px );
        border-radius: 10px;
    }
</style>
