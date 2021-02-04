<template>
    <div>
        <b-container>
            <b-container class="py-2" style="text-align: center">
                <h3>ขอบคุณที่ทำแบบคัดกรองผู้ป่วยโรคติดเชื้อไวรัสโคโรน่า 2019 (COVID-19)</h3>
                <h5>โปรดยื่น QR Code ด้านล่างก่อนเข้าพื้นที่โบสถ์</h5>
            </b-container>
            <b-container class="py-2">
                <b-row align-v="center">
                    <b-col sm>

                    </b-col>
                    <b-col sm>
                        <vue-qrcode v-bind:value="getQRCodeInfo(id)" :maskPattern="2" :width="300" :color="getRiskColor(id)" :margin="0"/>
                    </b-col>
                    <b-col sm>

                    </b-col>
                </b-row>
            </b-container>
            <b-container class="py-2" style="text-align: center">
                <h5>คะแนนความเสี่ยง : {{ id.risk_score }} / 100 คะแนน</h5>
            </b-container>
            <b-container class="py-2" style="text-align: center">
                <b-button v-on:click="closeWindow">ปิดหน้าต่าง</b-button>
            </b-container>
        </b-container>
    </div>
</template>

<script>
import VueQrcode from 'vue-qrcode'
export default {
    name: "ThankYou",
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

<style scoped>

</style>
