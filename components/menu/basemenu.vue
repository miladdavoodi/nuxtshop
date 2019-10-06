<template>
    <div class="NavMenu">
        <logo/>

        <ul>
            <li v-for="rw in menu">
                <div v-on:click="rw.open=!rw.open" class="fx">

                    <a-icon v-if="!rw.open" type="caret-left"/>
                    <a-icon v-if="rw.open" type="caret-down" />

                    <span>{{rw.title}} <i> / {{rw.subMenu.length}}</i></span>

                </div>
                <ul v-bind:class="{open:rw.open}">
                    <li v-for="n in rw.subMenu">
                        <div class="fx">
                            <a-icon type="swap-left"/>
                            <span>{{n.title}}</span>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</template>

<script>
    import logo from './logo'

    export default {
        data(){
            return{
                menu:[
                    {
                        title : "کالا ها",
                        open:false,
                        subMenu:[
                            {
                                title:"تعریف کالای جدید",
                                url:""
                            },
                            {
                                title:"لیست کالا ها",
                                url:""
                            },
                        ]
                    },
                    {
                        title : "سفارشات اصلی",
                        open:false,
                        subMenu:[
                            {
                                title:" سفارشات معلق",
                                url:""
                            },
                            {
                                title:"تاریخچه سفارشات",
                                url:""
                            },
                        ]
                    },
                    {
                        title : "مالی / حسابداری",
                        open:false,
                        subMenu:[
                            {
                                title:"لیست پرداختی ها",
                                url:"../../1"
                            },
                            {
                                title:"لیست پرداختی های ناموفق",
                                url:"../../3"
                            }
                        ]
                    },
                    {
                        title : "کدهای تخفیف",
                        open:false,
                        subMenu:[
                            {
                                title:"گزارش کدهای فعال سازی شده",
                                url:"../../1"
                            },
                            {
                                title:"پیمایش در لیست کد ها",
                                url:"../../2"
                            },
                            {
                                title:"ساخت کد تخفیف جدید",
                                url:"../../3"
                            }
                        ]
                    },
                    {
                        title : "سازمانی",
                        open:false,
                        subMenu:[
                            {
                                title:"لیست مشتریان سازمانی",
                                url:""
                            },
                            {
                                title:"لیست سفارشات سازمانی",
                                url:""
                            },
                        ]
                    },
                    {
                        title : "پرسنل",
                        open:false,
                        subMenu:[
                            {
                                title:"لیست کاربران سامانه",
                                url:""
                            },
                            {
                                title:"سطح دسترسی ها ",
                                url:""
                            },
                        ]
                    },
                ]
            }
        },
        components: {
            logo,
        }
    }
</script>
<style scoped>
    div.NavMenu {
        direction: rtl;
        background: #232b39;
        width: 280px;
        height: 100vh;
        position: relative;
        text-align: right;
        left: 0;
        top: 0;
    }
    div.NavMenu > ul > li {
        display: block;
        cursor: pointer;
        background: rgb(35,43,57);
        transition: all 0.4s;
    }
    div.NavMenu > ul > li:hover{

    }
    div.NavMenu > ul > li:not(:last-child){
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    div.NavMenu > ul > li div.fx {
        padding: 10px 20px;
    }

    div.NavMenu > ul > li > div.fx > span {
        color: #fff;
        font-family: IRANSansWeb_Bold, serif;
        display: inline-block;
        font-size: 15px;
    }
    div.NavMenu > ul > li > div.fx > span i{
        color: rgba(255,255,255,0.2);
        font-weight: normal !important;
        display: inline-block;
        margin-right: 10px;
        font-size: 12px;
    }

    div.NavMenu ul li svg {
        color: #b9926d;
        display: inline-block;
        margin-left: 10px;
    }

    div.NavMenu > ul > li ul {
        display: none;
        background: rgba(0, 0, 0, 0.4);
        padding: 10px 0;

    }
    div.NavMenu > ul > li ul.open{
        display: block;
    }

    div.NavMenu > ul > li ul li {
        color: #999;
        cursor: pointer;
        font-size: 13px;
    }
    div.NavMenu > ul > li ul li:hover,
    div.NavMenu > ul > li ul li.active{
        color: #fff;
    }
    div.NavMenu > ul > li ul li:hover div.fx{
        padding: 12px 25px 12px 0;
    }
    div.NavMenu > ul > li ul li:not(:last-child){
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    div.NavMenu > ul > li ul li div.fx{
        transition: all 0.4s;
        padding: 12px 20px;
    }
    div.NavMenu > ul > li ul li div.fx svg{
        font-size: 10px;
        transition: all 0.4s;
    }
    div.NavMenu > ul > li ul li:hover div.fx svg{
        font-size: 14px;
    }
</style>