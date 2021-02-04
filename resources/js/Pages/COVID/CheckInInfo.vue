<template slot-scope="info">
    <div>
        <b-container class="py-2">
            <h3>ยืนยันข้อมูลการเช็คอิน</h3>
        </b-container>
        <b-container class="py-1">
            <b-form-group id="input-group-1" label="ชื่อ:">
                <b-form-input id="input-1" v-model="info.name" type="text" disabled></b-form-input>
            </b-form-group>
            <b-form-group id="input-group-2" label="นามสกุล:">
                <b-form-input id="input-2" v-model="info.surname" type="text" disabled></b-form-input>
            </b-form-group>
            <b-form-group id="input-group-3" label="แคร์:">
                <b-form-input id="input-3" v-model="careoptions[info.care_group]" type="text" disabled></b-form-input>
            </b-form-group>
            <b-form-group id="input-group-4" label="โบสถ์:">
                <b-form-input id="input-4" v-model="church[info.church]" type="text" disabled></b-form-input>
            </b-form-group>
            <b-form-group id="input-group-5" label="คะแนนความเสี่ยง:">
                <b-form-input id="input-5" v-model="info.risk_score" type="text" disabled></b-form-input>
            </b-form-group>
            <b-form-group id="input-group-6" label="มาจากพื้นที่เสี่ยงหรือไม่:">
                <b-form-input id="input-6" v-model="riskArea[info.risk_type]" type="text" disabled></b-form-input>
            </b-form-group>
        </b-container>
        <b-container class="py-1">
            <b-button v-on:click="checkIn(info.id)">เช็คอิน</b-button>
        </b-container>
    </div>
</template>

<script>
export default {
    name: "CheckInInfo",
    props:{
        info: Object
    },
    data(){
        return{
            careoptions: {
                'saveone': 'แคร์เซฟวัน',
                'choho': 'แคร์จอหอ',
                'khoksung': 'แคร์โคกสูง',
                'mueang': 'แคร์อำเภอเมือง',
                'other': 'แคร์อื่นๆ',
                'nocare': 'ไม่เข้าร่วมแคร์'
            },
            church: {
                'n1': 'สานสัมพันธ์นครราชสีมา 1',
                'n2': 'สานสัมพันธ์นครราชสีมา 2',
                'nOther': 'สานสัมพันธ์ที่อื่นๆ',
                'other': 'โบสถ์อื่นๆ',
                'none': 'ไม่ได้เข้าโบสถ์'
            },
            riskArea: {
                '0': 'ไม่ได้มาจากพื้นที่เสี่ยง',
                '1': 'มาจากพื้นที่เสี่ยง',
                '2': 'มาจากพื้นที่เสี่ยง'
            }
        }
    },
    methods:{
        checkIn: function (id) {
            axios.post('/checkin',{
                user_id:id
            }).then((response) => {
                if(response.status === 200){
                    this.$swal({
                        'icon':'info',
                        'title':'แจ้งเตือน',
                        'text':"เช็คอินสำเร็จ"
                    }).then((result)=>{
                        if(result.isConfirmed){
                            window.location.assign('/viewPeople');
                        }
                    });
                }else{
                    this.$swal({
                        'icon':'info',
                        'title':'แจ้งเตือน',
                        'text':"เช็คไม่อินสำเร็จ"
                    }).then((result)=>{
                        if(result.isConfirmed){
                            window.location.reload();
                        }
                    });
                }
            }).catch((err) => {
                this.$swal({
                    'icon':'info',
                    'title':'แจ้งเตือน',
                    'text':"เช็คไม่อินสำเร็จ " + err.toString()
                }).then((result)=>{
                    if(result.isConfirmed){
                        window.location.reload();
                    }
                });
            })
        }
    }
}
</script>

<style scoped>

</style>
