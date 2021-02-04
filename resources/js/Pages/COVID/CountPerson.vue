<template>
    <div>
        <b-container>
            <b-container class="py-2" style="text-align: center">
                <h3>ยอดทำแบบคัดกรองผู้ป่วยโรคติดเชื้อไวรัสโคโรน่า 2019 (COVID-19)</h3>
            </b-container>
            <b-container class="py-2" style="text-align: center">
                <h2>ยอดเช็คอิน : {{ counterQ }} คน</h2>
            </b-container>
            <b-container class="py-2" style="text-align: center">
                <b-button v-on:click="closeWindow">ปิดหน้าต่าง</b-button>
            </b-container>
        </b-container>
    </div>
</template>

<script>
export default {
    name: "CountPerson",
    props:{
        counterQ: Number
    },
    methods:{
        closeWindow: function(){
            let win = window.open("about:blank", "_self");
            win.close();
        }
    }
}
</script>

<style scoped>

</style>
